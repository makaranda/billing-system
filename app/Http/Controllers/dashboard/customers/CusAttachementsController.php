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
use App\Models\CustomerPayments;
use App\Models\AcAccounts;
use App\Models\BankAccounts;
use App\Models\CardTypes;
use App\Models\Banks;
use App\Models\SequentialNumber;
use App\Models\Archives;
use App\Models\ArchiveCategories;

class CusAttachementsController extends Controller
{
    public function index($route = null){
        $route = $route ?? 'index.customers';
        $route = $route ?? 'home';
        $data = session('data');

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
        //$systemUsersDetails = SystemUsers::all();


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
        $getAllSystemUsers = SystemUsers::where('status',1)->orderBy('full_name','ASC')->get();
        $productCategories = ProductCategories::where('status', 1)->get();
        $getAllCustomerGroup = CustomerGroup::where('status', 1)->get();
        $getAllcurrencies = Currencies::where('status', 1)->get();
        $getAllterritories = Territories::where('status', 1)->get();
        $getAllCardTypes = CardTypes::where('status', 1)->get();
        $getAllBanks = Banks::where('status', 1)->get();
        $getCurrencySymbol = Currencies::where('status', 1)->where('is_base', 1)->get();

        $getArchiveCategories = ArchiveCategories::where('status', 1)->orderBy('name','ASC')->get();

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
            return view('pages.dashboard.customers.cusattachements', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions','getArchiveCategories','productCategories','getAllSystemUsers'));
        }
    }

    public function getCustomersNames(Request $request){
        if ($request->has('search') && !empty($request->search)) {
            $query = Customers::query();

            if ($request->has('active') && $request->active > 0) {
                $query->where('active', $request->active);
            } else {
                $query->where('active', 1);
            }

            $query->where('status', 1)
                  ->where(function($q) use ($request) {
                      $q->where('company', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('code', 'LIKE', '%' . $request->search . '%');
                  })
                  ->orderBy('company', 'ASC')
                  ->limit(200);

            $data = $query->get(['id', 'company', 'code']);
            $response = $data->map(function($row) {
                return [
                    "value" => $row->id,
                    "label" => $row->company . " - " . $row->code
                ];
            });

            return response()->json($response);
        }

        return response()->json([]);
    }

    public function updateAttachement(Request $request){
        $validator = Validator::make($request->all(), [
            'update_category' => 'required|integer',
            'update_description' => 'required|string|max:1000',
            'update_reminder_date' => 'required|date',
            'update_edit_id' => 'required|integer|exists:archives,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => implode(', ', $validator->errors()->all()),
                'messageType' => 'error'
            ]);
        }

        // Find the existing archive record
        $archive = Archives::find($request->update_edit_id);

        if (!$archive) {
            return response()->json([
                'message' => 'Archive not found.',
                'messageType' => 'error'
            ]);
        }

        // Update the archive record
        $archive->category_id = $request->update_category;
        $archive->description = $request->update_description;
        $archive->reminder_date = $request->update_reminder_date;
        $archive->updated_at = now();

        $archive->save();

        return response()->json([
            'message' => 'Archive successfully updated!',
            'messageType' => 'success'
        ]);
    }

    public function addAttachement(Request $request){

        $messageType = '';
        $message = '';
        //archive_date  customer_name  category  description  reminder_date  file
        $validator = Validator::make($request->all(), [
            'archive_date' => 'required|date',
            'customer_id' => 'required',
            'category' => 'required|integer',
            'description' => 'required|string|max:1000',
            'reminder_date' => 'required|date',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            // Return validation errors if validation fails
            return response()->json([
                'message' => implode(', ', $validator->errors()->all()),
                'messageType' => 'error'
            ]);
        }

        // Handle the file upload
        if ($request->hasFile('file')) {
            // Define the file path and create it if it doesn’t exist
            $file = $request->file('file');
            $filename = $request->customer_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'assets/uploads/customer/';

            // Store the file and retrieve the file path
            $storedFilePath = $file->move(public_path($filePath), $filename);

            // Prepare the data for insertion
            $proData = [
                'archive_date' => $request->archive_date,
                'customer_id' => $request->customer_id,
                'category_id' => $request->category,
                'description' => $request->description,
                'reminder_date' => $request->reminder_date,
                'file' => $filePath . $filename, // Store the relative path
                'uploaded_by' => Auth::user()->id,
            ];

            // Save data to the Archives model
            $addDatas = new Archives();
            $addDatas->fill($proData);
            $addDatas->save();

            $messageType = 'success';
            $message = 'Archive has been successfully added!';
        } else {
            $messageType = 'error';
            $message = 'File upload failed, please try again!';
        }

        // Return JSON response
        return response()->json([
            'message' => $message,
            'messageType' => $messageType
        ]);

        return response()->json($responseData);
    }

    public function editAttachement(Request $request){
        $getAttachementsDatas = Archives::where('id',$request->id)->where('status',1)->first();

        if (!$getAttachementsDatas) {
            return response()->json(['error' => 'Customers Attachements are not found'], 404);
        }
        $responseData = [
            'customer_attachements' => $getAttachementsDatas
        ];

        return response()->json($responseData);
    }

    public function fetchAttachements(Request $request){

        $query = Archives::query();
        //$getAllRoutePermisssions = AcAccounts::all();
        //s_code s_name s_status s_type search_customer_id
        if ($request->has('customer_group') && $request->customer_group != null && $request->customer_group > 0) {
            $customerIds = Customers::where('group_id', $request->customer_group)->pluck('id');
            $query->whereIn('customer_id', $customerIds);
        }
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', '=', '' . $request->category . '');
        }
        if ($request->has('from_date') && $request->from_date != '') {
            $query->where('date', '>=', '' . $request->from_date . '');
        }
        if ($request->has('to_date') && $request->to_date != '') {
            $query->where('date', '<=', '' . $request->to_date . '');
        }
        if ($request->has('reminder_from_date') && $request->reminder_from_date != '') {
            $query->where('reminder_date', '>=', '' . $request->reminder_from_date . '');
        }
        if ($request->has('reminder_to_date') && $request->reminder_to_date != '') {
            $query->where('reminder_date', '<=', '' . $request->reminder_to_date . '');
        }
        if ($request->has('search_customer_id') && $request->search_customer_id != '') {
            $query->where('customer_id', '=', '' . $request->search_customer_id . '');
        }else{
            $query->where('customer_id', '>', 0);
        }
        if ($request->has('user') && $request->user != '') {
            $query->where('uploaded_by', '=', '' . $request->user . '');
        }
        if ($request->has('description') && $request->description != '') {
            $query->where('description', 'LIKE', '%' . $request->description . '%');
        }
        if ($request->has('reference') && $request->reference != '') {
            $query->where('reference', 'LIKE', '%' . $request->reference . '%');
        }
        $query->where('status', 1);

        $query->orderBy('id', 'DESC');
        $query->limit(200);

        $fetchTableDetails = $query->get();
        //$fetchTableDetails = Currencies::all();

        $responses = '';

        $debit_total = 0;
        $credit_total = 0;

        //$sqlQuery = $query->toSql();
        //$bindings = $query->getBindings();
        //dd(vsprintf(str_replace('?', '%s', $sqlQuery), $bindings));


        //$fetchTableDetails = $query->paginate(100);
        $responses = view('pages.dashboard.customers.tables.fetch_attachements_table', compact('fetchTableDetails'))->render();

        return response()->json(['html' => $responses,'is_posted' => $request->is_posted]);
    }
}
