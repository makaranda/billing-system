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
    Route::group(['middleware' => ['admin.auth','check.status']], function () {
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
            Route::get('/customers', [CusCustomersController::class, 'index'])->name('index.cuscustomers');
            Route::get('/add-customer-groups', [CusAddCustomerGroupsController::class, 'index'])->name('index.cusaddcustomergroups');
            Route::get('/attachements', [CusAttachementsController::class, 'index'])->name('index.cusattachements');
            Route::get('/debtors', [CusDebtorsController::class, 'index'])->name('index.cusdebtors');
            Route::get('/customer-receipts', [CusCustomerReceiptsController::class, 'index'])->name('index.cuscustomerreceipts');
            Route::get('/creditnotes', [CusCreditNotesController::class, 'index'])->name('index.cuscreditnotes');
            Route::get('/allocate-customer-receipt', [CusAllocateCustomerReceiptController::class, 'index'])->name('index.cusallocatecustomerreceipt');
            Route::get('/corrections', [CusCorrectionsController::class, 'index'])->name('index.cuscorrections');
            Route::get('/debt-management', [CusDebtManagementController::class, 'index'])->name('index.cusdebtmanagement');
            Route::get('/vas', [CusVasController::class, 'index'])->name('index.cusvas');
            Route::get('/wht-cetificates', [CusWhtCetificatesController::class, 'index'])->name('index.cuswhtcetificates');
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
            Route::get('/nominal-categories', [NominalCategoriesController::class, 'index'])->name('index.nominalcategories');
            Route::get('/nominal-subcategories', [NominalSubCategoriesController::class, 'index'])->name('index.nominalsubcategories');
            Route::get('/nominal-accounts', [NominalAccountsController::class, 'index'])->name('index.nominalaccounts');
            Route::get('/banks', [BanksController::class, 'index'])->name('index.banks');
            Route::get('/bank-accounts', [BankAccountsController::class, 'index'])->name('index.bankaccounts');
            Route::get('/bank-transfer', [BankTransferController::class, 'index'])->name('index.banktransfer');
            Route::get('/bank-reconciliations', [BankReconciliationsController::class, 'index'])->name('index.bankreconciliations');
            Route::get('/bank-deposit-types', [BankdePosittypesController::class, 'index'])->name('index.bankdeposittypes');
        });

        Route::group(['prefix' => 'settings', 'middleware' => 'role:admin'], function () {
            Route::get('/', [SettingsController::class, 'index'])->name('index.settings');
            Route::get('/system', [SystemController::class, 'index'])->name('index.system');
            Route::get('/departments', [DepartmentsController::class, 'index'])->name('index.departments');
            Route::get('/ota-operators', [OtaOperatorsController::class, 'index'])->name('index.otaoperators');
            Route::get('/credit-card-types', [CreditCardTypesController::class, 'index'])->name('index.creditcardtypes');
            Route::get('/product-categories', [ProductCategoriesController::class, 'index'])->name('index.productcategories');
            Route::get('/products', [ProductsController::class, 'index'])->name('index.products');
            Route::get('/tax', [TaxController::class, 'index'])->name('index.tax');
            Route::get('/default-payment-banks', [DefaultPaymentBanksController::class, 'index'])->name('index.defaultpaymentbanks');
            Route::get('/currency-exchange-settings', [CurrencyExchangeSettingsController::class, 'index'])->name('index.currencyexchangesettings');
            Route::get('/message-formats', [MessageFormatsController::class, 'index'])->name('index.messageformats');
            Route::get('/currencies', [CurrenciesController::class, 'index'])->name('index.currencies');
            Route::get('/price-types', [PriceTypesController::class, 'index'])->name('index.pricetypes');

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
                });
            });

            Route::get('/collection-bureaus', [CollectionBureausController::class, 'index'])->name('index.collectionbureaus');
            Route::get('/territories', [TerritoriesController::class, 'index'])->name('index.territories');
            Route::get('/set-employee-ot-factor', [SetEmployeeOtFactorController::class, 'index'])->name('index.setemployeeotfactor');
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
