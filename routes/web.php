<?php
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CountryStateCityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResearcherController;
use App\Http\Controllers\ResearcherReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserSmtpController;
use App\Http\Controllers\UserImapController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\MassEmail\AnniversaryController;
use App\Http\Controllers\MassEmail\MailCampaignController;
use App\Http\Controllers\MassEmail\MailTemplateController;
use App\Http\Controllers\MassEmail\ViewEmailController;
use App\Http\Controllers\WhatsappMessage\TemplateController;
use App\Http\Controllers\WhatsApp\CampaignController;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('admin/dashboard');
    }
    return redirect('login');
});

Route::get('/login', function () {
    if (auth()->check()) {
        return redirect('admin/dashboard');
    }
    return view('admin.auth.login');
})->name('login');

Route::get('forgot-password', [AuthCOntroller::class, 'forgotPasswordForm'])->name('forgot-password');
Route::post('/submit/forget-password', [AuthCOntroller::class, 'submitForgetPasswordForm'])->name('submit.forget.password');
Route::get('/reset-password/{token}', [AuthCOntroller::class, 'resetPasswordForm'])->name('reset.password');
Route::post('/submit/reset-password', [AuthCOntroller::class, 'submitResetPasswordForm'])->name('submit.reset.password');

Route::prefix('admin')->group(function () {
    Route::post('login-submit', [AuthController::class, 'login'])->name('admin.login.submit');

    // Route::get('forgot-password', function () {
    //     return view('admin.auth.forgot-password');
    // })->name('admin.forgot-password');

});

