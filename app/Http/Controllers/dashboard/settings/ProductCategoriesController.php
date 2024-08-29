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
use App\Models\Departments;
use App\Models\DepartmentHeads;
use App\Models\UserPrivileges;

use App\Models\AcAccounts;
use App\Models\MiniPosConfigurations;
use App\Models\ProductCategories;

class ProductCategoriesController extends Controller
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

        $acAccountsDetails = AcAccounts::all();
        $proCategoriesDetails = ProductCategories::all();
        $departmentsDetails = Departments::all();

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
            return view('pages.dashboard.settings.productcategories', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions','acAccountsDetails','proCategoriesDetails','departmentsDetails'));
        }
    }

    public function addProductCategory(Request $request){
        $messageType = '';
        $message = '';
            // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'category_department' => 'required',
            'category_name' => 'required',
            'sales_account_id' => 'required',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            $messageType = 'error';
            $message = $validator->errors();
        }else{
            $proCatData = [
                'department_id' => $request->category_department,
                'service_type' => '',
                'product_category_id' => 0,
                'name' => $request->category_name,
                'sales_account_id' => $request->sales_account_id,
            ];

            // Assuming DepartmentHead is the model class for the table
            $addProCategory = new ProductCategories();

            // Save the data
            $addProCategory->fill($proCatData);
            $addProCategory->save();

            $messageType = 'success';
            $message = 'You have successfully Added the Product Category data to the database..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);

    }

    public function updateProductCategory(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        try {
                $category_id = $request->category_id;
                $getProCategories = ProductCategories::find($request->category_id);

                $validator = Validator::make($request->all(), [
                    'category_department' => 'required',
                    'category_name' => 'required',
                    'sales_account_id' => 'required',
                ]);

                if ($validator->fails()) {
                    $messageType = 'error';
                    $message = 'Errors: '.$validator->errors();
                }else{
                    $proCatData = [
                        'department_id' => $request->category_department,
                        'name' => $request->category_name,
                        'sales_account_id' => $request->sales_account_id,
                    ];

                    // update the data
                    $getProCategories->update($proCatData);

                    $messageType = 'success';
                    $message = 'You have successfully Updated the Product Category data to the database..';
                }

        } catch (\Exception $e) {
            // Catch any exception and return a response
            $messageType = 'error';
            $message = 'An error occurred while updating the Product Category.'.$e->getMessage();

        }

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function editProCategories(Request $request,$cat_id){
        //ProductCategories MiniPosConfigurations AcAccounts
        $getProductCategories = ProductCategories::find($request->id);
        $departments = Departments::all();
        $departmentHeads = DepartmentHeads::all();

        if (!$getProductCategories) {
            return response()->json(['error' => 'Product Categories not found'], 404);
        }
        $responseData = [
            'product_categories' => $getProductCategories,
            'department_heads' => $departmentHeads,
            'departments' => $departments
        ];

        return response()->json($responseData);
    }

    public function deleteProductCategory(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getProductCategories = ProductCategories::find($request->delete_record_id);

        if (!$getProductCategories) {
            return response()->json(['error' => 'Product Categories not found'], 404);
        }

        $getProductCategories->delete();

        $messageType = 'success';
        $message = 'You have successfully Deleted this Product Category data from database..';

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function fetchproCategoriesAll(Request $request){
        $query = Departments::query();
        $getAllRoutePermisssions = RoutesPermissions::all();

        $query->orderBy('name', 'asc'); // Default ordering

        $departmentsDetails = $query->get();

        $productCategoriesDetails = DB::table('product_categories')
                            ->join('departments', 'product_categories.department_id', '=', 'departments.id')
                            ->join('ac_accounts', 'product_categories.sales_account_id', '=', 'ac_accounts.id')
                            ->select(
                                'ac_accounts.name as sales_account_name',
                                'departments.code',
                                'departments.name as department_name',
                                'product_categories.id',
                                'product_categories.service_type',
                                'product_categories.product_category_id',
                                'product_categories.name',
                                'product_categories.status'
                            )
                            ->get();

        $responses = '';

        if ($productCategoriesDetails->count() > 0) {
            $responses .= '

                            <small class="p-2"><table class="table table-stripped table-hover" width="100%"><thead>
			                <tr>
                                <td align="left"><strong>#</strong></td>
                                <td align="left"><strong>Department</strong></td>
                                <td align="left"><strong>Name</strong></td>
                                <td align="left"><strong>Sales Account</strong></td>
                                <td align="left"><strong>Action</strong></td>
                            </tr>
                            </thead>
		                    <tbody>';
            $i=1;
            foreach ($productCategoriesDetails as $key => $productCategoriesDetail) {
                //$userPrivileges = UserPrivileges::find($productCategoriesDetail->privilege);
                $btnActivateType = ($productCategoriesDetail->status == 1)? 'Active':'Inactive';

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
                $deleteRoutePath = 'categories.deleteproductcategory';
                if ($canDelete) {
                    $deletebtn = '<button type="button" class="btn btn-xs btn-danger deleteRecordButton" onclick="deleteRecord(' . $productCategoriesDetail->id . ', \'' . $deleteRoutePath . '\');" data-id="' . $productCategoriesDetail->id . '" title="Delete"><i class="bi bi-x"></i> </button>';


                }

                $editButton = '';
                if ($canEdit) {
                    $editButton = '<button type="button" class="btn btn-xs btn-info" onclick="editCategory('.$productCategoriesDetail->id.');">
                                                <i class="bi bi-pen"></i>
                                            </button>';
                }

                //$userPrivilegesName = UserPrivileges::where('id', $productCategoriesDetail->privilege)->first();

                $responses .= '<tr>
                                    <td style="vertical-align: middle;">'.($key+1).'</td>
                                    <td style="vertical-align: middle;">'.$productCategoriesDetail->department_name.'</td>
                                    <td style="vertical-align: middle;">'.$productCategoriesDetail->name.'</td>
                                    <td style="vertical-align: middle;">'.$productCategoriesDetail->sales_account_name.'</td>

                                    <td style="vertical-align: middle;">
                                        '.$editButton.'
                                        '.$deletebtn.'

                                    </td>
                                </tr>';

            }

            $responses .= '<tbody></table>';

            echo $responses;
        }else{
            echo '<h4>No users found in the system !</h4>';
        }
    }
}
