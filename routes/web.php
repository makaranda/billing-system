<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AdminAuthController;
//use App\Http\Controllers\admin\AdminController;

use App\Http\Controllers\dashboard\CdrsController;
use App\Http\Controllers\dashboard\LoginController;
use App\Http\Controllers\dashboard\UsersController;
use App\Http\Controllers\dashboard\UserProfileController;
use App\Http\Controllers\dashboard\ExtensionsController;
use App\Http\Controllers\dashboard\DashboardController;

use App\Http\Controllers\dashboard\RemindersController;
use App\Http\Controllers\dashboard\reminders\PreremindersController;
use App\Http\Controllers\dashboard\reminders\RecurringAmmendmentsController;
use App\Http\Controllers\dashboard\reminders\RecurringRemindersController;
use App\Http\Controllers\dashboard\reminders\GeneratedRemindersController;
use App\Http\Controllers\dashboard\reminders\ReminderDeliveryController;
use App\Http\Controllers\dashboard\reminders\ArchiveCategoriesController;
use App\Http\Controllers\dashboard\reminders\AllocateCustomerController ;
use App\Http\Controllers\dashboard\reminders\FiscalReceiptsController;
use App\Http\Controllers\dashboard\reminders\CommunicationsController;
use App\Http\Controllers\dashboard\reminders\SuspendedListController;
use App\Http\Controllers\dashboard\reminders\TerminatedListController;

use App\Http\Controllers\dashboard\PrepaidController;
use App\Http\Controllers\dashboard\prepaid\PrepaidCustomersController;
use App\Http\Controllers\dashboard\prepaid\PrepaidFollowupsController;
use App\Http\Controllers\dashboard\prepaid\PrepaidActiveCustomerController;

//use App\Http\Controllers\dashboard\ServicesController;
use App\Http\Controllers\dashboard\CustomersController;
use App\Http\Controllers\dashboard\customers\CusCustomersController;
use App\Http\Controllers\dashboard\customers\CusAddCustomerGroupsController;
use App\Http\Controllers\dashboard\customers\CusAttachementsController;
use App\Http\Controllers\dashboard\customers\CusDebtorsController;
use App\Http\Controllers\dashboard\customers\CusCustomerReceiptsController;
use App\Http\Controllers\dashboard\customers\CusCreditNotesController;
use App\Http\Controllers\dashboard\customers\CusAllocateCustomerReceiptController;
use App\Http\Controllers\dashboard\customers\CusCorrectionsController;
use App\Http\Controllers\dashboard\customers\CusDebtManagementController;
use App\Http\Controllers\dashboard\customers\CusVasController;
use App\Http\Controllers\dashboard\customers\CusWhtCetificatesController;
use App\Http\Controllers\dashboard\customers\FiscalReceiptUploadController;

use App\Http\Controllers\dashboard\DocumentsController;
use App\Http\Controllers\dashboard\documents\QuotationFormatsController;
use App\Http\Controllers\dashboard\documents\QuotationInclusionsController;
use App\Http\Controllers\dashboard\documents\AddQuotationController;
use App\Http\Controllers\dashboard\documents\ViewQuotationController;
use App\Http\Controllers\dashboard\documents\ApprovequotationController;
use App\Http\Controllers\dashboard\documents\DocArchiveCategoriesController;
use App\Http\Controllers\dashboard\documents\AddArchiveController;
use App\Http\Controllers\dashboard\documents\AddEmailFormatsController;
use App\Http\Controllers\dashboard\documents\SendEmailsController;

use App\Http\Controllers\dashboard\PayonlineController;
use App\Http\Controllers\dashboard\payonline\AddOnlinePaymentController;
use App\Http\Controllers\dashboard\payonline\CreditCardsWipeDetailsController;
use App\Http\Controllers\dashboard\payonline\SwipeddCardsController;
use App\Http\Controllers\dashboard\payonline\OtaSettlementsReportController;
use App\Http\Controllers\dashboard\payonline\CreditCardSwipeDetailsReportController;
use App\Http\Controllers\dashboard\payonline\AddDankdepositController;
use App\Http\Controllers\dashboard\payonline\ApproveBankDepositsController;
use App\Http\Controllers\dashboard\payonline\CreditCardReconciliationController;

use App\Http\Controllers\dashboard\TasksController;
use App\Http\Controllers\dashboard\tasks\ApprovalRequestsController;
use App\Http\Controllers\dashboard\tasks\ThanksForTheDayController;
use App\Http\Controllers\dashboard\tasks\ThanksResponsesController;

use App\Http\Controllers\dashboard\RepostsController;
use App\Http\Controllers\dashboard\reports\RecurringConnectionsController;
use App\Http\Controllers\dashboard\reports\ReceiptDetailsreodrecController;
use App\Http\Controllers\dashboard\reports\ReceiptAllocationController;
use App\Http\Controllers\dashboard\reports\CreditNotesController;
use App\Http\Controllers\dashboard\reports\CreditNoteAllocationController;
use App\Http\Controllers\dashboard\reports\RemindersReportController;
use App\Http\Controllers\dashboard\reports\DebtAllocationReportController;
use App\Http\Controllers\dashboard\reports\BadPayersController;
use App\Http\Controllers\dashboard\reports\DebtorsSummaryController;
use App\Http\Controllers\dashboard\reports\RevenuerReportController;
use App\Http\Controllers\dashboard\reports\BankReconciliationReportController;
use App\Http\Controllers\dashboard\reports\SettlementReportController;
use App\Http\Controllers\dashboard\reports\DepositsReconciliationController;
use App\Http\Controllers\dashboard\reports\ReceiptRefundsController;
use App\Http\Controllers\dashboard\reports\ReportFiscalReceiptsController;

use App\Http\Controllers\dashboard\AccountingController;
use App\Http\Controllers\dashboard\accounting\NominalCategoriesController;
use App\Http\Controllers\dashboard\accounting\NominalSubCategoriesController;
use App\Http\Controllers\dashboard\accounting\NominalAccountsController;
use App\Http\Controllers\dashboard\accounting\BanksController;
use App\Http\Controllers\dashboard\accounting\BankAccountsController;
use App\Http\Controllers\dashboard\accounting\BankTransferController;
use App\Http\Controllers\dashboard\accounting\BankReconciliationsController;
use App\Http\Controllers\dashboard\accounting\BankdePosittypesController;

use App\Http\Controllers\dashboard\SettingsController;
use App\Http\Controllers\dashboard\settings\SystemController;
use App\Http\Controllers\dashboard\settings\DepartmentsController;
use App\Http\Controllers\dashboard\settings\OtaOperatorsController;
use App\Http\Controllers\dashboard\settings\CreditCardTypesController;
use App\Http\Controllers\dashboard\settings\ProductCategoriesController;
use App\Http\Controllers\dashboard\settings\ProductsController;
use App\Http\Controllers\dashboard\settings\TaxController;
use App\Http\Controllers\dashboard\settings\DefaultPaymentBanksController;
use App\Http\Controllers\dashboard\settings\CurrencyExchangeSettingsController;
use App\Http\Controllers\dashboard\settings\MessageFormatsController;
use App\Http\Controllers\dashboard\settings\CurrenciesController;
use App\Http\Controllers\dashboard\settings\PriceTypesController;
use App\Http\Controllers\dashboard\settings\SettingUsersController;
use App\Http\Controllers\dashboard\settings\CollectionBureausController;
use App\Http\Controllers\dashboard\settings\TerritoriesController;
use App\Http\Controllers\dashboard\settings\SetEmployeeOtFactorController;