/*
|--------------------------------------------------------------------------
| Protected Admin Routes (require auth)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'prevent-back-history', 'set-user-mail-config'])->group(function () {
    Route::any('logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('check-status', [AuthController::class, 'checkStatus'])->name('admin.check.status');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Route::get('preview', function () {
    //     return view('admin.preview.index');
    // });

    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('/update_profile', [ProfileController::class, 'updateProfile'])->name('admin.update.profile');
    Route::post('/update_password', [ProfileController::class, 'updatePassword'])->name('admin.update.password');
    Route::post('/profile/update-image', [ProfileController::class, 'updateImage'])->name('admin.profile.update-image');

    /*
    |--------------------------------------------------------------------------
    | Agent Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('agents')->as('admin.agents.')->group(function () {
        Route::get('/', [AgentController::class, 'index'])->name('list');
        Route::post('/store', [AgentController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AgentController::class, 'edit'])->name('edit');
        Route::post('/update', [AgentController::class, 'update'])->name('update');
        Route::get('/view/{id}', [AgentController::class, 'show'])->name('view');
        Route::delete('/delete/{id}', [AgentController::class, 'destory'])->name('delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Role permission Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('roles')->as('admin.roles.')->group(function () {
        Route::resource('/', RoleController::class);
        Route::put('/{id}', [RoleController::class, 'update']);
        Route::delete('/{id}', [RoleController::class, 'destroy']);
        Route::get('permission/{id}', [RoleController::class, 'permissions'])->name('admin.permission');
        Route::post('assign-permissions', [RoleController::class, 'assignPermissions'])->name('roles.assignPermissions');

    });

    /*
    |--------------------------------------------------------------------------
    | Lead Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('leads')->as('admin.leads.')->group(function () {
        Route::get('/', [LeadController::class, 'index'])->name('list');
        Route::get('/datatable', [LeadController::class, 'getLeadsData'])->name('datatable');

        Route::get('/create', [LeadController::class, 'create'])->name('create');
        Route::post('/store', [LeadController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [LeadController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [LeadController::class, 'update'])->name('update');
        Route::get('/view/{id}', [LeadController::class, 'show'])->name('view');
        Route::post('/status', [LeadController::class, 'updateStatus'])->name('status');
        Route::delete('/delete/{id}', [LeadController::class, 'destroy'])->name('delete');
        Route::get('{lead_id}/attachment', [LeadController::class, 'attachment'])->name('attachment');
        Route::delete('/attachment/delete/{id}', [LeadController::class, 'deleteAttachment'])->name('attachment.delete');
        Route::post('/convert-to-client', [LeadController::class, 'convertToClient'])->name('convert.client');
        Route::get('/download-pdf/{id}', [LeadController::class, 'downloadPdf'])->name('download-pdf');

        // AJAX routes for notes
        Route::post('/{lead_id}/notes', [LeadController::class, 'storeNote'])->name('notes.store');
        Route::put('/notes/{note_id}', [LeadController::class, 'updateNote'])->name('notes.update');
        Route::delete('/notes/{note_id}', [LeadController::class, 'deleteNote'])->name('notes.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Client Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('clients')->as('admin.clients.')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('list');
        Route::get('/datatable', [ClientController::class, 'getClientsData'])->name('datatable');
        Route::get('/create', [ClientController::class, 'create'])->name('create');
        Route::post('/store', [ClientController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ClientController::class, 'update'])->name('update');
        Route::get('/view/{id}', [ClientController::class, 'show'])->name('view');
        Route::delete('/delete/{id}', [ClientController::class, 'destory'])->name('delete');
        Route::get('{lead_id}/attachment', [ClientController::class, 'attachment'])->name('attachment');
        Route::Delete('/attachment/delete/{id}', [ClientController::class, 'deleteAttachment'])->name('attachment.delete');
        Route::post('/assing-researcher', [ClientController::class, 'assignResearcher'])->name('assign.researcher');
        Route::post('/generate-bill', [BillController::class, 'generate'])->name('generate-bill');
        Route::get('/download-pdf/{id}', [ClientController::class, 'downloadPdf'])->name('download-pdf');
        Route::get('/{id}/create-bill', [ClientController::class, 'createBillForClient'])->name('create-bill');

    });

    /*
    |--------------------------------------------------------------------------
    | Researcher Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('researcher')->as('admin.researcher.')->group(function () {
        Route::get('/', [ResearcherController::class, 'index'])->name('list');
        Route::get('/view/{id}', [ResearcherController::class, 'show'])->name('view');
        Route::post('/store', [ResearcherController::class, 'store'])->name('store');
        Route::post('/store-view', [ResearcherController::class, 'storeView'])->name('store.view');
        Route::get('/create-report/{id}', [ResearcherController::class, 'createReport'])->name('create.report');
        Route::delete('/delete/{id}', [ResearcherController::class, 'destroy'])->name('delete');
        Route::post('/status', [ResearcherController::class, 'updateStatus'])->name('status');


        // AJAX routes for researcher notes
        Route::post('/{client_id}/notes', [ResearcherController::class, 'storeNote'])->name('notes.store');
        Route::put('/notes/{note_id}', [ResearcherController::class, 'updateNote'])->name('notes.update');
        Route::delete('/notes/{note_id}', [ResearcherController::class, 'deleteNote'])->name('notes.delete');
    });
    Route::prefix('research-reports')->as('research-reports.')->group(function () {
        Route::get('/', [ResearcherReportController::class, 'index'])->name('list');
        Route::get('/archives', [ResearcherReportController::class, 'archives'])->name('archives');
        Route::get('/view/{id}', [ResearcherReportController::class, 'show'])->name('view');
        Route::delete('/delete/{id}', [ResearcherReportController::class, 'destroy'])->name('delete');
        Route::get('/{id}/restore', [ResearcherReportController::class, 'restore'])->name('restore');
        Route::post('/store', [ResearcherReportController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ResearcherReportController::class, 'edit'])->name('edit');

        Route::get('pdf1/{id}', [ResearcherReportController::class, 'pdf1'])->name('pdf1');
    });

    /*
    |--------------------------------------------------------------------------
    | Project Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('projects')->as('admin.projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('list');
        Route::post('/store', [ProjectController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('edit');
        Route::get('/view/{id}', [ProjectController::class, 'view'])->name('view');
        Route::post('/update', [ProjectController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ProjectController::class, 'destory'])->name('delete');

        // Subproject Routes
        Route::prefix('subproject')->as('subproject.')->group(function () {
            Route::post('/store', [ProjectController::class, 'subStore'])->name('store');
            Route::get('/edit/{id}', [ProjectController::class, 'subEdit'])->name('edit');
            Route::post('/update', [ProjectController::class, 'subUpdate'])->name('update');
            Route::delete('/delete/{id}', [ProjectController::class, 'subDestory'])->name('delete');
        });
    });
    Route::get('/get-subprojects/{project}', [ProjectController::class, 'getSubprojects']);

    /*
    |--------------------------------------------------------------------------
    | Bills Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('bills')->as('admin.bills.')->group(function () {
          Route::get('/create', [BillController::class, 'create'])->name('create');          
        Route::post('/store', [BillController::class, 'store'])->name('store');
        Route::get('/', [BillController::class, 'index'])->name('list');
        Route::get('/edit/{id}', [BillController::class, 'edit'])->name('edit');
        Route::post('/update', [BillController::class, 'update'])->name('update');
       
        Route::delete('/delete/{id}', [BillController::class, 'destroy'])->name('delete');
        Route::get('/get-client-by-kulvriksh', [BillController::class, 'getClientByKulvrikshId'])->name('get.client.kulvriksh');
        Route::get('/get-client-by-phone', [BillController::class, 'getClientByPhone'])->name('get.client.phone');
        Route::get('/search-kulvriksh', [BillController::class, 'searchKulvriksh'])->name('search.kulvriksh');
        Route::get('/get-client-by-email', [BillController::class, 'getClientByEmail'])->name('get.client.email');
        Route::get('/{id}', [BillController::class, 'show'])->name('view');
 

    });


    /*
    |--------------------------------------------------------------------------
    | Expense Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('expenses')->as('admin.expenses.')->group(function () {
        Route::get('/', [ExpenseController::class, 'index'])->name('list');
        Route::post('/store', [ExpenseController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ExpenseController::class, 'edit'])->name('edit');
        Route::get('/view/{id}', [ExpenseController::class, 'view'])->name('view');
        Route::post('/update', [ExpenseController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ExpenseController::class, 'destroy'])->name('delete');

        // Category Routes
        Route::prefix('category')->as('category.')->group(function () {
            Route::get('/', [ExpenseController::class, 'catIndex'])->name('list');
            Route::post('/store', [ExpenseController::class, 'catStore'])->name('store');
            Route::get('/edit/{id}', [ExpenseController::class, 'catEdit'])->name('edit');
            Route::post('/update', [ExpenseController::class, 'catUpdate'])->name('update');
            Route::delete('/delete/{id}', [ExpenseController::class, 'catDestory'])->name('delete');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Report Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('reports')->as('admin.reports.')->group(function () {
        Route::get('/income-expense', [ReportController::class, 'incomeExpense']);
        Route::get('/lead', [ReportController::class, 'lead']);
        Route::get('/lead/datatable', [ReportController::class, 'getLeadReportData'])->name('lead.datatable');
        Route::get('/client', [ReportController::class, 'client']);
        Route::get('/client/datatable', [ReportController::class, 'getClientReportData'])->name('client.datatable');
        Route::get('/researcher', [ReportController::class, 'researcher']);
    });

    /*
    |--------------------------------------------------------------------------
    | whatsapp message Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('whatsapp')->as('admin.whatsapp.')->group(function () {

        Route::get('api_settings', [\App\Http\Controllers\WhatsApp\SettingController::class, 'index'])->name('list');
        Route::post('/store', [\App\Http\Controllers\WhatsApp\SettingController::class, 'store'])->name('store');
            
        // template Routes
        Route::prefix('template')->as('template.')->group(function () {
            Route::get('/', [\App\Http\Controllers\WhatsappMessage\TemplateController::class, 'index'])->name('list');
            Route::get('/add', [\App\Http\Controllers\WhatsappMessage\TemplateController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\WhatsappMessage\TemplateController::class, 'store'])->name('store');
            Route::get('/view/{id}', [\App\Http\Controllers\WhatsappMessage\TemplateController::class, 'show'])->name('view');
            Route::get('/edit/{id}', [\App\Http\Controllers\WhatsappMessage\TemplateController::class, 'edit'])->name('edit');
            Route::post('/update', [\App\Http\Controllers\WhatsappMessage\TemplateController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [\App\Http\Controllers\WhatsappMessage\TemplateController::class, 'destory'])->name('delete');
        });

        Route::prefix('campaign')->as('campaign.')->group(function () {
            Route::get('/', [\App\Http\Controllers\WhatsApp\CampaignController::class, 'index'])->name('list');
            Route::post('/store', [\App\Http\Controllers\WhatsApp\CampaignController::class, 'store'])->name('store');
            Route::get('/view/{id}', [\App\Http\Controllers\WhatsApp\CampaignController::class, 'show'])->name('view');
            Route::get('/edit/{id}', [\App\Http\Controllers\WhatsApp\CampaignController::class, 'edit'])->name('edit');
            Route::post('/update', [\App\Http\Controllers\WhatsApp\CampaignController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [\App\Http\Controllers\WhatsApp\CampaignController::class, 'destroy'])->name('delete');
        });

        Route::get('/advertisements', [CampaignController::class, 'advertisement'])->name('advertisements');
        Route::post('/advertisements/send', [CampaignController::class, 'sendAdvertisement'])->name('advertisements.send');

        // Birthday Routes
        Route::prefix('birthday')->as('birthday.')->group(function () {
            Route::get('/today', [\App\Http\Controllers\WhatsApp\AnniversaryController::class, 'todayBirthdays'])->name('today');
            Route::get('/all', [\App\Http\Controllers\WhatsApp\AnniversaryController::class, 'allBirthdays'])->name('all');
        });

        // Marriage Anniversary Routes
        Route::prefix('marriage')->as('marriage.')->group(function () {
            Route::get('/today', [\App\Http\Controllers\WhatsApp\AnniversaryController::class, 'todayMarriageAnniversaries'])->name('today');
            Route::get('/all', [\App\Http\Controllers\WhatsApp\AnniversaryController::class, 'allMarriageAnniversaries'])->name('all');
        });

        // Death Anniversary Routes
        Route::prefix('death')->as('death.')->group(function () {
            Route::get('/today', [\App\Http\Controllers\WhatsApp\AnniversaryController::class, 'todayDeathAnniversaries'])->name('today');
            Route::get('/all', [\App\Http\Controllers\WhatsApp\AnniversaryController::class, 'allDeathAnniversaries'])->name('all');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | mass email Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('mass-email')->as('admin.mass-email.')->group(function () {
        // template Routes
        Route::prefix('template')->as('template.')->group(function () {
            Route::get('/', [MailTemplateController::class, 'index'])->name('list');
            Route::get('/add', [MailTemplateController::class, 'create'])->name('create');
            Route::post('/store', [MailTemplateController::class, 'store'])->name('store');
            Route::get('/view/{id}', [MailTemplateController::class, 'show'])->name('view');
            Route::get('/edit/{id}', [MailTemplateController::class, 'edit'])->name('edit');
            Route::post('/update', [MailTemplateController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [MailTemplateController::class, 'destory'])->name('delete');
        });

        Route::prefix('campaign')->as('campaign.')->group(function () {
            Route::get('/', [MailCampaignController::class, 'index'])->name('list');
            Route::post('/store', [MailCampaignController::class, 'store'])->name('store');
            Route::get('/view/{id}', [MailCampaignController::class, 'show'])->name('view');
            Route::get('/edit/{id}', [MailCampaignController::class, 'edit'])->name('edit');
            Route::post('/update', [MailCampaignController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [MailCampaignController::class, 'destroy'])->name('delete');
        });

        Route::get('/advertisements', [MailCampaignController::class, 'advertisement'])->name('advertisements');
        Route::post('/advertisements/send', [MailCampaignController::class, 'sendAdvertisement'])->name('advertisements.send');
        
        // Birthday Routes
        Route::prefix('birthday')->as('birthday.')->group(function () {
            Route::get('/today', [AnniversaryController::class, 'todayBirthdays'])->name('today');
            Route::get('/all', [AnniversaryController::class, 'allBirthdays'])->name('all');
        });

        // Marriage Anniversary Routes
        Route::prefix('marriage')->as('marriage.')->group(function () {
            Route::get('/today', [AnniversaryController::class, 'todayMarriageAnniversaries'])->name('today');
            Route::get('/all', [AnniversaryController::class, 'allMarriageAnniversaries'])->name('all');
        });

        // Death Anniversary Routes
        Route::prefix('death')->as('death.')->group(function () {
            Route::get('/today', [AnniversaryController::class, 'todayDeathAnniversaries'])->name('today');
            Route::get('/all', [AnniversaryController::class, 'allDeathAnniversaries'])->name('all');
        });

         Route::prefix('view-email')->as('view-email.')->group(function () {
             Route::get('/', [ViewEmailController::class, 'index'])->name('index');
            // Route::get('/emails', [ViewEmailController::class, 'getEmails'])->name('emails');
             Route::get('/counts', [ViewEmailController::class, 'getEmailCounts'])->name('counts');
             Route::post('/refresh', [ViewEmailController::class, 'refreshEmails'])->name('refresh'); // front side when some one click on refresh buton at that time call below function method.
             // Route::post('/test-fetch', [ViewEmailController::class, 'testEmailFetch'])->name('test-fetch');
             Route::post('/mark-read', [ViewEmailController::class, 'markAsRead'])->name('mark-read');
             Route::post('/toggle-star', [ViewEmailController::class, 'toggleStar'])->name('toggle-star');
             Route::post('/delete', [ViewEmailController::class, 'deleteMessages'])->name('delete');
             Route::get('/details', [ViewEmailController::class, 'getEmailDetails'])->name('details');
             Route::get('/show/{id}', [ViewEmailController::class, 'show'])->name('show');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Bank Account, smtp setup Settings
    |--------------------------------------------------------------------------
    */
    Route::prefix('settings')->as('admin.settings.')->group(function () {
        Route::resource('accounts', BankAccountController::class);
        // Route::resource('accounts', BankAccountController::class);
        Route::get('/smtp', [SettingController::class, 'index']);
        Route::post('/smtp/update', [SettingController::class, 'update']);

        // User SMTP Settings
        Route::prefix('my-smtp')->as('my-smtp.')->group(function () {
            Route::get('/', [UserSmtpController::class, 'index'])->name('index');
            Route::post('/store', [UserSmtpController::class, 'store'])->name('store');
            Route::post('/test', [UserSmtpController::class, 'test'])->name('test');
            Route::post('/toggle', [UserSmtpController::class, 'toggle'])->name('toggle');
            Route::get('/delete', [UserSmtpController::class, 'delete'])->name('delete');
        });

        // Import/Export Settings
        Route::prefix('import')->as('import.')->group(function () {
            Route::get('/', [ImportController::class, 'index'])->name('index');
            Route::post('/upload', [ImportController::class, 'import'])->name('upload');
            Route::get('/template/{type}', [ImportController::class, 'downloadTemplate'])->name('template');
            
            // Legacy export routes (kept for backward compatibility)
            Route::get('/export-countries', [ImportController::class, 'exportCountries'])->name('export.countries');
            Route::get('/export-states', [ImportController::class, 'exportStates'])->name('export.states');
            Route::get('/export-cities', [ImportController::class, 'exportCities'])->name('export.cities');
            Route::get('/export-districts', [ImportController::class, 'exportDistricts'])->name('export.districts');
            Route::get('/export-talukas', [ImportController::class, 'exportTalukas'])->name('export.talukas');
            Route::get('/export-villages', [ImportController::class, 'exportVillages'])->name('export.villages');
            
            // Common export with filters
            Route::post('/export-data', [ExportController::class, 'export'])->name('export.data');
            Route::get('/export-states-ajax', [ExportController::class, 'getStates'])->name('export.states.ajax');
            Route::get('/export-cities-ajax', [ExportController::class, 'getCities'])->name('export.cities.ajax');
            Route::get('/export-talukas-ajax', [ExportController::class, 'getTalukas'])->name('export.talukas.ajax');
        });

        // User IMAP Settings
        Route::prefix('my-imap')->as('my-imap.')->group(function () {
            Route::get('/', [UserImapController::class, 'index'])->name('index');
            Route::post('/store', [UserImapController::class, 'store'])->name('store');
            Route::post('/test', [UserImapController::class, 'test'])->name('test');
            Route::post('/toggle', [UserImapController::class, 'toggle'])->name('toggle');
            Route::post('/delete', [UserImapController::class, 'delete'])->name('delete');
            Route::post('/fetch-emails', [UserImapController::class, 'fetchEmails'])->name('fetch-emails');
            Route::get('/get-emails', [UserImapController::class, 'getEmails'])->name('get-emails');
            Route::post('/mark-read', [UserImapController::class, 'markAsRead'])->name('mark-read');
            Route::post('/toggle-star', [UserImapController::class, 'toggleStar'])->name('toggle-star');
            Route::post('/delete-message', [UserImapController::class, 'deleteMessage'])->name('delete-message');
            Route::get('/get-folders', [UserImapController::class, 'getFolders'])->name('get-folders');
            Route::get('/test-connection-folders', [UserImapController::class, 'testConnectionAndFolders'])->name('test-connection-folders');
        });

        // Route::get('users/{id}', [UserController::class, 'index'])->name('user.index');

        Route::get('address',[SettingController::class, 'address']);

        Route::prefix('countries')->as('countries.')->group(function(){
             Route::get('/datatable', [CountryStateCityController::class, 'getCountryData'])->name('datatable');
             Route::post('store',[CountryStateCityController::class, 'countryStore'])->name('store');
             Route::put('update/{id}',[CountryStateCityController::class, 'countryUpdate'])->name('update');
             Route::delete('delete/{id}',[CountryStateCityController::class, 'countryDelete'])->name('delete');
        });

        Route::prefix('states')->as('states.')->group(function(){
             Route::get('/datatable', [CountryStateCityController::class, 'getStateData'])->name('datatable');
             Route::post('store',[CountryStateCityController::class, 'stateStore'])->name('store');
             Route::put('update/{id}',[CountryStateCityController::class, 'stateUpdate'])->name('update');
             Route::delete('delete/{id}',[CountryStateCityController::class, 'stateDelete'])->name('delete');
        });

        Route::prefix('districts')->as('districts.')->group(function(){
             Route::get('/datatable', [CountryStateCityController::class, 'getDistrictData'])->name('datatable');
             Route::post('store',[CountryStateCityController::class, 'districtStore'])->name('store');
             Route::put('update/{id}',[CountryStateCityController::class, 'districtUpdate'])->name('update');
             Route::delete('delete/{id}',[CountryStateCityController::class, 'districtDelete'])->name('delete');
        });

        Route::prefix('cities')->as('cities.')->group(function(){
             Route::get('/datatable', [CountryStateCityController::class, 'getCityData'])->name('datatable');
             Route::post('store',[CountryStateCityController::class, 'cityStore'])->name('store');
             Route::put('update/{id}',[CountryStateCityController::class, 'cityUpdate'])->name('update');
             Route::delete('delete/{id}',[CountryStateCityController::class, 'cityDelete'])->name('delete');
        });

        Route::prefix('talukas')->as('talukas.')->group(function(){
             Route::get('/datatable', [CountryStateCityController::class, 'getTalukaData'])->name('datatable');
             Route::post('store',[CountryStateCityController::class, 'talukaStore'])->name('store');
             Route::put('update/{id}',[CountryStateCityController::class, 'talukaUpdate'])->name('update');
             Route::delete('delete/{id}',[CountryStateCityController::class, 'talukaDelete'])->name('delete');
        });

        Route::prefix('villages')->as('villages.')->group(function(){
             Route::get('/datatable', [CountryStateCityController::class, 'getVillageData'])->name('datatable');
             Route::post('store',[CountryStateCityController::class, 'villageStore'])->name('store');
             Route::put('update/{id}',[CountryStateCityController::class, 'villageUpdate'])->name('update');
             Route::delete('delete/{id}',[CountryStateCityController::class, 'villageDelete'])->name('delete');
        });

        // AJAX routes for dropdowns
        Route::get('/get-state/{country_id}', [CountryStateCityController::class, 'getState']);
        Route::get('/get-cities/{state_id}', [CountryStateCityController::class, 'getCities']);
        Route::get('/get-district/{state_id}', [CountryStateCityController::class, 'getDistrict']);
        Route::get('/get-talukas/{city_id}', [CountryStateCityController::class, 'getTaluka']);
        Route::get('/get-villages/{taluka_id}', [CountryStateCityController::class, 'getVillages']);
        Route::get('/get-phone-code/{country_id}', [CountryStateCityController::class, 'getPhoneCode']);

    });



    // routes/web.php
    Route::prefix('logs')->name('admin.logs.')->middleware('auth')->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
        Route::get('/export', [ActivityLogController::class, 'export'])->name('export');
        Route::post('/clear', [ActivityLogController::class, 'clear'])->name('clear');
        Route::delete('/delete/{id}', [ActivityLogController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [ActivityLogController::class, 'show'])->name('view');
    });



    Route::post('campaign/create', [\App\Http\Controllers\MassEmail\MailCampaignController::class, 'ajaxCreate'])->name('admin.campaign.create');

    // Activity Logs Rout

});