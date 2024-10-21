<?php

namespace App\Http\Controllers\dashboard\customers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\SystemMenus;
use App\Models\PermissionsTypes;
use App\Models\RoutesPermissions;
use App\Models\SystemUsers;

use App\Models\ProductCategories;
use App\Models\Customers;
use App\Models\CollectionBureaus;
use App\Models\PriceTypes;
use App\Models\Branches;
use App\Models\CustomerGroup;
use App\Models\Currencies;
use App\Models\Territories;
use App\Models\CustomerTransactions;
use App\Models\AcAccounts;
use App\Models\Products;
use App\Models\DebtAssignments;
use App\Models\Invoices;

class CusDebtManagementController extends Controller
{
    public function index($route = null){
        $route = $route ?? 'index.customers';
        $route = $route ?? 'home';
        $request = session('data');

        $mainMenus = SystemMenus::whereNull('parent_id')
                                ->orderBy('order')
                                ->get();
        $subsMenus = SystemMenus::where('route',$route)
                                ->orderBy('order')
                                ->get();

        foreach ($subsMenus as $submenu) {
            $submenu->subMenus = $submenu->orderBy('order')->get();
        }
        foreach ($mainMenus as $menu) {
            $menu->subMenus = $menu->children()->orderBy('order')->get();
        }

        $getRoutename = request()->route()->getName();
        $routesPermissions = RoutesPermissions::where('route',$getRoutename)->orderBy('id')->get();
        $getAllRoutePermisssions = RoutesPermissions::all();
        foreach ($routesPermissions as $routesPermission) {
            $routesPermission = $routesPermission->orderBy('id')->get();
        }

        $permissionsTypes = PermissionsTypes::all();



        $routepermissions = [];
        foreach ($permissionsTypes as $permissionsType) {
            $routepermissions[$permissionsType->name] = 0;
        }

        $getAllRoutePermisssionsUser = RoutesPermissions::where('user_id', Auth::user()->id)
                                                        ->where('route', $getRoutename)
                                                        ->get();
        $getAllCollectionBureaus = CollectionBureaus::where('status',1)->get();
        $getAllPriceTypes = PriceTypes::where('status',1)->get();
        $getAllBranches = Branches::where('status',1)->get();
        $getAllProductCategories = ProductCategories::where('status', 1)->get();
        $getAllCustomerGroup = CustomerGroup::where('status', 1)->get();
        $getAllcurrencies = Currencies::where('status', 1)->get();
        $getAllterritories = Territories::where('status', 1)->get();
        $getAllProducts = Products::where('status', 1)->get();
        $getAllCustomers = Customers::where('status', 1)->get();
        $getAllSystemUsers = SystemUsers::where('status', 1)->get();

        $currentRoute = request()->route()->getName();
        $parentRoute = 'index.' . explode('.', $currentRoute)[0];
        foreach ($permissionsTypes as $permissionsType) {
            $type = $permissionsType->permission_type;

            // Check if the user has this permission for the current route or parent route
            $hasPermission = $getAllRoutePermisssionsUser->contains(function ($permission) use ($type, $currentRoute, $parentRoute) {
                return $permission->permission_type == $type && ($permission->route == $currentRoute || $permission->route == $parentRoute);
            });

            // Update the routepermissions array
            $routepermissions[$type] = $hasPermission ? 1 : 0;
        }
        $debt_collector_name = "***";
        if(session()->has('DCID')){
            $userData = SystemUsers::where('status', 1)->where('id', session('DCID'))->first();
            if($userData){
                $debt_collector_name = $userData->full_name;
            }
        }

        $remindersRoute = request()->route()->getName();
        $parentid = 3;
        $mainRouteName = 'index.customers';
        //dd($mainMenus);
        $countCheckThisRoutes = RoutesPermissions::where('route', $getRoutename)
        ->where('user_id', Auth::user()->id)
        ->where('main_route', $mainRouteName)
        ->count();
        if($countCheckThisRoutes == 0){
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this route.');
        }else{
            return view('pages.dashboard.customers.cusdebtmanagement', compact('mainMenus','subsMenus','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions','getAllCollectionBureaus','getAllterritories','getAllProducts','getAllCustomers','getAllSystemUsers','debt_collector_name','getAllProductCategories'));
        }
    }

