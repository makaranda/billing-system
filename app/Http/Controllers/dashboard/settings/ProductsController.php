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
use App\Models\Taxes;
use App\Models\Currencies;
use App\Models\Products;

class ProductsController extends Controller
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
        $productsDetails = Departments::all();
        $taxesDetails = Taxes::all();
        $currenciesDetails = Currencies::all();


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
            return view('pages.dashboard.settings.products', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions','acAccountsDetails','proCategoriesDetails','taxesDetails','currenciesDetails'));
        }
    }



    public function addProduct(Request $request){
        $messageType = '';
        $message = '';
            // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'item_code' => 'required',
            'item_name' => 'required',
            'description' => 'required',
            'tax_type' => 'required',
            'stock_type' => 'required',
            'currency_id' => 'required',
            'price' => 'required',
        ]);
//`category_id`, `code`, `name`, `description`, `currency_id`, `price`, `is_taxable`, `stock_type`, `created_at`, `updated_at`, `status`, `Kbilling_product_id`
        // Check if the validation fails
        if ($validator->fails()) {
            $messageType = 'error';
            $message = $validator->errors();
        }else{
            $proData = [
                'category_id' => $request->category,
                'code' => $request->item_code,
                'name' => $request->item_name,
                'description' => $request->description,
                'is_taxable' => $request->tax_type,
                'stock_type' => $request->stock_type,
                'currency_id' => $request->currency_id,
                'price' => $request->price,
            ];

            // Assuming DepartmentHead is the model class for the table
            $addProduct = new Products();

            // Save the data
            $addProduct->fill($proData);
            $addProduct->save();

            $messageType = 'success';
            $message = 'You have successfully Added the Product data to the database..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);

    }

    public function updateProduct(Request $request,$pro_id){
        $messageType = '';
        $message = '';

        try {
                $expense_id = $request->expense_id;
                $getProducts = Products::find($request->expense_id);

                $validator = Validator::make($request->all(), [
                    'category' => 'required',
                    'item_code' => 'required',
                    'item_name' => 'required',
                    'description' => 'required',
                    'tax_type' => 'required',
                    'stock_type' => 'required',
                    'currency_id' => 'required',
                    'price' => 'required',
                ]);

                if ($validator->fails()) {
                    $messageType = 'error';
                    $message = 'Errors: '.$validator->errors();
                }else{
                    $proData = [
                        'category_id' => $request->category,
                        'code' => $request->item_code,
                        'name' => $request->item_name,
                        'description' => $request->description,
                        'is_taxable' => $request->tax_type,
                        'stock_type' => $request->stock_type,
                        'currency_id' => $request->currency_id,
                        'price' => $request->price,
                    ];

                    // update the data
                    $getProducts->update($proData);

                    $messageType = 'success';
                    $message = 'You have successfully Updated the Product data to the database..';
                }

        } catch (\Exception $e) {
            // Catch any exception and return a response
            $messageType = 'error';
            $message = 'An error occurred while updating the Product .'.$e->getMessage();

        }

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function editProduct(Request $request,$cat_id){
        //ProductCategories MiniPosConfigurations AcAccounts
        $getProducts = Products::find($request->id);
        $departments = Departments::all();
        $departmentHeads = DepartmentHeads::all();

        if (!$getProducts) {
            return response()->json(['error' => 'Products not found'], 404);
        }
        $responseData = [
            'products' => $getProducts
        ];

        return response()->json($responseData);
    }

    public function deleteProduct(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getProducts = Products::find($request->delete_record_id);

        if (!$getProducts) {
            return response()->json(['error' => 'Product is not found'], 404);
        }

        if($request->delete_record_type == 'inactive'){
            $actveData = 0;
            $message = 'You have successfully Deactivate this Product record..';
        }else{
            $actveData = 1;
            $message = 'You have successfully Activate this Product record..';
        }

        $proData = [
            'status' => $actveData,
        ];

        // update the data
        $getProducts->update($proData);

        //$getProducts->delete();
        $messageType = 'success';


        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function fetchproProductsAll(Request $request){
        //$query = Products::query();
        $getAllRoutePermisssions = RoutesPermissions::all();

        //$query->orderBy('name', 'asc'); // Default ordering

        //$productsDetails = $query->get();

        $productsDetails = DB::table('products')
                                    ->join('product_categories', 'products.category_id', '=', 'product_categories.id') // Adding join with products table
                                    ->select(
                                        'products.id',
                                        'product_categories.id as product_category_id',
                                        'product_categories.service_type',
                                        'product_categories.name as product_category_name',
                                        'product_categories.status as product_category_status',
                                        'products.id as product_id',
                                        'products.code as product_code',
                                        'products.name as product_name',
                                        'products.description',
                                        'products.currency_id',
                                        'products.price',
                                        'products.is_taxable',
                                        'products.stock_type',
                                        'products.status',
                                        'products.created_at as product_created_at',
                                        'products.updated_at as product_updated_at',
                                        'products.status as product_status',
                                        'products.Kbilling_product_id'
                                    )->get();

        $responses = '';

        if ($productsDetails->count() > 0) {
            $responses .= '

                            <small class="p-2"><table class="table table-stripped table-hover" width="100%"><thead>
			                <tr>
                                <td align="left"><strong>#</strong></td>
                                <td align="left"><strong>Code</strong></td>
                                <td align="left"><strong>Name</strong></td>
                                <td align="left"><strong>Category</strong></td>
                                <td align="left"><strong>Description</strong></td>
                                <td align="left"><strong>Price</strong></td>
                                <td align="left"><strong>Action</strong></td>
                            </tr>
                            </thead>
		                    <tbody>';
            $i=1;
            foreach ($productsDetails as $key => $productsDetail) {
                //$userPrivileges = UserPrivileges::find($productsDetail->privilege);
                //$btnActivateType = ($productsDetail->status == 1)? 'Active':'Inactive';

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
                $deleteRoutePath = 'products.deleteproduct';
                if ($canDelete) {
                    $acInType = $productsDetail->status == 1 ? 'inactive' : 'active';
                    $acInColor = $productsDetail->status == 1 ? 'danger' : 'success';
                    $acInIcon = $productsDetail->status == 1 ? 'x' : 'arrow-repeat';

                    $deletebtn = '<button type="button" class="btn btn-xs btn-'.$acInColor.' deleteRecordButton" onclick="deleteRecord(' . $productsDetail->id . ', \'' . $deleteRoutePath . '\', \'' . $acInType . '\');" data-id="' . $productsDetail->id . '" title="'.$acInType.'"><i class="bi bi-'.$acInIcon.'"></i> </button>';
                }

                $editButton = '';
                if ($canEdit) {
                    $editButton = '<button type="button" class="btn btn-xs btn-info" onclick="editProduct('.$productsDetail->id.');">
                                                <i class="bi bi-pen"></i>
                                            </button>';
                }

                $responses .= '<tr>
                                    <td style="vertical-align: middle;">'.($key+1).'</td>
                                    <td style="vertical-align: middle;">'.$productsDetail->product_code.'</td>
                                    <td style="vertical-align: middle;">'.$productsDetail->product_name.'</td>
                                    <td style="vertical-align: middle;">'.$productsDetail->product_category_name.'</td>
                                    <td style="vertical-align: middle;">'.$productsDetail->description.'</td>
                                    <td style="vertical-align: middle;">'.$productsDetail->price.'</td>

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
