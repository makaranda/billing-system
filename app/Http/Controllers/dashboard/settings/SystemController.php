<?php

namespace App\Http\Controllers\dashboard\settings;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemMenus;
use App\Models\RoutesPermissions;
use App\Models\HotelInformation;

class SystemController extends Controller
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
            return view('pages.dashboard.settings.system', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions'));
        }
    }

    public function systemInformation(Request $request){
        $getSyetemDetails = HotelInformation::where('id', 2)->get();
        // $responseData = [
        //     'name' => $getSyetemDetails->name,
        //     'address' => $getSyetemDetails->address,
        //     'address_post' => $getSyetemDetails->address_post,
        //     'telephone' => $getSyetemDetails->telephone,
        //     'mobile' => $getSyetemDetails->mobile,
        //     'fax' => $getSyetemDetails->fax,
        //     'email' => $getSyetemDetails->email,
        //     'web' => $getSyetemDetails->web,
        //     'tandc' => $getSyetemDetails->tandc,
        //     'tpin' => $getSyetemDetails->tpin,
        //     'acc_name' => $getSyetemDetails->acc_name,
        //     'acc_number' => $getSyetemDetails->acc_number,
        //     'status' => $getSyetemDetails->status,
        //     'logo' => $getSyetemDetails->logo,
        //     'letter_head' => $getSyetemDetails->letter_head,
        // ];

        $responseData = [
            'getSyetemDetails' => $getSyetemDetails,
        ];

        return response()->json($responseData);
    }
}
