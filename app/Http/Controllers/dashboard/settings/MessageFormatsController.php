<?php

namespace App\Http\Controllers\dashboard\settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\SystemMenus;
use App\Models\RoutesPermissions;
use App\Models\MessageFormats;
use App\Models\PermissionsTypes;
use App\Models\SystemUsers;

class MessageFormatsController extends Controller
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
            return view('pages.dashboard.settings.messageformats', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions'));
        }
    }

    public function addMessageFormat(Request $request){
        $messageType = '';
        $message = '';
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'format_type' => 'required',
                'content' => 'required',
            ]);

        if ($validator->fails()) {
            $messageType = 'error';
            //$message = $validator->errors();
            $message = "This Fields are Required..!!";
        }else{
            $proData = [
                'name' => $request->name,
                'type' => $request->format_type,
                'content' => $request->content,
            ];

            // Assuming DepartmentHead is the model class for the table
            $addMessages = new MessageFormats();

            // Save the data
            $addMessages->fill($proData);
            $addMessages->save();

            $messageType = 'success';
            $message = 'You have successfully Submitted the Message..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);

    }

    public function updateMessageFormat(Request $request,$pro_id){
        $messageType = '';
        $message = '';

        try {
                $edit_id = $request->edit_id;
                $getMessages = MessageFormats::find($request->edit_id);

                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'format_type' => 'required',
                    'content' => 'required',
                ]);

                if ($validator->fails()) {
                    $messageType = 'error';
                    $message = 'Errors: '.$validator->errors();
                }else{
                    $proData = [
                        'name' => $request->name,
                        'type' => $request->format_type,
                        'content' => $request->content,
                    ];

                    // update the data
                    $getMessages->update($proData);

                    $messageType = 'success';
                    $message = 'You have successfully Updated the Message..';
                }

        } catch (\Exception $e) {
            // Catch any exception and return a response
            $messageType = 'error';
            $message = 'An error occurred while updating the Message .'.$e->getMessage();

        }

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }


    public function deleteMessageFormat(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getMessages = MessageFormats::find($request->delete_record_id);

        if (!$getMessages) {
            return response()->json(['error' => 'Tax is not found'], 404);
        }

        if($request->delete_record_type == 'inactive'){
            $actveData = 0;
            $message = 'You have successfully Deactivate this Message record..';
        }else{
            $actveData = 1;
            $message = 'You have successfully Activate this Message record..';
        }

        $proData = [
            'status' => $actveData,
        ];

        // update the data
        $getMessages->update($proData);

        //$getMessages->delete();
        $messageType = 'success';


        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function editMessageFormat(Request $request,$cat_id){
        $addMessages = MessageFormats::find($request->id);

        if (!$addMessages) {
            return response()->json(['error' => 'Taxes are not found'], 404);
        }
        $responseData = [
            'message_formats' => $addMessages
        ];

        return response()->json($responseData);
    }

    public function fetchproMessageFormats(Request $request){

        //$query = Products::query();
        $query = MessageFormats::query();

        $query->orderBy('id', 'asc'); // Default ordering

        $messageFormatDetails = $query->get();

        $responses = '';

        if ($messageFormatDetails->count() > 0) {
            $responses .= '

                            <small class="p-2"><table class="table table-stripped table-hover" width="100%"><thead>
                            <tr>
                                <td align="left"><strong>#</strong></td>
                                <td align="left"><strong>Type</strong></td>
                                <td align="left"><strong>Name</strong></td>
                                <td align="left"><strong>Action</strong></td>
                            </tr>
                            </thead>
                            <tbody>';
            $i=1;
            foreach ($messageFormatDetails as $key => $messageFormatDetail) {

                $getMessageFormats = RoutesPermissions::where('user_id', Auth::user()->id)->get();

                $currentRoute = request()->route()->getName();
                $parentRoute = 'index.'.explode('.', $currentRoute)[0].'';
                //$parentRoute = 'index.productcategories';

                $canDelete = $getMessageFormats->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'delete' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });

                $canPrivilege = $getMessageFormats->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'privilege' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });

                $canEdit = $getMessageFormats->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'update' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });
                $deletebtn = '';
                $deleteRoutePath = 'messageformats.deletemessageformat';
                if ($canDelete) {
                    $acInType = $messageFormatDetail->status == 1 ? 'inactive' : 'active';
                    $acInColor = $messageFormatDetail->status == 1 ? 'danger' : 'success';
                    $acInIcon = $messageFormatDetail->status == 1 ? 'x' : 'arrow-repeat';

                    $deletebtn = '<button type="button" class="btn btn-xs btn-'.$acInColor.' deleteRecordButton" data-list="' . $messageFormatDetail->id . '/'.$deleteRoutePath.'/'.$acInType.'" title="'.$acInType.'"><i class="bi bi-'.$acInIcon.'"></i> </button>';
                }

                $editButton = '';
                if ($canEdit) {
                    $editButton = '<button type="button" class="btn btn-xs btn-info editMessageButton" data-id="'.$messageFormatDetail->id.'">
                                                <i class="bi bi-pen"></i>
                                            </button>';
                }

                $responses .= '<tr>
                                    <td style="vertical-align: middle;">'.($key+1).'</td>
                                    <td style="vertical-align: middle;">'.$messageFormatDetail->type.'</td>
                                    <td style="vertical-align: middle;">'.$messageFormatDetail->name.'</td>

                                    <td style="vertical-align: middle;">
                                        '.$editButton.'
                                        '.$deletebtn.'

                                    </td>
                                </tr>';

            }

            $responses .= '<tbody></table>';

            echo $responses;
        }else{
            echo '<h4>No any Datas found in the system !</h4>';
        }

    }
}