use App\Http\Controllers\dashboard\EmailsController;

use App\Http\Controllers\dashboard\ReportsController;

use App\Http\Controllers\dashboard\MenusController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => '/'], function () {

    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login.index');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });
    Route::group(['middleware' => ['admin.auth','check.status','setSessionTimeout']], function () {
        //Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        //Route::get('/users', [AdminDashboardController::class, 'users'])->name('admin.users');
        Route::get('/export-excel', [DashboardController::class, 'excelExport'])->name('export.excell');
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.index');
        Route::get('/logout', [AdminDashboardController::class, 'logout'])->name('admin.logout');
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
            // Route::group(['prefix' => 'users', 'middleware' => 'role:admin'], function () {
            //     Route::get('/', [UsersController::class, 'index'])->name('admin.users');
            //     Route::get('/fetchusersAll', [UsersController::class, 'fetchuserAll'])->name('users.fetchusers');
            //     Route::post('/usersActive', [UsersController::class, 'userActive'])->name('users.userActive');
            //     Route::get('/create', [UsersController::class, 'create'])->name('users.create');
            //     Route::post('/save', [UsersController::class, 'save'])->name('users.save');
            //     Route::get('/{page_id}/delete', [UsersController::class, 'delete'])->name('users.delete');
            //     Route::get('/{page_id}/edit', [UsersController::class, 'edit'])->name('users.edit');
            //     Route::post('/{page_id}/update', [UsersController::class, 'update'])->name('users.update');
            //     Route::post('/saveRecord', [UsersController::class, 'saveRecord'])->name('users.saveRecord');
            // });
            Route::get('/users-availability',[AdminDashboardController::class,'usersAvailability'])->name('users.availability');
        //Reminders Prepaid Services Documents Pay Online Task Reports Accounting Settings
        Route::group(['prefix' => 'reminders', 'middleware' => 'role:admin'], function () {
            Route::get('/', [RemindersController::class, 'index'])->name('index.reminders');
            Route::get('/pre-reminders',[PreremindersController::class,'index'])->name('index.prepreminders');
            Route::get('/recurring-ammendments',[RecurringAmmendmentsController::class,'index'])->name('index.recurringammendments');
            Route::get('/recurring-reminders',[RecurringRemindersController::class,'index'])->name('index.recurringreminders');
            Route::get('/generated-reminders',[GeneratedRemindersController::class,'index'])->name('index.generatedreminders');
            Route::get('/converted-reminders',[ConvertedRemindersController::class,'index'])->name('index.convertedreminders');
            Route::get('/reminder-delivery',[ReminderDeliveryController::class,'index'])->name('index.reminderdelivery');
            Route::get('/archive-categories',[ArchiveCategoriesController::class,'index'])->name('index.archivecategories');
            Route::get('/allocate-customer',[AllocateCustomerController::class,'index'])->name('index.allocatecustomer');
            Route::get('/fiscal-receipts',[FiscalReceiptsController::class,'index'])->name('index.fiscalreceipts');
            Route::get('/communications',[CommunicationsController::class,'index'])->name('index.communications');
            Route::get('/suspended-list',[SuspendedListController::class,'index'])->name('index.suspendedlist');
            Route::get('/terminated-list',[TerminatedListController::class,'index'])->name('index.terminatedlist');
            //Route::get('/{route}', [MenusController::class, 'index'])->name('index.reminders');
        });

        Route::group(['prefix' => 'prepaid', 'middleware' => 'role:admin'], function () {
            Route::get('/', [PrepaidController::class, 'index'])->name('index.prepaid');
            Route::get('/prepaid-customers', [PrepaidCustomersController::class, 'index'])->name('index.prepaidcustomers');
            Route::get('/prepaid-followups', [PrepaidFollowupsController::class, 'index'])->name('index.prepaidfollowups');
            Route::get('/prepaid-4g-active-customer', [PrepaidActiveCustomerController::class, 'index'])->name('index.prepaidactivecustomer');
        });

        Route::group(['prefix' => 'customers', 'middleware' => 'role:admin'], function () {
            Route::get('/', [CustomersController::class, 'index'])->name('index.customers');

            Route::get('/allocate-customer-receipt', [CusAllocateCustomerReceiptController::class, 'index'])->name('index.cusallocatecustomerreceipt');
            Route::get('/corrections', [CusCorrectionsController::class, 'index'])->name('index.cuscorrections');
            Route::get('/debtors', [CusDebtorsController::class, 'index'])->name('index.cusdebtors');

            //Route::get('/creditnotes', [CusCreditNotesController::class, 'index'])->name('index.cuscreditnotes');
            //Route::get('/vas', [CusVasController::class, 'index'])->name('index.cusvas');
            //Route::get('/wht-cetificates', [CusWhtCetificatesController::class, 'index'])->name('index.cuswhtcetificates');
            //Route::get('/fiscal-receipt-upload', [FiscalReceiptUploadController::class, 'index'])->name('index.fiscalreceiptupload');
            //Route::get('/attachements', [CusAttachementsController::class, 'index'])->name('index.cusattachements');
            //Route::get('/debtors', [CusDebtorsController::class, 'index'])->name('index.cusdebtors');
            //Route::get('/debt-management', [CusDebtManagementController::class, 'index'])->name('index.cusdebtmanagement');

            Route::group(['prefix' => 'attachements', 'middleware' => 'role:admin'], function () {
                Route::get('/', [CusAttachementsController::class, 'index'])->name('index.cusattachements');
                Route::get('/fetch-attachements', [CusAttachementsController::class, 'fetchAttachements'])->name('cusattachements.fetchcusattachement');
                Route::post('/get-customers-names', [CusAttachementsController::class, 'getCustomersNames'])->name('cusattachements.getcustomersnames');
                Route::get('/{pro_id}/edit-attachement', [CusAttachementsController::class, 'editAttachement'])->name('cusattachements.editcusattachement');
                Route::post('/add-new-attachement', [CusAttachementsController::class, 'addAttachement'])->name('cusattachements.addcusattachement');
                Route::post('/{pro_id}/update-attachement', [CusAttachementsController::class, 'updateAttachement'])->name('cusattachements.updatecusattachement');
                Route::post('/{pro_id}/delete-attachement', [CusAttachementsController::class, 'deleteAttachement'])->name('cusattachements.deletecusattachement');
            });

            Route::group(['prefix' => 'debt-management', 'middleware' => 'role:admin'], function () {
                Route::get('/', [CusDebtManagementController::class, 'index'])->name('index.cusdebtmanagement');
                Route::get('/fetch-debt-managements', [CusDebtManagementController::class, 'fetchDebtManagement'])->name('cusdebtmanagement.fetchdebtmanagements');
                Route::get('/fetch-assigned-debts-list', [CusDebtManagementController::class, 'fetchAssignedDebtsList'])->name('cusdebtmanagement.fetchassigneddebtslist');
                Route::get('/fetch-get-remarks', [CusDebtManagementController::class, 'fetchGetRemarks'])->name('cusdebtmanagement.fetchgetremarks');
                Route::get('/view-debt/{debt_id}/{assign_date}', [CusDebtManagementController::class, 'viewDebtManagement'])->name('cusdebtmanagement.viewdebtmanagements');
                Route::get('/get-filtered-debt-list', [CusDebtManagementController::class, 'fetchFilteredDebt'])->name('cusdebtmanagement.fetchdebtfiltered');
                Route::get('/{pro_id}/edit-debt-management', [CusDebtManagementController::class, 'editDebtManagement'])->name('cusdebtmanagement.editdebtmanagement');
                Route::post('/add-new-debt-management', [CusDebtManagementController::class, 'addCusDebtManagement'])->name('cusdebtmanagement.adddebtmanagement');
                Route::get('/email-debts-confirmed', [EmailsController::class, 'emailSave'])->name('cusdebtmanagement.emaildebtconfirme');
                Route::post('/assign-debt-collector', [CusDebtManagementController::class, 'assignDebtCollector'])->name('cusdebtmanagement.assigndebtcollector');
                Route::post('/debts-assignment-remarks', [CusDebtManagementController::class, 'DebtAssignmentsRemarks'])->name('cusdebtmanagement.debtsassignmentremarks');
                Route::post('/{pro_id}/update-debt-management', [CusDebtManagementController::class, 'updateDebtManagement'])->name('cusdebtmanagement.updatedebtmanagement');
                Route::post('/{pro_id}/delete-debt-management', [CusDebtManagementController::class, 'deleteDebtManagement'])->name('cusdebtmanagement.deletedebtmanagement');
            });

            Route::group(['prefix' => 'creditnotes', 'middleware' => 'role:admin'], function () {
                Route::get('/', [CusCreditNotesController::class, 'index'])->name('index.cuscreditnotes');
                Route::get('/ccn-id/{ccn_id}', [CusCreditNotesController::class, 'addFormCusCreditNotes'])->name('cuscreditnotes.addformcuscreditnotes');
                Route::get('/fetch-creditnotes', [CusCreditNotesController::class, 'fetchCusCreditnotes'])->name('cuscreditnotes.fetchcuscreditnote');
                Route::get('/{pro_id}/edit-creditnote', [CusCreditNotesController::class, 'editCusCreditnote'])->name('cuscreditnotes.edicuscreditnote');
                Route::post('/add-new-creditnote', [CusCreditNotesController::class, 'addCusCreditnot'])->name('cuscreditnotes.addcuscreditnote');
                Route::post('/{pro_id}/update-creditnote', [CusCreditNotesController::class, 'updateCusCreditnote'])->name('cuscreditnotes.updatecuscreditnote');
                Route::post('/{pro_id}/delete-creditnote', [CusCreditNotesController::class, 'deleteCusCreditnote'])->name('cuscreditnotes.deletecuscreditnote');
            });

            Route::group(['prefix' => 'vas', 'middleware' => 'role:admin'], function () {
                Route::get('/', [CusVasController::class, 'index'])->name('index.cusvas');
                Route::get('/fetch-vas', [CusVasController::class, 'fetchVas'])->name('cusvas.fetchvas');
                Route::get('/{pro_id}/edit-vas', [CusVasController::class, 'editVas'])->name('cusvas.editvas');
                Route::post('/get-product-category', [CusVasController::class, 'getProductCategory'])->name('cusvas.getproductcategory');
                Route::post('/add-new-vas', [CusVasController::class, 'addVas'])->name('cusvas.addvas');
                Route::post('/{pro_id}/update-vas', [CusVasController::class, 'updateVas'])->name('cusvas.updatevas');
                Route::post('/{pro_id}/delete-vas', [CusVasController::class, 'deleteVas'])->name('cusvas.deletevas');
            });

            Route::group(['prefix' => 'wht-cetificates', 'middleware' => 'role:admin'], function () {
                Route::get('/', [CusWhtCetificatesController::class, 'index'])->name('index.cuswhtcetificates');
                Route::get('/fetch-wht-cetificates', [CusWhtCetificatesController::class, 'fetchWhtCetificates'])->name('cuswhtcetificates.fetchwhtcetificates');
                Route::get('/{pro_id}/edit-wht-cetificate', [CusWhtCetificatesController::class, 'editWhtCetificate'])->name('cuswhtcetificates.editwhtcetificate');
                Route::post('/add-new-wht-cetificate', [CusWhtCetificatesController::class, 'addWhtCetificate'])->name('cuswhtcetificates.addwhtcetificate');
                Route::post('/{pro_id}/update-wht-cetificate', [CusWhtCetificatesController::class, 'updateWhtCetificate'])->name('cuswhtcetificates.updatewhtcetificate');
                Route::post('/{pro_id}/delete-wht-cetificate', [CusWhtCetificatesController::class, 'deleteWhtCetificate'])->name('cuswhtcetificates.deletewhtcetificate');
            });

            Route::group(['prefix' => 'fiscal-receipt-upload', 'middleware' => 'role:admin'], function () {
                Route::get('/', [FiscalReceiptUploadController::class, 'index'])->name('index.fiscalreceiptupload');
                Route::get('/fetch-fiscal-receipts', [FiscalReceiptUploadController::class, 'fetchFiscalReceipts'])->name('fiscalreceiptupload.fetchfiscalreceipts');
                Route::get('/{pro_id}/edit-fiscal-receipt', [FiscalReceiptUploadController::class, 'editFiscalReceipt'])->name('fiscalreceiptupload.editfiscalreceipt');
                Route::post('/add-new-fiscal-receipt', [FiscalReceiptUploadController::class, 'addFiscalReceipt'])->name('fiscalreceiptupload.addfiscalreceipt');
                Route::post('/{pro_id}/update-fiscal-receipt', [FiscalReceiptUploadController::class, 'updateFiscalReceipt'])->name('fiscalreceiptupload.updatefiscalreceipt');
                Route::post('/{pro_id}/delete-fiscal-receipt', [FiscalReceiptUploadController::class, 'deleteFiscalReceipt'])->name('fiscalreceiptupload.deletefiscalreceipt');
            });

            Route::group(['prefix' => 'customer-receipts', 'middleware' => 'role:admin'], function () {
                Route::get('/', [CusCustomerReceiptsController::class, 'index'])->name('index.cuscustomerreceipts');
                Route::get('/fetch-customer-receipts', [CusCustomerReceiptsController::class, 'fetchCustomerReceipts'])->name('cuscustomerreceipts.fetchcustomerreceipts');
                Route::get('/get-customer-receipts-history', [CusCustomerReceiptsController::class, 'getCustomerReceiptsHistory'])->name('cuscustomerreceipts.getcustomerreceiptshistory');
                Route::get('/post-customer-receipts', [CusCustomerReceiptsController::class, 'postCustomerReceipt'])->name('cuscustomerreceipts.postcustomerreceipt');
                Route::post('/get-converted-payment-amount', [CusCustomerReceiptsController::class, 'getConvertedPaymentAmount'])->name('cuscustomerreceipts.getconvertedpaymentamount');
                Route::post('/get-default-bank-payment-method', [BankAccountsController::class, 'getDefaultBankPaymentMethod'])->name('cuscustomerreceipts.getdefaultbankpaymentmethod');
                Route::get('/{pro_id}/edit-customer-receipt', [CusCustomerReceiptsController::class, 'editCustomerReceipt'])->name('cuscustomerreceipts.editcustomerreceipt');
                Route::post('/add-new-customer-receipt', [CusCustomerReceiptsController::class, 'addCustomerReceipt'])->name('cuscustomerreceipts.addcustomerreceipt');
                Route::post('/{pro_id}/update-customer-receipt', [CusCustomerReceiptsController::class, 'updateCustomerReceipt'])->name('cuscustomerreceipts.updatecustomerreceipt');
                Route::post('/{pro_id}/delete-customer-receipt', [CusCustomerReceiptsController::class, 'deleteCustomerReceipt'])->name('cuscustomerreceipts.deletecustomerreceipt');
            });

            Route::group(['prefix' => 'customers', 'middleware' => 'role:admin'], function () {
                Route::get('/', [CusCustomersController::class, 'index'])->name('index.cuscustomers');
                Route::get('/fetch-customers', [CusCustomersController::class, 'fetchCustomers'])->name('cuscustomers.fetchcustomers');
                Route::get('/reports/{report_type}/{report_name}/{ref_id}', [ReportsController::class, 'getCustomersReport'])->name('cuscustomers.getcustomersreports');
                Route::get('/{cus_id}/fetch-customer-statement', [CusCustomersController::class, 'fetchStatementCustomer'])->name('cuscustomers.fetchstatementcustomer');
                Route::get('/get-email-details', [SettingsController::class, 'getEmailDetails'])->name('cuscustomers.getemaildetailscustomer');
                Route::get('/{pro_id}/edit-customer', [CusCustomersController::class, 'editCustomer'])->name('cuscustomers.editcustomer');
                Route::post('/add-new-customer', [CusCustomersController::class, 'addCustomer'])->name('cuscustomers.addcustomer');
                Route::post('/{pro_id}/update-customer', [CusCustomersController::class, 'updateCustomer'])->name('cuscustomers.updatecustomer');
                Route::post('/{pro_id}/delete-customer', [CusCustomersController::class, 'deleteCustomer'])->name('cuscustomers.deletecustomer');
            });

            Route::group(['prefix' => 'add-customer-groups', 'middleware' => 'role:admin'], function () {
                Route::get('/', [CusAddCustomerGroupsController::class, 'index'])->name('index.cusaddcustomergroups');
                Route::get('/fetch-add-customer-group', [CusAddCustomerGroupsController::class, 'fetchAddCustomerGroups'])->name('cusaddcustomergroups.fetchaddcustomergroups');
                Route::get('/{pro_id}/edit-add-customer-group', [CusAddCustomerGroupsController::class, 'editCustomerGroup'])->name('cusaddcustomergroups.editcustomergroup');
                Route::post('/add-new-customer-group', [CusAddCustomerGroupsController::class, 'addCustomerGroup'])->name('cusaddcustomergroups.addcustomergroup');
                Route::post('/{pro_id}/update-add-customer-group', [CusAddCustomerGroupsController::class, 'updateCustomerGroup'])->name('cusaddcustomergroups.updatecustomergroup');
                Route::post('/{pro_id}/delete-add-customer-group', [CusAddCustomerGroupsController::class, 'deleteCustomerGroup'])->name('cusaddcustomergroups.deletecustomergroup');
                Route::get('/customer-group-pdf', [CusAddCustomerGroupsController::class, 'generateCusGroupPDF'])->name('cusaddcustomergroups.pdf');
                Route::get('/export-customer-group', [CusAddCustomerGroupsController::class, 'generateCusGroupExcel'])->name('cusaddcustomergroups.excel');
            });
        });

        Route::group(['prefix' => 'documents', 'middleware' => 'role:admin'], function () {
            Route::get('/', [DocumentsController::class, 'index'])->name('index.documents');
            Route::get('/quotation-formats', [QuotationFormatsController::class, 'index'])->name('index.quotationformats');
            Route::get('/quotation-inclusions', [QuotationInclusionsController::class, 'index'])->name('index.quotationinclusions');
            Route::get('/add-quotation', [AddQuotationController::class, 'index'])->name('index.addquotation');
            Route::get('/view-quotation', [ViewQuotationController::class, 'index'])->name('index.viewquotation');
            Route::get('/approve-quotation', [ApprovequotationController::class, 'index'])->name('index.approvequotation');
            Route::get('/archive-categories', [DocArchiveCategoriesController::class, 'index'])->name('index.docarchivecategories');
            Route::get('/add-archive', [AddArchiveController::class, 'index'])->name('index.addarchive');
            Route::get('/add-email-formats', [AddEmailFormatsController::class, 'index'])->name('index.addemailformats');
            Route::get('/send-emails', [SendEmailsController::class, 'index'])->name('index.sendemails');

            Route::group(['prefix' => 'archive-categories', 'middleware' => 'role:admin'], function () {
                Route::get('/', [DocArchiveCategoriesController::class, 'index'])->name('index.docarchivecategories');
                Route::get('/fetch-archive-categories', [DocArchiveCategoriesController::class, 'fetchArchiveCategories'])->name('docarchivecategories.fetcharchivecategories');
                Route::get('/{pro_id}/edit-archive-category', [DocArchiveCategoriesController::class, 'editArchiveCategory'])->name('docarchivecategories.editarchivecategory');
                Route::post('/add-new-archive-category', [DocArchiveCategoriesController::class, 'addArchiveCategory'])->name('docarchivecategories.addarchivecategory');
                Route::post('/{pro_id}/update-archive-category', [DocArchiveCategoriesController::class, 'updateArchiveCategory'])->name('docarchivecategories.updatearchivecategory');
                Route::post('/{pro_id}/delete-archive-category', [DocArchiveCategoriesController::class, 'deleteArchiveCategory'])->name('docarchivecategories.deletearchivecategory');
            });
        });

        Route::group(['prefix' => 'pay-online', 'middleware' => 'role:admin'], function () {
            Route::get('/', [PayonlineController::class, 'index'])->name('index.payonline');
            Route::get('/add-online-payment', [AddOnlinePaymentController::class, 'index'])->name('index.addonlinepayment');
            Route::get('/credit-card-swipe-details', [CreditCardsWipeDetailsController::class, 'index'])->name('index.creditcardswipedetails');
            Route::get('/swiped-cards', [SwipeddCardsController::class, 'index'])->name('index.swipedcards');
            Route::get('/ota-settlements-report', [OtaSettlementsReportController::class, 'index'])->name('index.otasettlementsreport');
            Route::get('/credit-card-swipe-details-report', [CreditCardSwipeDetailsReportController::class, 'index'])->name('index.creditcardswipedetailsreport');
            Route::get('/add-bank-deposit', [AddDankdepositController::class, 'index'])->name('index.addbankdeposit');
            Route::get('/approve-bank-deposits', [ApproveBankDepositsController::class, 'index'])->name('index.approvebankdeposits');
            Route::get('/credit-card-reconciliation', [CreditCardReconciliationController::class, 'index'])->name('index.creditcardreconciliation');
        });

        Route::group(['prefix' => 'tasks', 'middleware' => 'role:admin'], function () {
            Route::get('/', [TasksController::class, 'index'])->name('index.tasks');
            Route::get('/approval-requests', [ApprovalRequestsController::class, 'index'])->name('index.approvalrequests');
            Route::get('/thanks-for-the-day', [ThanksForTheDayController::class, 'index'])->name('index.thanksfortheday');
            Route::get('/thanks-responses', [ThanksResponsesController::class, 'index'])->name('index.thanksresponses');
        });

        Route::group(['prefix' => 'reports', 'middleware' => 'role:admin'], function () {
            Route::get('/', [RepostsController::class, 'index'])->name('index.reports');
            Route::get('/recurring-connections-by-next-date', [RecurringConnectionsController::class, 'index'])->name('index.recurringconnectionsbynextdate');
            Route::get('/receipt-details-reod-rec-4', [ReceiptDetailsreodrecController::class, 'index'])->name('index.receiptdetailsreodrec');
            Route::get('/receipt-allocation', [ReceiptAllocationController::class, 'index'])->name('index.receiptallocation');
            Route::get('/credit-notes', [CreditNotesController::class, 'index'])->name('index.creditnotes');
            Route::get('/creditnote-allocation', [CreditNoteAllocationController::class, 'index'])->name('index.creditnoteallocation');
            Route::get('/reminders-report', [RemindersReportController::class, 'index'])->name('index.remindersreport');
            Route::get('/debt-allocation-report', [DebtAllocationReportController::class, 'index'])->name('index.debtallocationreport');
            Route::get('/bad-payers', [BadPayersController::class, 'index'])->name('index.badpayers');
            Route::get('/debtors-summary', [DebtorsSummaryController::class, 'index'])->name('index.debtorssummary');
            Route::get('/revenue-report', [RevenuerReportController::class, 'index'])->name('index.revenuereport');
            Route::get('/bank-reconciliation-report', [BankReconciliationReportController::class, 'index'])->name('index.bankreconciliationreport');
            Route::get('/settlement-report', [SettlementReportController::class, 'index'])->name('index.settlementreport');
            Route::get('/deposits-reconciliation-report', [DepositsReconciliationController::class, 'index'])->name('index.depositsreconciliationreport');
            Route::get('/receipt-refunds', [ReceiptRefundsController::class, 'index'])->name('index.receiptrefunds');
            Route::get('/fiscal-receipts-reports', [ReportFiscalReceiptsController::class, 'index'])->name('index.reportfiscalreceipts');
        });

        Route::group(['prefix' => 'accounting', 'middleware' => 'role:admin'], function () {
            Route::get('/', [AccountingController::class, 'index'])->name('index.accounting');

            Route::get('/bank-transfer', [BankTransferController::class, 'index'])->name('index.banktransfer');

            Route::group(['prefix' => 'bank-reconciliations', 'middleware' => 'role:admin'], function () {
                Route::get('/', [BankReconciliationsController::class, 'index'])->name('index.bankreconciliations');
                Route::get('/fetch-bank-reconciliation', [BankReconciliationsController::class, 'fetchBankReconciliations'])->name('bankreconciliations.fetchbankreconciliations');
                Route::get('/{pro_id}/edit-bank-reconciliation', [BankReconciliationsController::class, 'editBankReconciliation'])->name('bankreconciliations.editbankreconciliation');
                Route::post('/add-new-bank-reconciliation', [BankReconciliationsController::class, 'addBankReconciliation'])->name('bankreconciliations.addbankreconciliation');
                Route::post('/{pro_id}/update-bank-reconciliation', [BankReconciliationsController::class, 'updateBankReconciliation'])->name('bankreconciliations.updatebankreconciliation');
                Route::post('/{pro_id}/delete-bank-reconciliation', [BankReconciliationsController::class, 'deleteBankReconciliation'])->name('bankreconciliations.deletebankreconciliation');
                Route::post('/{pro_id}/disable-bank-reconciliation', [BankReconciliationsController::class, 'disableBankReconciliation'])->name('bankreconciliations.disablebankreconciliation');
            });

            Route::group(['prefix' => 'bank-deposit-types', 'middleware' => 'role:admin'], function () {
                Route::get('/', [BankdePosittypesController::class, 'index'])->name('index.bankdeposittypes');
                Route::get('/fetch-bank-deposit-types', [BankdePosittypesController::class, 'fetchBankDepositTypes'])->name('bankdeposittypes.fetchbankdeposittypes');
                Route::get('/{pro_id}/edit-bank-deposit-type', [BankdePosittypesController::class, 'editBankDepositType'])->name('bankdeposittypes.editbankdeposittype');
                Route::post('/add-new-bank-deposit-type', [BankdePosittypesController::class, 'addBankDepositType'])->name('bankdeposittypes.addbankdeposittype');
                Route::post('/{pro_id}/update-bank-deposit-type', [BankdePosittypesController::class, 'updateBankDepositType'])->name('bankdeposittypes.updatebankdeposittype');
                Route::post('/{pro_id}/delete-bank-deposit-type', [BankdePosittypesController::class, 'deleteBankDepositType'])->name('bankdeposittypes.deletebankdeposittype');
            });

            Route::group(['prefix' => 'bank-accounts', 'middleware' => 'role:admin'], function () {
                Route::get('/', [BankAccountsController::class, 'index'])->name('index.bankaccounts');
                Route::get('/fetch-bank-accounts', [BankAccountsController::class, 'fetchBankAccounts'])->name('bankaccounts.fetchbankaccounts');
                Route::get('/{pro_id}/edit-bank-account', [BankAccountsController::class, 'editBankAccount'])->name('bankaccounts.editbankaccount');
                Route::post('/add-new-bank-account', [BankAccountsController::class, 'addBankAccount'])->name('bankaccounts.addbankaccount');
                Route::post('/{pro_id}/update-bank-account', [BankAccountsController::class, 'updateBankAccount'])->name('bankaccounts.updatebankaccount');
                Route::post('/{pro_id}/delete-bank-account', [BankAccountsController::class, 'deleteBankAccount'])->name('bankaccounts.deletebankaccount');
            });

            Route::group(['prefix' => 'banks', 'middleware' => 'role:admin'], function () {
                Route::get('/', [BanksController::class, 'index'])->name('index.banks');
                Route::get('/fetch-banks', [BanksController::class, 'fetchBanks'])->name('banks.fetchbanks');
                Route::get('/{pro_id}/edit-bank', [BanksController::class, 'editBank'])->name('banks.editbank');
                Route::post('/add-new-bank', [BanksController::class, 'addBank'])->name('banks.addbank');
                Route::post('/{pro_id}/update-bank', [BanksController::class, 'updateBank'])->name('banks.updatebank');
                Route::post('/{pro_id}/delete-bank', [BanksController::class, 'deleteBank'])->name('banks.deletebank');
            });

            Route::group(['prefix' => 'nominal-accounts', 'middleware' => 'role:admin'], function () {
                Route::get('/', [NominalAccountsController::class, 'index'])->name('index.nominalaccounts');
                Route::get('/fetch-nominal-accounts', [NominalAccountsController::class, 'fetchNominalAccounts'])->name('nominalaccounts.fetchnominalaccounts');
                Route::get('/fetch-accounts-activities', [NominalAccountsController::class, 'fetchAccountsActivities'])->name('nominalaccounts.fetchaccountsactivities');
                Route::get('/{pro_id}/edit-nominal-account', [NominalAccountsController::class, 'editNominalAccount'])->name('nominalaccounts.editnominalaccount');
                Route::post('/add-new-nominal-account', [NominalAccountsController::class, 'addNominalAccount'])->name('nominalaccounts.addnominalaccount');
                Route::post('/{pro_id}/update-nominal-account', [NominalAccountsController::class, 'updateNominalAccount'])->name('nominalaccounts.updatenominalaccount');
                Route::post('/{pro_id}/delete-nominal-account', [NominalAccountsController::class, 'deleteNominalAccount'])->name('nominalaccounts.deletenominalaccount');
                Route::post('/{pro_id}/disable-nominal-account', [NominalAccountsController::class, 'disableNominalAccount'])->name('nominalaccounts.disablenominalaccount');
                Route::get('/{pro_id}/get-subcategories', [NominalAccountsController::class, 'getSubCategories'])->name('nominalaccounts.getsubcategories');
            });

            Route::group(['prefix' => 'nominal-subcategories', 'middleware' => 'role:admin'], function () {
                Route::get('/', [NominalSubCategoriesController::class, 'index'])->name('index.nominalsubcategories');
                Route::get('/fetch-nominal-subcategories', [NominalSubCategoriesController::class, 'fetchNominalSubCategories'])->name('nominalsubcategories.fetchnominalsubcategories');
                Route::get('/{pro_id}/edit-nominal-category', [NominalSubCategoriesController::class, 'editNominalSubCategory'])->name('nominalsubcategories.editnominalsubcategory');
                Route::post('/add-new-nominal-category', [NominalSubCategoriesController::class, 'addNominalSubCategory'])->name('nominalsubcategories.addnominalsubcategory');
                Route::post('/{pro_id}/update-nominal-category', [NominalSubCategoriesController::class, 'updateNominalSubCategory'])->name('nominalsubcategories.updatenominalsubcategory');
                Route::post('/{pro_id}/delete-nominal-category', [NominalSubCategoriesController::class, 'deleteNominalSubCategory'])->name('nominalsubcategories.deletenominalsubcategory');
            });

            Route::group(['prefix' => 'nominal-categories', 'middleware' => 'role:admin'], function () {
                Route::get('/', [NominalCategoriesController::class, 'index'])->name('index.nominalcategories');
                Route::get('/fetch-nominal-categories', [NominalCategoriesController::class, 'fetchNominalCategories'])->name('nominalcategories.fetchnominalcategories');
                Route::get('/{pro_id}/edit-nominal-category', [NominalCategoriesController::class, 'editNominalCategory'])->name('nominalcategories.editnominalcategory');
                Route::post('/add-new-nominal-category', [NominalCategoriesController::class, 'addNominalCategory'])->name('nominalcategories.addnominalcategory');
                Route::post('/{pro_id}/update-nominal-category', [NominalCategoriesController::class, 'updateNominalCategory'])->name('nominalcategories.updatenominalcategory');
                Route::post('/{pro_id}/delete-nominal-category', [NominalCategoriesController::class, 'deleteNominalCategory'])->name('nominalcategories.deletenominalcategory');
            });
        });

        Route::group(['prefix' => 'settings', 'middleware' => 'role:admin'], function () {
            Route::get('/', [SettingsController::class, 'index'])->name('index.settings');
            Route::get('/currency-exchange-settings', [CurrencyExchangeSettingsController::class, 'index'])->name('index.currencyexchangesettings');

            Route::group(['prefix' => 'price-types', 'middleware' => 'role:admin'], function () {
                Route::get('/', [PriceTypesController::class, 'index'])->name('index.pricetypes');
                Route::get('/fetch-price-types', [PriceTypesController::class, 'fetchPriceTypes'])->name('pricetypes.fetchpricetypes');
                Route::get('/{pro_id}/edit-price-type', [PriceTypesController::class, 'editPriceType'])->name('pricetypes.editpricetype');
                Route::post('/add-new-price-type', [PriceTypesController::class, 'addPriceType'])->name('pricetypes.addpricetype');
                Route::post('/{pro_id}/update-price-type', [PriceTypesController::class, 'updatePriceType'])->name('pricetypes.updatepricetype');
                Route::post('/{pro_id}/delete-price-type', [PriceTypesController::class, 'deletePriceType'])->name('pricetypes.deletepricetype');
            });

            Route::group(['prefix' => 'ota-operators', 'middleware' => 'role:admin'], function () {
                Route::get('/', [OtaOperatorsController::class, 'index'])->name('index.otaoperators');
                Route::get('/fetch-ota-operators', [OtaOperatorsController::class, 'fetchOtaOperators'])->name('otaoperators.fetchotaoperators');
                Route::get('/{pro_id}/edit-ota-operator', [OtaOperatorsController::class, 'editOtaOperator'])->name('otaoperators.editotaoperator');
                Route::post('/add-new-ota-operator', [OtaOperatorsController::class, 'addOtaOperator'])->name('otaoperators.addotaoperator');
                Route::post('/{pro_id}/update-ota-operator', [OtaOperatorsController::class, 'updateOtaOperator'])->name('otaoperators.updateotaoperator');
                Route::post('/{pro_id}/delete-ota-operator', [OtaOperatorsController::class, 'deleteOtaOperator'])->name('otaoperators.deleteotaoperator');
            });

            Route::group(['prefix' => 'default-payment-banks', 'middleware' => 'role:admin'], function () {
                Route::get('/', [DefaultPaymentBanksController::class, 'index'])->name('index.defaultpaymentbanks');
                Route::get('/fetch-default-payment-banks', [DefaultPaymentBanksController::class, 'fetchDefaultPaymentBanks'])->name('defaultpaymentbanks.fetchdefaultpaymentbanks');
                Route::get('/{pro_id}/edit-default-payment-bank', [DefaultPaymentBanksController::class, 'editDefaultPaymentBank'])->name('defaultpaymentbanks.editdefaultpaymentbank');
                Route::post('/add-new-default-payment-bank', [DefaultPaymentBanksController::class, 'addDefaultPaymentBank'])->name('defaultpaymentbanks.adddefaultpaymentbank');
                Route::post('/{pro_id}/update-default-payment-bank', [DefaultPaymentBanksController::class, 'updateDefaultPaymentBank'])->name('defaultpaymentbanks.updatedefaultpaymentbank');
                Route::post('/{pro_id}/delete-default-payment-bank', [DefaultPaymentBanksController::class, 'deleteDefaultPaymentBank'])->name('defaultpaymentbanks.deletedefaultpaymentbank');
            });

            Route::group(['prefix' => 'set-employee-ot-factor', 'middleware' => 'role:admin'], function () {
                Route::get('/', [SetEmployeeOtFactorController::class, 'index'])->name('index.setemployeeotfactor');
                Route::get('/fetch-set-employee-ot-factor', [SetEmployeeOtFactorController::class, 'fetchSetEmployeeOtFactor'])->name('setemployeeotfactor.fetchsetemployeeotfactor');
                Route::get('/{pro_id}/edit-set-employee-ot-factor', [SetEmployeeOtFactorController::class, 'editSetEmployeeOtFactor'])->name('setemployeeotfactor.editsetemployeeotfactor');
                Route::post('/add-new-set-employee-ot-factor', [SetEmployeeOtFactorController::class, 'addSetEmployeeOtFactor'])->name('setemployeeotfactor.addsetemployeeotfactor');
                Route::post('/{pro_id}/update-set-employee-ot-factor', [SetEmployeeOtFactorController::class, 'updateSetEmployeeOtFactor'])->name('setemployeeotfactor.updatesetemployeeotfactor');
                Route::post('/{pro_id}/delete-set-employee-ot-factor', [SetEmployeeOtFactorController::class, 'deleteSetEmployeeOtFactor'])->name('setemployeeotfactor.deletesetemployeeotfactor');
            });

            Route::group(['prefix' => 'territories', 'middleware' => 'role:admin'], function () {
                Route::get('/', [TerritoriesController::class, 'index'])->name('index.territories');
                Route::get('/fetch-territories', [TerritoriesController::class, 'fetchTerritories'])->name('territories.fetchterritories');
                Route::get('/{pro_id}/edit-territory', [TerritoriesController::class, 'editTerritory'])->name('territories.editterritory');
                Route::post('/add-new-territory', [TerritoriesController::class, 'addTerritory'])->name('territories.addterritory');
                Route::post('/{pro_id}/update-territory', [TerritoriesController::class, 'updateTerritory'])->name('territories.updateterritory');
                Route::post('/{pro_id}/delete-territory', [TerritoriesController::class, 'deleteTerritory'])->name('territories.deleteterritory');
            });

            Route::group(['prefix' => 'credit-card-types', 'middleware' => 'role:admin'], function () {
                Route::get('/', [CreditCardTypesController::class, 'index'])->name('index.creditcardtypes');
                Route::get('/fetch-credit-card-types', [CreditCardTypesController::class, 'fetchproCreditCardTypes'])->name('creditcardtypes.fetchcreditcardtypes');
                Route::get('/{pro_id}/edit-credit-card-type', [CreditCardTypesController::class, 'editCreditCardTypesy'])->name('creditcardtypes.editcreditcardtypes');
                Route::post('/add-credit-card-type', [CreditCardTypesController::class, 'addCreditCardTypes'])->name('creditcardtypes.addcreditcardtypes');
                Route::post('/{pro_id}/update-credit-card-type', [CreditCardTypesController::class, 'updateCreditCardTypes'])->name('creditcardtypes.updatecreditcardtypes');
                Route::post('/{pro_id}/delete-credit-card-type', [CreditCardTypesController::class, 'deleteCreditCardTypes'])->name('creditcardtypes.deletecreditcardtypes');
            });

            Route::group(['prefix' => 'collection-bureaus', 'middleware' => 'role:admin'], function () {
                Route::get('/', [CollectionBureausController::class, 'index'])->name('index.collectionbureaus');
                Route::get('/fetch-collection-bureaus', [CollectionBureausController::class, 'fetchCollectionBureaus'])->name('collectionbureaus.fetchcollectionbureaus');
                Route::get('/{pro_id}/edit-collection-bureaus', [CollectionBureausController::class, 'editCollectionBureaus'])->name('collectionbureaus.editcollectionbureaus');
                Route::post('/add-new-collection-bureaus', [CollectionBureausController::class, 'addCollectionBureaus'])->name('collectionbureaus.addcollectionbureaus');
                Route::post('/{pro_id}/update-collection-bureaus', [CollectionBureausController::class, 'updateCollectionBureaus'])->name('collectionbureaus.updatecollectionbureaus');
                Route::post('/{pro_id}/delete-collection-bureaus', [CollectionBureausController::class, 'deleteCollectionBureaus'])->name('collectionbureaus.deletecollectionbureaus');
            });

            Route::group(['prefix' => 'currencies', 'middleware' => 'role:admin'], function () {
                Route::get('/', [CurrenciesController::class, 'index'])->name('index.currencies');
                Route::get('/fetch-currencies', [CurrenciesController::class, 'fetchproCurrencies'])->name('currencies.fetchcurrencies');
                Route::get('/{pro_id}/edit-currency', [CurrenciesController::class, 'editCurrency'])->name('currencies.editcurrency');
                Route::post('/add-new-currency', [CurrenciesController::class, 'addCurrency'])->name('currencies.addcurrency');
                Route::post('/{pro_id}/update-currency', [CurrenciesController::class, 'updateCurrency'])->name('currencies.updatecurrency');
                Route::post('/{pro_id}/delete-currency', [CurrenciesController::class, 'deleteCurrency'])->name('currencies.deletecurrency');
            });

            Route::group(['prefix' => 'message-formats', 'middleware' => 'role:admin'], function () {
                Route::get('/', [MessageFormatsController::class, 'index'])->name('index.messageformats');
                Route::get('/fetch-messageformats', [MessageFormatsController::class, 'fetchproMessageFormats'])->name('messageformats.fetchmessageformats');
                Route::get('/{pro_id}/edit-messageformat', [MessageFormatsController::class, 'editMessageFormat'])->name('messageformats.editmessageformat');
                Route::post('/add-new-messageformat', [MessageFormatsController::class, 'addMessageFormat'])->name('messageformats.addmessageformat');
                Route::post('/{pro_id}/update-messageformat', [MessageFormatsController::class, 'updateMessageFormat'])->name('messageformats.updatemessageformat');
                Route::post('/{pro_id}/delete-messageformat', [MessageFormatsController::class, 'deleteMessageFormat'])->name('messageformats.deletemessageformat');
            });

            Route::group(['prefix' => 'tax', 'middleware' => 'role:admin'], function () {
                Route::get('/', [TaxController::class, 'index'])->name('index.tax');
                Route::get('/fetch-taxes', [TaxController::class, 'fetchproTaxesAll'])->name('tax.fetchtaxes');
                Route::get('/{pro_id}/edit-tax', [TaxController::class, 'editTax'])->name('tax.edittax');
                Route::post('/add-new-tax', [TaxController::class, 'addTax'])->name('tax.addtax');
                Route::post('/{pro_id}/update-tax', [TaxController::class, 'updateTax'])->name('tax.updatetax');
                Route::post('/{pro_id}/delete-tax', [TaxController::class, 'deleteTax'])->name('tax.deletetax');
            });

            Route::group(['prefix' => 'products', 'middleware' => 'role:admin'], function () {
                Route::get('/', [ProductsController::class, 'index'])->name('index.products');
                Route::get('/fetch-products', [ProductsController::class, 'fetchproProductsAll'])->name('products.fetchproproducts');
                Route::get('/{pro_id}/edit-product', [ProductsController::class, 'editProduct'])->name('products.editproduct');
                Route::post('/add-new-product', [ProductsController::class, 'addProduct'])->name('products.addproduct');
                Route::post('/{pro_id}/update-product', [ProductsController::class, 'updateProduct'])->name('products.updateproduct');
                Route::post('/{pro_id}/delete-product', [ProductsController::class, 'deleteProduct'])->name('products.deleteproduct');
            });

            Route::group(['prefix' => 'product-categories', 'middleware' => 'role:admin'], function () {
                Route::get('/', [ProductCategoriesController::class, 'index'])->name('index.productcategories');
                Route::get('/fetch-product-categories', [ProductCategoriesController::class, 'fetchproCategoriesAll'])->name('productcategories.fetchprocategories');
                Route::get('/{cat_id}/edit-product-categories', [ProductCategoriesController::class, 'editProCategories'])->name('categories.editproductcategory');
                Route::post('/add-new-product-category', [ProductCategoriesController::class, 'addProductCategory'])->name('categories.addproductcategory');
                Route::post('/{cat_id}/update-new-product-category', [ProductCategoriesController::class, 'updateProductCategory'])->name('categories.updateproductcategory');
                Route::post('/{cat_id}/delete-product-category', [ProductCategoriesController::class, 'deleteProductCategory'])->name('categories.deleteproductcategory');
            });

            Route::group(['prefix' => 'departments', 'middleware' => 'role:admin'], function () {
                Route::get('/', [DepartmentsController::class, 'index'])->name('index.departments');
                Route::get('/fetch-departments', [DepartmentsController::class, 'fetchdepartmentAll'])->name('department.fetchdepartment');
                Route::get('/get-departments', [DepartmentsController::class, 'getdepartmentAll'])->name('department.getdepartment');
                Route::get('/get-department-head', [DepartmentsController::class, 'getdepartmenthead'])->name('department.getdepartmenthead');
                Route::post('/add-new-hod', [DepartmentsController::class, 'addhodInformation'])->name('department.addhodinformation');
                Route::post('/add-new-department', [DepartmentsController::class, 'addnewdepartmentInformation'])->name('department.addnewdepartment');
                Route::post('/update-hod', [DepartmentsController::class, 'updatehodInformation'])->name('department.updatehodinformation');
                Route::post('/{dep_id}/update-department', [DepartmentsController::class, 'updatedepartmentInformation'])->name('department.updatedepartment');
                Route::post('/{dep_id}/update-department-head', [DepartmentsController::class, 'updatedepartmentHead'])->name('department.updatedepartmenthead');
            });

            Route::group(['prefix' => 'system', 'middleware' => 'role:admin'], function () {
                Route::get('/', [SystemController::class, 'index'])->name('index.system');
                Route::get('/get-informations', [SystemController::class, 'systemInformation'])->name('system.information');
                Route::post('/update-informations', [SystemController::class, 'systemUpdateInformation'])->name('system.updateinformation');
                Route::post('/update-logo', [SystemController::class, 'systemUpdateLogo'])->name('system.updatelogo');
                Route::post('/update-letterhead', [SystemController::class, 'systemUpdateLetterhead'])->name('system.updateletterhead');
            });

            Route::group(['prefix' => 'users', 'middleware' => 'role:admin'], function () {
                Route::get('/', [SettingUsersController::class, 'index'])->name('index.users');
                Route::get('/fetch-users', [SettingUsersController::class, 'fetchuserAll'])->name('users.fetchusers');
                Route::post('/{user_id}/users-active', [SettingUsersController::class, 'userActive'])->name('users.userActive');
                Route::post('/users-log-status', [SettingUsersController::class, 'userLogStatus'])->name('users.userLogStatus');
                Route::get('/create', [SettingUsersController::class, 'userCreate'])->name('users.create');
                Route::post('/save', [SettingUsersController::class, 'userSave'])->name('users.save');
                Route::get('/user-open-form', [SettingUsersController::class, 'userOpenForm'])->name('users.form');
                Route::get('/{user_id}/delete', [SettingUsersController::class, 'userDelete'])->name('users.delete');
                Route::get('/{user_id}/edit', [SettingUsersController::class, 'userEdit'])->name('users.edit');
                Route::post('/{user_id}/update', [SettingUsersController::class, 'userUpdate'])->name('users.update');
                Route::post('/saveRecord', [SettingUsersController::class, 'saveRecord'])->name('users.saveRecord');
                Route::get('/system-users-pdf', [SettingUsersController::class, 'generatePDF'])->name('system.users.pdf');
                Route::get('/export-system-users', [SettingUsersController::class, 'generateExcel'])->name('system.users.excel');

                Route::group(['prefix' => 'privilege', 'middleware' => 'role:admin'], function () {
                    Route::get('/', [SettingUsersController::class, 'indexPrivilege'])->name('index.privilege');
                    Route::get('/{user_id}/user-privilege', [SettingUsersController::class, 'userPrivilege'])->name('users.privilege');
                    Route::post('/user-privilege', [SettingUsersController::class, 'userBulkPrivilege'])->name('users.bulkprivilege');
                    Route::post('/user-privilege-save', [SettingUsersController::class, 'userPrivilegeSave'])->name('privileges.save');
                    Route::post('/user-privilege-remove', [SettingUsersController::class, 'userPrivilegeRemove'])->name('privileges.remove');
                    Route::post('/user-privilege-delete', [SettingUsersController::class, 'userPrivilegeDelete'])->name('privileges.delete');
                    Route::post('/user-import-privilege', [SettingUsersController::class, 'userImportPrivilege'])->name('privileges.import');
                });
            });
        });

        Route::group(['prefix' => 'profile'], function () {
            Route::get('/{page_id}/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
            Route::post('/{page_id}/update', [UserProfileController::class, 'update'])->name('profile.update');
        });

        Route::group(['prefix' => 'extensions', 'middleware' => 'role:admin'], function () {
            Route::get('/{page_id}/edit', [ExtensionsController::class, 'edit'])->name('extensions.edit');
            Route::post('/{page_id}/update', [ExtensionsController::class, 'update'])->name('extensions.update');
        });
      });

    });
});
