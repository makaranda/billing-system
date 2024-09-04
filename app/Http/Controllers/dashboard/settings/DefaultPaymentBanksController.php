<?php

namespace App\Http\Controllers\dashboard\settings;

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

use App\Models\BankAccounts;
use App\Models\DefaultPaymentBanks;
use App\Models\Currencies;
use App\Models\CardTypes;

class DefaultPaymentBanksController extends Controller
{
    public function index($route = null){
        $route = $route ?? 'index.settings';
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
        $systemUsersDetails = SystemUsers::all();

        $bankAccountsDetails = BankAccounts::where('status', 1)
                                            ->get();
        $defaultPaymentBanksDetails = DefaultPaymentBanks::all();
        $currenciesDetails = Currencies::all();
        $cardTypesDetails = CardTypes::all();


        $routepermissions = [];
        foreach ($permissionsTypes as $permissionsType) {
            $routepermissions[$permissionsType->name] = 0;
        }
        $getAllRoutePermisssionsUser = RoutesPermissions::where('user_id', Auth::user()->id)
                                                        ->where('route', $getRoutename)
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
        $parentid = 9;
        $mainRouteName = 'index.settings';
        //dd($mainMenus);
        $countCheckThisRoutes = RoutesPermissions::where('route', $getRoutename)
        ->where('user_id', Auth::user()->id)
        ->where('main_route', $mainRouteName)
        ->count();

        if($countCheckThisRoutes == 0){
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this route.');
        }else{
            return view('pages.dashboard.settings.defaultpaymentbanks', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions','bankAccountsDetails','defaultPaymentBanksDetails','currenciesDetails','cardTypesDetails'));
        }
    }


    public function addDefaultPaymentBank(Request $request){
        $messageType = '';
        $message = '';
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required',
                'currency_id' => 'required',
                'bank_account_id' => 'required',
            ]);

        if ($validator->fails()) {
            $messageType = 'error';
            //$message = $validator->errors();
            $message = 'All Fields are Required..!!';
        }else{
            $proData = [
                'payment_method' => $request->payment_method,
                'currency_id' => $request->currency_id,
                'bank_account_id' => $request->bank_account_id,
                'created_by' => Auth::user()->id,
            ];

            // Assuming DepartmentHead is the model class for the table
            $addDatas = new DefaultPaymentBanks();

            // Save the data
            $addDatas->fill($proData);
            $addDatas->save();

            $messageType = 'success';
            $message = 'You have successfully Added the Default Payment Banks data to the database..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);

    }

    public function updateDefaultPaymentBank(Request $request,$pro_id){
        $messageType = '';
        $message = '';

        try {
                $edit_id = $request->edit_id;
                $getTaxes = DefaultPaymentBanks::find($request->edit_id);

                $validator = Validator::make($request->all(), [
                    'payment_method' => 'required',
                    'currency_id' => 'required',
                    'bank_account_id' => 'required',
                ]);

                if ($validator->fails()) {
                    $messageType = 'error';
                    //$message = 'Errors: '.$validator->errors();
                    $message = 'All Fields are Required..!!';
                }else{
                    $proData = [
                        'payment_method' => $request->payment_method,
                        'currency_id' => $request->currency_id,
                        'bank_account_id' => $request->bank_account_id,
                        'created_by' => Auth::user()->id,
                    ];

                    // update the data
                    $getTaxes->update($proData);

                    $messageType = 'success';
                    $message = 'You have successfully Updated the Default Payment Banks data to the database..';
                }

        } catch (\Exception $e) {
            // Catch any exception and return a response
            $messageType = 'error';
            $message = 'An error occurred while updating the Default Payment Banks .'.$e->getMessage();

        }

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function editDefaultPaymentBank(Request $request,$cat_id){
        //ProductCategories MiniPosConfigurations AcAccounts
        $getDatas = DefaultPaymentBanks::find($request->id);
        //$departments = Departments::all();
        //$departmentHeads = DepartmentHeads::all();

        if (!$getDatas) {
            return response()->json(['error' => 'Default Payment Banks are not found'], 404);
        }
        $responseData = [
            'defaultpaymentbanks' => $getDatas
        ];

        return response()->json($responseData);
    }

    public function deleteDefaultPaymentBank(Request $request, $cat_id)
    {
        $messageType = '';
        $message = '';

        // Find the record by the provided ID
        $getDatas = DefaultPaymentBanks::find($request->delete_record_id);

        // If the record is not found, return an error response
        if (!$getDatas) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        // Delete the record
        $getDatas->delete();

        // Set the success message after deletion
        $message = 'You have successfully deleted this Default Payment Banks record.';
        $messageType = 'success';

        // Prepare the response data
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];

        // Return the response as JSON
        return response()->json($responseData);
    }

