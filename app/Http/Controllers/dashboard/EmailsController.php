<?php

namespace App\Http\Controllers\dashboard;

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
use App\Models\Emails;

class EmailsController extends Controller
{
    public function emailSave(Request $request){
        $message = '';
        $messageType = '';

        $getAllSystemUsers = SystemUsers::where('status',1)
                                         ->where('id','=',$request->user_id)
                                         ->first();
        $getAcAccounts = AcAccounts::where('control_type', 'LIKE', '%debtors_control%')->first();

        if($getAllSystemUsers){

            $user_id = $request->user_id;
            $user_name = $getAllSystemUsers->full_name;
			$user_email = trim($getAllSystemUsers->email);
            $debtors_control_account = $getAcAccounts->id;

            if(filter_var($user_email, FILTER_VALIDATE_EMAIL)){
                $result = DebtAssignments::where('status', 1)
                                        ->where('user_id', $user_id)
                                        ->orderBy('assigned_upto', 'DESC')
                                        ->first(['assigned_upto']);
                $assigned_upto = $result ? $result->assigned_upto : '';

                if(!empty($assigned_upto)){


                    $fetchTableDetails = DB::table('customer_transactions as a')
                                        ->join(DB::raw('(SELECT MAX(customer_transactions.id) AS id,
                                                            debt_assignments.id AS assignment_id,
                                                            debt_assignments.assigned_date,
                                                            debt_assignments.assigned_upto,
                                                            debt_assignments.collection_date,
                                                            debt_assignments.user_id   -- Add user_id to the subquery
                                                        FROM customer_transactions
                                                        INNER JOIN debt_assignments
                                                        ON debt_assignments.customer_id = customer_transactions.customer_id
                                                        WHERE customer_transactions.nominal_account_id = ' . intval($debtors_control_account) . '  -- Manually bind this value
                                                        AND debt_assignments.user_id = ' . intval($user_id) . '                                -- Manually bind this value
                                                        AND debt_assignments.assigned_upto = "' . $assigned_upto . '"                          -- Manually bind this value
                                                        AND customer_transactions.transaction_date <= debt_assignments.assigned_upto
                                                        GROUP BY customer_transactions.customer_id
                                                        ) as b'), 'a.id', '=', 'b.id')
                                        ->join('customers as c', 'c.id', '=', 'a.customer_id')
                                        ->select(
                                            'a.customer_balance',
                                            'a.customer_id',
                                            'b.assigned_date',
                                            'b.assigned_upto',
                                            'b.collection_date',
                                            'b.assignment_id',
                                            'c.code',
                                            'c.company',
                                            'c.active'
                                        )
                                        ->get();

                    if(isset($fetchTableDetails)){
						$html = '<small>ASSIGNED DEBTS LIST FOR '.strtoupper($user_name).'<hr>';
						$html .= '<table class="table table-stripped" cellspacing="0" width="100%">';
						$html .= '<thead>';
						$html .= '<tr style="border:1px solid #444;">';
						$html .= '<td style="border:1px solid #444;"><strong>#</strong></td>';
						$html .= '<td style="border:1px solid #444;"><strong>Customer Name</strong></td>';
						$html .= '<td style="border:1px solid #444;"><strong>Meeting Date</strong></td>';
						$html .= '<td style="border:1px solid #444;"><strong>Report Date</strong></td>';
						$html .= '<td style="border:1px solid #444;"><strong>Collection Date</strong></td>';
						$html .= '<td style="border:1px solid #444;" align="right"><strong>Assigned</strong></td>';
						$html .= '<td style="border:1px solid #444;" align="right"><strong>Collected</strong></td>';
						$html .= '<td style="border:1px solid #444;" align="right"><strong>Balance</strong></td>';
						$html .= '</tr>';
						$html .= '</thead>';
						$html .= '<tbody>';

						$i=1;
						$invoice_amount_total = 0;
						$assigned_total = 0;
						$collected_total = 0;
						$balance_total = 0;

                        foreach($fetchTableDetails as $fetchTableDetail) {

                            $customer_id = $fetchTableDetail->customer_id;
                            $assigned_upto = $fetchTableDetail->assigned_upto;
                            $collection_date = $fetchTableDetail->collection_date;
                            $is_posted = 1;
                            $status = 1;

                            $cusTraQuery = CustomerTransactions::query();
                            if (isset($status)) {
                                $cusTraQuery->where('status', $status);
                            }
                            if (isset($customer_id) && $customer_id > 0) {
                                $cusTraQuery->where('customer_id', $customer_id);
                            }
                            if (isset($assigned_upto) && !empty($assigned_upto)) {
                                $cusTraQuery->where('effective_date', '<=', $assigned_upto);
                            }
                            if (isset($collection_date) && !empty($collection_date)) {
                                $cusTraQuery->where('effective_date', '<=', $collection_date);
                            }
                            $cusTraQuery->whereIn('transaction_type', ['receipt_transfer', 'customer_receipt']);
                            $totalCredits = $cusTraQuery->sum('credits');
                            $collected = $totalCredits ? $totalCredits : 0;
                            $to_be_collected = $fetchTableDetail->customer_balance - $collected;

                            $html .= '<tr style="border:1px solid #444;">';
							$html .= '<td style="border:1px solid #444;">'.($i++) .'</td>';
							$html .= '<td style="border:1px solid #444;">'.$fetchTableDetail->code." - ".$fetchTableDetail->company.'</td>';
							$html .= '<td style="border:1px solid #444;">'.$fetchTableDetail->assigned_date.'</small></td>';
							$html .= '<td style="border:1px solid #444;">'.$fetchTableDetail->assigned_upto.'</small></td>';
							$html .= '<td style="border:1px solid #444;">'.$fetchTableDetail->collection_date.'</small></td>';
							$html .= '<td style="border:1px solid #444;" align="right">'.number_format($fetchTableDetail->customer_balance,2).'</td>';
							$html .= '<td style="border:1px solid #444;" align="right">'.number_format($collected,2).'</td>';
							$html .= '<td style="border:1px solid #444;" align="right">'.number_format($to_be_collected,2).'</td>';
							$html .= '</tr>';

							$assigned_total += $fetchTableDetail->customer_balance;
							$collected_total += $collected;
							$balance_total += $to_be_collected;
                        }

                        $html .= '<tr>';
						$html .= '<td style="border:1px solid #444;"></td>';
						$html .= '<td style="border:1px solid #444;"></td>';
						$html .= '<td style="border:1px solid #444;"></td>';
						$html .= '<td style="border:1px solid #444;"></td>';
						$html .= '<td style="border:1px solid #444;"><strong>TOTALS</strong></td>';
						$html .= '<td style="border:1px solid #444;" align="right"><strong>'.number_format($assigned_total,2).'</strong></td>';
						$html .= '<td style="border:1px solid #444;" align="right"><strong>'.number_format($collected_total,2).'</strong></td>';
						$html .= '<td style="border:1px solid #444;" align="right"><strong>'.number_format($balance_total,2).'</strong></td>';
						$html .= '</tr>';
						$html .='</tbody>';
						$html .='</table>';
						$html .='<hr/>';
						$html .='<small>This is an automatically generated email from Hotel PMS system @ '.date("Y-m-d H:i:s").'</small>';
						$html .='</small>';

                        $email_type = 'debts_assign';
                        $email_subject = "ASSIGNED DEBTS - AS AT ".date("Y-m-d");
                        $email_body = $html;
                        $email_recipient_email = $user_email;
                        $email_created_by = 1;

                        $sendEmailDatas = [
                            'type' => $email_type,
                            'format_id' => null,
                            'reference' => null,
                            'subject' => $email_subject,
                            'body' => $email_body,
                            'reply_to' => 'noreply@example.com',
                            'recipient_email' => $email_recipient_email,
                            'cc_email' => null,
                            'attachments' => null,
                            'scheduled_to' => null,
                            'created_by' => $email_created_by,
                            'is_sent' => 0,
                            'send_attempts' => 0,
                            'sent_at' => null,
                            'response' => '',
                        ];

                        $addEmailDatas = new Emails();
                        $addEmailDatas->fill($sendEmailDatas);
                        $addEmailDatas->save();

                        $messageType = 'success';
                        $message = "Email successfuly sent to ".$user_email;
                    }


                }else{
                    $messageType = 'error';
                    $message = "No assigned debts found for this collector, Sending email failed !!";
                }


            }else{
                $messageType = 'error';
                $message = "Debt collector's email address is invalid, Sending email failed !";
            }
            // $messageType = 'error';
            // $message = 'TEST';
        }else{
            $messageType = 'error';
            $message = 'There have no any user related this user id :'.$request->user_id;
        }
        // Prepare response data
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];

        // Return JSON response
        return response()->json($responseData);
    }
}