    public function assignDebtCollector(Request $request){
        $message = '';
        $messageType = '';

        // Check if customer_id or customer_ids are set
        if (isset($request->customer_id) || isset($request->customer_ids)) {
            // If customer_id is set, assign it as an array for easier iteration
            if ($request->customer_id > 0) {
                $customer_ids = [$request->customer_id];
            } else {
                $customer_ids = is_array($request->customer_ids)
                        ? $request->customer_ids
                        : explode(',', $request->customer_ids);
            }

            $i = 0; // Total number of customers
            $j = 0; // Number of successfully assigned debts

            // Loop through all customer_ids
            foreach ($customer_ids as $customerId) {
                $dcid = $request->dcid;
                $report_date = $request->report_date;
                $collection_date = $request->collection_date;
                $created_by = Auth::user()->id;
                $working_date = now()->format('Y-m-d'); // Assuming WORKING_DATE is current date

                $i++;

                // Check if the customer is already assigned for the given working date
                $existingAssignment = DebtAssignments::where('assigned_date', $working_date)
                    ->where('customer_id', $customerId)
                    ->where('status', 1)
                    ->first();

                // If no existing assignment, proceed with insertion
                if (!$existingAssignment) {
                    // Create new debt assignment record
                    $debtAssignment = DebtAssignments::create([
                        'user_id' => $dcid,
                        'customer_id' => $customerId,
                        'assigned_date' => $working_date,
                        'assigned_upto' => $report_date,
                        'collection_date' => $collection_date,
                        'assigned_by' => $created_by
                    ]);

                    if ($debtAssignment) {
                        // Update invoices related to the customer
                        Invoices::where('customer_id', $customerId)
                            ->where('is_paid', 0)
                            ->where('date', '<', $report_date)
                            ->update(['debt_collector_id' => $dcid]);

                        // Success message
                        $message = "Debts up to $report_date have been successfully assigned to the selected debt collector.";
                        $messageType = 'success';
                        $j++;
                    } else {
                        $message = "Failed to assign selected debts to the collector. Please try again!";
                        $messageType = 'error';
                    }
                } else {
                    $message = "Selected customer is already assigned to a debt collector for this meeting.";
                    $messageType = 'error';
                }
            }

            // If multiple customers were processed, return summary
            if ($i > 1) {
                $message = "$j out of $i debts assigned successfully.";
            }
        } else {
            $messageType = 'error';
            $message = 'Customer ID or customer IDs are required. Please try again!';
        }

        // Prepare response data
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];

