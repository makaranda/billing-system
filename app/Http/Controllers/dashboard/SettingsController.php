<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemMenus;
use App\Models\RoutesPermissions;

use App\Models\PermissionsTypes;
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
use App\Models\MessageFormats;

class SettingsController extends Controller
{
    public function index($route = null)
    {
        $route = $route ?? 'index.settings';
        $route = $route ?? 'home';
        $data = session('data');

        // Fetch the main menu items
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
        return view('pages.dashboard.settings.index', compact('mainMenus', 'data','mainRouteName', 'remindersRoute','routesPermissions','getAllRoutePermisssions'));

    }


    public function getEmailDetails (Request $request){

        $getMessageFormat = MessageFormats::where('type',$request->type)
                                        ->where('status',1)
                                        ->first();
        //$getDatas = Customers::find($request->customer_id);
        //$departments = Departments::all();
        //$departmentHeads = DepartmentHeads::all();
        $content = $getMessageFormat->content;

        if(isset($request->customer_id) && $request->customer_id > 0){
            $customer = Customers::find($request->customer_id);
            if($customer){
                $customer_stement_link = "/public/customer_statement/?token=".md5($customer->id);
                $content = str_ireplace(['[customer_code]','[customer_name]','[statement_link]'], [$customer->code,$customer->company,$customer_stement_link], $content);
            }

            $responseData = [
                'customers' => $customer,
                'email_message' => $content,
                'message_format' => $getMessageFormat
            ];
        }
        if(isset($request->invoice_no) && $request->invoice_no > 0){
            $invoice = Invoices::find($request->invoice_no);
            if($invoice){
                $invoice_link = "/public/invoice/?token=".$invoice->token;
                $content = str_ireplace(['[invoice_no]','[invoice_amount]','[invoice_balance]','[invoice_link]','[invoice_date]','[invoice_duedate]'], [$invoice->invoice_no,$invoice->amount,$invoice->payments_due,$invoice_link,$invoice->date,$invoice->due_date], $content);
            }

            $responseData = [
                'invoices' => $invoice,
                'email_message' => $content,
                'message_format' => $getMessageFormat
            ];
        }


        return response()->json($responseData);
    }


}
