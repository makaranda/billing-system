<?php

namespace App\Http\Controllers\dashboard\settings;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemMenus;
use App\Models\RoutesPermissions;
use App\Models\HotelInformation;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\Validator;
use Exception;

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

    public function systemUpdateInformation(Request $request){
        $messageType = '';
        $message = '';
        //var_dump($request);
        //`name`, `address`, `address_post`, `telephone`, `mobile`, `fax`, `email`, `web`, `tandc`, `tpin`, `acc_name`, `acc_number`, `status`, `logo`, `letter_head`
        $tandc = $request->tandc;
        $system_information_id = $request->system_information_id;
        $systemInformationDatas = HotelInformation::find($request->system_information_id);

        if(!empty($request->hotel_name) && !empty($request->system_information_id)){
            $systemData = [
                'name' => $request->hotel_name,
                'address' => $request->physical_address,
                'address_post' => $request->postal_address,
                'telephone' => $request->telephone,
                'mobile' => $request->mobile,
                'fax' => $request->fax,
                'email' => $request->email,
                'web' => $request->web_site,
                'tandc' => $request->tandc,
            ];

            $systemInformationDatas->update($systemData);
            $messageType = 'success';
            $message = 'You have successfully updated the System Information to the database..';

        }else{
            $messageType = 'Wrong';
            $message = 'There have something error..';
        }
        //echo 'Sucess';
        $responseData = [
            'messageType' => $messageType,
            'message' => $message
        ];

        return response()->json($responseData);
    }

    public function systemUpdateLogo(Request $request){

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'messageType' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'logo_'.time().'.'.$image->getClientOriginalExtension();

            $pathToImage = $image->move(public_path('images/setting'), $imageName);

            // Optimize the image using Spatie Image Optimizer
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($pathToImage);

            $systemInformationDatas = HotelInformation::find($request->system_id);
            $systemInformationDatas->logo = $imageName;
            $systemInformationDatas->save();
            //$systemInformationDatas->update($systemData);

            return response()->json([
                'messageType' => 'success',
                'message' => 'Logo updated and optimized successfully!'
            ]);
        }

        return response()->json([
            'messageType' => 'error',
            'message' => 'No image uploaded.'
        ]);

    }

    public function systemUpdateLetterhead(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'messageType' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'letter_head_image_'.time().'.'.$image->getClientOriginalExtension();

            $pathToImage = $image->move(public_path('images/setting'), $imageName);

            // Optimize the image using Spatie Image Optimizer
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($pathToImage);

            $systemInformationDatas = HotelInformation::find($request->system_id);
            $systemInformationDatas->letter_head = $imageName;
            $systemInformationDatas->save();
            //$systemInformationDatas->update($systemData);

            return response()->json([
                'messageType' => 'success',
                'message' => 'Letter Head Image updated and optimized successfully!'
            ]);
        }

        return response()->json([
            'messageType' => 'error',
            'message' => 'No image uploaded.'
        ]);
    }
}