        // Return JSON response
        return response()->json($responseData);
    }

    public function fetchFilteredDebt(Request $request){
        $getAcAccounts = AcAccounts::where('control_type', 'LIKE', '%debtors_control%')->first();
        $getCustomerTransactions = CustomerTransactions::where('status', '=', 1)->get();

        if(isset($getAcAccounts->id)){
            $debtors_control_account = $getAcAccounts->id;
            // $fetchTableDetails = DB::table('customer_transactions as a')
            // ->join(DB::raw('(SELECT MAX(customer_transactions.id) AS id
            //                 FROM customer_transactions
            //                 INNER JOIN debt_assignments
            //                 ON debt_assignments.customer_id = customer_transactions.customer_id
            //                 WHERE customer_transactions.nominal_account_id = ?
            //                 AND ((customer_transactions.transaction_type IN (?, ?)
            //                 AND customer_transactions.effective_date <= ?)
            //                 OR customer_transactions.effective_date <= ?)
            //                 GROUP BY customer_transactions.customer_id) as b'), 'a.id', '=', 'b.id')
            // ->join('customers as c', 'c.id', '=', 'a.customer_id')
            // ->select(
            //     'a.*',
            //     'c.code',
            //     'c.company',
            //     'c.active'
            // )
            // ->setBindings([$debtors_control_account, 'proforma', 'invoice', $collection_date, $collection_date])
            // ->get(); code

            $fetchTableDetails = DB::table('customer_transactions as a')
                ->join(DB::raw('(SELECT MAX(customer_transactions.id) AS id
                                FROM customer_transactions
                                INNER JOIN debt_assignments
                                ON debt_assignments.customer_id = customer_transactions.customer_id
                                WHERE customer_transactions.nominal_account_id = ' . intval($debtors_control_account) . '
                                AND ((customer_transactions.transaction_type IN (\'proforma\', \'invoice\')
                                AND customer_transactions.effective_date <= \'' . $request->collection_date . '\')
                                OR customer_transactions.effective_date <= \'' . $request->collection_date . '\')
                                GROUP BY customer_transactions.customer_id
                                ) as b'), 'a.id', '=', 'b.id')
                // Join the customers table
                ->join('customers as c', 'c.id', '=', 'a.customer_id')

                // Add the select statement to retrieve necessary fields
                ->select(
                    'a.*',            // All columns from customer_transactions
                    'c.code',         // Customer code from customers table
                    'c.company',      // Customer company from customers table
                    'c.active'        // Customer active status from customers table
                );

            // Add conditional customer_id filter
            if (isset($request->customer_id) && $request->customer_id > 0) {
                $fetchTableDetails->where('a.customer_id', $request->customer_id);
            }

            // Add conditional subquery filters for customer data
            if (
                (isset($request->cutomer_territory) && $request->cutomer_territory > 0) ||
                (isset($request->customer_group_id) && $request->customer_group_id > 0) ||
                (isset($request->collection_bureau_id) && $request->collection_bureau_id > 0) ||
                (isset($request->customer_active))
            ) {
                $fetchTableDetails->whereIn('a.customer_id', function ($query) use ($request) {
                    $query->select('id')
                        ->from('customers')
                        ->whereRaw('1 = 1'); // Placeholder for adding dynamic conditions

                    if (isset($request->cutomer_territory) && $request->cutomer_territory > 0) {
                        $query->where('territory_id', $request->cutomer_territory);
                    }

                    if (isset($request->customer_group_id) && $request->customer_group_id > 0) {
                        $query->where('group_id', $request->customer_group_id);
                    }

                    if (isset($request->collection_bureau_id) && $request->collection_bureau_id > 0) {
                        $query->where('collection_bureau_id', $request->collection_bureau_id);
                    }

                    if (isset($request->customer_active)) {
                        $query->where('active', $request->customer_active);
                    }
                });
            }

            // Add report_date condition
            if (isset($request->report_date) && !empty($request->report_date)) {
                $fetchTableDetails->where('a.transaction_date', '<=', $request->report_date);
            }

            // Group by customer_id
            $fetchTableDetails->groupBy('a.customer_id');

            // Additional conditions: min_value and debt_assignment exclusions
            if (isset($request->min_value) && $request->min_value >= 0) {
                $fetchTableDetails->having('a.customer_balance', '>', ''.$request->min_value.'');
            }

            $fetchTableDetails->whereNotIn('a.customer_id', function ($query) use ($request) {
                $query->select('customer_id')
                    ->from('debt_assignments')
                    ->where('assigned_date', $request->working_date);
            });

            // Handle ordering
            if (isset($request->order) && !empty($request->order)) {
                $fetchTableDetails->orderByRaw($request->order);
            }

            // Handle limiting
            if (isset($request->limit) && !empty($request->limit)) {
                $fetchTableDetails->limit($request->limit);
            }

            // Execute the query
            //$results = $fetchTableDetails->get();
            $results = $fetchTableDetails->paginate(100);
            $sql_query = $fetchTableDetails->toSql();
            //exit();
            $responses = view('pages.dashboard.customers.tables.debt_filtered_table', compact('results'))->render();
        }else{
            $responses = '<h6>Debtors control account not setup in the system, Please try again !</h6>';
        }
        return response()->json(['html' => $responses]);
        //return response()->json(['html' => $sql_query]);
    }

    public function viewDebtManagement(Request $request){
        return view('pages.dashboard.customers.cusviewdebtmanagement');
    }

    public function fetchDebtManagement(Request $request){

        session([
            'report_from_date' => $request->from_date,
            'report_to_date' => $request->to_date,
            'report_user_id'  => $request->user_id
        ]);

        $query = DebtAssignments::query();

        if ($request->has('id') && $request->id != '') {
            $query->where('id', '=', '' . $request->id . '');
        }
        if ($request->has('from_date') && $request->from_date != '') {
            $query->where('assigned_date', '>=', '' . $request->from_date . '');
        }
        if ($request->has('to_date') && $request->to_date != '') {
            $query->where('assigned_date', '<=', '' . $request->to_date . '');
        }
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', '=', '' . $request->user_id . '');
        }

        $query->where('status', 1);
        $query->groupBy('assigned_date', 'user_id');
        $query->orderBy('assigned_date', 'DESC'); // Default ordering

        $fetchTableDetails = $query->get();
        //$fetchTableDetails = Currencies::all();

        $responses = '';

        $debit_total = 0;
        $credit_total = 0;

        $fetchTableDetails = $query->paginate(100);

        $getAcAccounts = AcAccounts::where('control_type','LIKE', '%debtors_control%')->first();
        $system_users = SystemUsers::where('status', 1)->get();
        $debtors_control_account = $getAcAccounts ? $getAcAccounts->id : 0;

        //var_dump($customer_balance);
        //$parentRoute = 'index.productcategories';
        $sqlQuery = $query->toSql();
        $bindings = $query->getBindings();

        // Print the SQL and bindings for debugging
        //dd($sqlQuery, $bindings);
        //exit();
        $responses = view('pages.dashboard.customers.tables.debt_assignments_table', compact('fetchTableDetails'))->render();

        return response()->json(['html' => $responses]);
    }
}
