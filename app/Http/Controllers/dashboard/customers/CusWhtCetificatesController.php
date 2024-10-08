<?php

namespace App\Http\Controllers\dashboard\customers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\SystemMenus;
use App\Models\PermissionsTypes;
use App\Models\RoutesPermissions;
use App\Models\SystemUsers;
use App\Models\Customers;
use App\Models\CustomerPayments;
use App\Models\Currencies;
use App\Models\CustomerWhtAttachments;

class CusWhtCetificatesController extends Controller
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

        $getAllCustomers = Customers::where('status','=', 1)
                                      ->get();

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
            return view('pages.dashboard.customers.cuswhtcetificates', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions','getAllCustomers'));
        }
    }

    public function updateWhtCetificate(Request $request,$pro_id){
        $messageType = '';
        $message = '';

        $validator = Validator::make($request->all(), [
            'receipt_id' => 'required|exists:customer_payments,id',
            'attachment_id' => 'required',
            'file' => 'required|file|mimes:jpg,png,pdf,jpeg|max:10240',
        ]);

        try {
            // Retrieve input values
            if ($validator->fails()) {
                $messageType = 'error';
                $message = $validator->errors()->first();;
            }else{
                $receipt_id = $request->input('receipt_id');
                $receipt_type = $request->input('attachment_id');
                $file = $request->file('file');

                // Generate unique file name
                $filename = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
                // Define file path
                $filepath = 'uploads/wht-attachments/';
                // Full path to store the file
                $fullPath = public_path($filepath . $filename);

                // Move the file to the public directory
                $file->move(public_path($filepath), $filename);

                // Save relative path in the database
                $path = $filepath . $filename;

                if(isset($request->attachment_id) && $request->attachment_id > 0){

                    $getWhtAtt = CustomerWhtAttachments::find($request->attachment_id);
                    $proData = [
                        'type' => $receipt_type,
                        'receipt_id' => $receipt_id,
                        'date' => now(),
                        'file_name' => $path,
                        'status' => 1,
                        'uploaded_by' => Auth::user()->id,
                    ];
                    $getWhtAtt->update($proData);
                }else{
                    // Save the file and metadata in the database
                    $proData = [
                        'type' => $receipt_type,
                        'receipt_id' => $receipt_id,
                        'date' => now(),
                        'file_name' => $path,
                        'status' => 1,
                        'uploaded_by' => Auth::user()->id,
                    ];

                    // Assuming DepartmentHead is the model class for the table
                    $addDatas = new CustomerWhtAttachments();
                    // Save the data
                    $addDatas->fill($proData);
                    $addDatas->save();
                }

                $messageType = 'success';
                $message = 'You have successfully Updated the Bank Deposit Type data to the database..';
            }
        } catch (\Exception $e) {
            $messageType = 'error';
            $message = 'An error occurred while updating the Bank Deposit Type .'.$e->getMessage();
        }


        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function fetchWhtCetificates(Request $request){

        $query = CustomerPayments::query();
        $querySum = CustomerPayments::query();
        $currencySymbol = Currencies::where('is_base','=',1)->first();
        //from_date to_date customer_id receipt_no wht_cert_no  type
        //$getAllRoutePermisssions = AcAccounts::all();
        //s_code s_name s_status s_type
        if ($request->has('receipt_no') && $request->receipt_no != '') {
            $query->where('receipt_no', 'LIKE', '%' . $request->receipt_no . '%');
        }
        if ($request->has('wht_cert_no') && $request->wht_cert_no != '') {
            $query->where('reference', '=', '' . $request->wht_cert_no . '');
        }
        if ($request->has('from_date') && $request->from_date != '') {
            $query->where('date', '>=', '' . $request->from_date . '');
        }
        if ($request->has('to_date') && $request->to_date != '') {
            $query->where('date', '<=', '' . $request->to_date . '');
        }
        if ($request->has('customer_id') && $request->customer_id != '') {
            $query->where('customer_id', '=', '' . $request->customer_id . '');
        }
        if ($request->has('type') && $request->type != '') {
            $query->where('type', '=', '' . $request->type . '');
        }

        $querySum->WHERE('status', 1);
        $totalPayment = $querySum->sum('payment');

        $query->WHERE('status', 1);
        $query->orderBy('date', 'DESC'); // Default ordering receipt_no DESC

        $fetchTableDetails = $query->get();
        //$fetchTableDetails = Currencies::all();

        $responses = '';

        $debit_total = 0;
        $credit_total = 0;

        $fetchTableDetails = $query->paginate(100);
        $responses = view('pages.dashboard.customers.tables.fiscal_receipt_table', compact('fetchTableDetails','totalPayment','currencySymbol'))->render();

        return response()->json(['html' => $responses,'is_posted' => $request->is_posted]);
    }
}