    public function fetchDefaultPaymentBanks(Request $request){
        //$query = DefaultPaymentBanks::query();
        $getAllRoutePermisssions = DefaultPaymentBanks::all();
        //$query->WHERE('status', 1);
        //$query->orderBy('id', 'asc'); // Default ordering

        //$fetchTableDetails = $query->get();
        $fetchTableDetails = DB::table('default_payment_banks')
        ->join('currencies', 'default_payment_banks.currency_id', '=', 'currencies.id')
        ->join('bank_accounts', 'default_payment_banks.bank_account_id', '=', 'bank_accounts.id')
        ->leftJoin('card_types', 'default_payment_banks.card_type_id', '=', 'card_types.id')
        ->select(
            'default_payment_banks.id',
            'default_payment_banks.payment_method',
            'currencies.name AS currency_name',
            'bank_accounts.account_name',
            'bank_accounts.account_no',
            'card_types.name as card_type_name'
        )
        ->get();
        //$fetchTableDetails = Currencies::all();

        $responses = '';

        if ($fetchTableDetails->count() > 0) {
            $responses .= '

                            <small class="p-2"><table class="table table-stripped table-hover" width="100%"><thead>
			                <tr>
                                <td align="left"><strong>#</strong></td>
                                <td align="left"><strong>Payment Method</strong></td>
                                <td align="left"><strong>Currency</strong></td>
                                <td align="left"><strong>Card Type</strong></td>
                                <td align="left"><strong>Bank Account</strong></td>
                                <td align="left"><strong>Action</strong></td>
                            </tr>
                            </thead>
		                    <tbody>';
            $i=1;
            foreach ($fetchTableDetails as $key => $fetchDetail) {
                //$userPrivileges = UserPrivileges::find($fetchDetail->privilege);
                //$btnActivateType = ($fetchDetail->status == 1)? 'Active':'Inactive';

                $getAllRoutePermisssions = RoutesPermissions::where('user_id', Auth::user()->id)->get();

                $currentRoute = request()->route()->getName();
                $parentRoute = 'index.'.explode('.', $currentRoute)[0].'';
                //$parentRoute = 'index.productcategories';

                $canDelete = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'delete' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });

                $canPrivilege = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'privilege' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });

                $canEdit = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'update' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });
                $deletebtn = '';
                $deleteRoutePath = 'defaultpaymentbanks.deletedefaultpaymentbank';
                if ($canDelete) {
                    // $acInType = $fetchDetail->status == 1 ? 'inactive' : 'active';
                    // $acInColor = $fetchDetail->status == 1 ? 'danger' : 'success';
                    // $acInIcon = $fetchDetail->status == 1 ? 'x' : 'arrow-repeat';

                    $acInType ='inactive';
                    $acInColor ='danger';
                    $acInIcon ='x';

                    $deletebtn = '<button type="button" class="btn btn-xs btn-'.$acInColor.' deleteRecordButton" onclick="deleteRecord(' . $fetchDetail->id . ', \'' . $deleteRoutePath . '\', \'' . $acInType . '\');" data-id="' . $fetchDetail->id . '" title="'.$acInType.'"><i class="bi bi-'.$acInIcon.'"></i> </button>';
                }

                $editButton = '';
                if ($canEdit) {
                    $editButton = '<button type="button" class="btn btn-xs btn-info" onclick="editRecord('.$fetchDetail->id.');">
                                                <i class="bi bi-pen"></i>
                                            </button>';
                }

                $responses .= '<tr>
                                    <td style="vertical-align: middle;">'.($key+1).'</td>
                                    <td style="vertical-align: middle;">'.ucwords($fetchDetail->payment_method).'</td>
                                    <td style="vertical-align: middle;">'.ucwords($fetchDetail->currency_name).'</td>
                                    <td style="vertical-align: middle;">'.ucwords($fetchDetail->card_type_name).'</td>
                                    <td style="vertical-align: middle;">'.ucwords($fetchDetail->account_name).'<br/><small>'.$fetchDetail->account_no.'</small></td>

                                    <td style="vertical-align: middle;">
                                        '.$editButton.'
                                        '.$deletebtn.'

                                    </td>
                                </tr>';

            }

            $responses .= '<tbody></table>';

            echo $responses;
        }else{
            echo '<h4>No Datas found in the system !</h4>';
        }
    }
}
