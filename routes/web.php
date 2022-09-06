<?php

use App\Http\Controllers\FoodCollectionController;
use App\Http\Controllers\JobcardsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Public routes files
Route::group(['middleware' => ['web', 'activity']], function () {

    // unauthorised
    Route::get('/unauthorized', 'App\Http\Controllers\HomeController@unauthorized');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/create-user-request', 'App\Http\Controllers\UserController@createRequest');
});

// admin routes
Route::group(['middleware' => ['web', 'activity', 'activated', 'auth']], function () {

    // job titles
    Route::resource('jobtitles', 'App\Http\Controllers\JobtitlesController');

    // usertypes
    Route::resource('usertypes', 'App\Http\Controllers\UsertypesController');

    // humber settings
    Route::get('/hsettings-get', 'App\Http\Controllers\HumberSettingsController@getSettings');
    Route::put('/hsettings-post/{id}', 'App\Http\Controllers\HumberSettingsController@updateSettings')->name('hsettings');
});

Route::group(['prefix' => 'activity', 'namespace' => 'jeremykenedy\LaravelLogger\App\Http\Controllers', 'middleware' => ['web', 'auth', 'activity', 'admin']], function () {

    // Activity
    Route::get('/', 'LaravelLoggerController@showAccessLog')->name('activity');
    Route::get('/cleared', ['uses' => 'LaravelLoggerController@showClearedActivityLog'])->name('cleared');

    // Drill Downs
    Route::get('/log/{id}', 'LaravelLoggerController@showAccessLogEntry');
    Route::get('/cleared/log/{id}', 'LaravelLoggerController@showClearedAccessLogEntry');

    // Forms
    Route::delete('/clear-activity', ['uses' => 'LaravelLoggerController@clearActivityLog'])->name('clear-activity');
    Route::delete('/destroy-activity', ['uses' => 'LaravelLoggerController@destroyActivityLog'])->name('destroy-activity');
    Route::post('/restore-log', ['uses' => 'LaravelLoggerController@restoreClearedActivityLog'])->name('restore-activity');
});


Route::get('email-approve/{id}/{approver}', 'App\Http\Controllers\FoodRequestController@emailApprove')->middleware('manageradmin');
Route::get('delete_unattended_requests', 'App\Http\Controllers\HumberSettingsController@deleteRequests')->middleware('manageradmin');
Route::get('delete_pending_requests', 'App\Http\Controllers\HumberSettingsController@deleteRequestsPending')->middleware('manageradmin');
Route::delete('user_collection/{id}', 'App\Http\Controllers\FoodCollectionController@deleteUserCollection')->name('benef.destroy')->middleware('admin');

Route::group(['middleware' => ['auth', 'activated', 'web', 'activity']], function () {

    // departments
    Route::resource('departments', 'App\Http\Controllers\DepartmentsController');
    Route::post('department-import-send', 'App\Http\Controllers\DepartmentsController@departmentImportSend');
    Route::get('/department-download', 'App\Http\Controllers\DepartmentsController@downloadDepartmentForm');
    Route::get('get-department-import', 'App\Http\Controllers\DepartmentsController@importDepartments');
    Route::get('assign-manager', 'App\Http\Controllers\DepartmentsController@assignManager');
    Route::get('get-user-department/{paynumber}', 'App\Http\Controllers\DepartmentsController@getDepartment');
    Route::post('assign-manager-post', 'App\Http\Controllers\DepartmentsController@assignManagerPost');
});

Route::group(['middleware' => ['auth', 'activated', 'web', 'activity']], function () {

    // users
    Route::resource('users', 'App\Http\Controllers\UsersManagementController');
});

Route::group(['middleware' => ['auth', 'activated', 'web', 'activity', 'manageradmin']], function () {

    // users
    Route::post('users-import-send', 'App\Http\Controllers\UsersManagementController@usersImportSend');
    Route::get('/users-download', 'App\Http\Controllers\UsersManagementController@downloadUsersForm');
    Route::get('get-users-import', 'App\Http\Controllers\UsersManagementController@importUsers');
    Route::resource('deleted-users', 'App\Http\Controllers\SoftDeleteUsersController');
    Route::get('deactivate-user/{id}', 'App\Http\Controllers\UsersManagementController@deActivateUser');
    Route::get('terminate-user-form', 'App\Http\Controllers\UsersManagementController@terminateForm');
    Route::get('reset-pin', 'App\Http\Controllers\UsersManagementController@resetPinForm');
    Route::post('reset-post', 'App\Http\Controllers\UsersManagementController@resetPinPost');
    Route::post('terminate-post', 'App\Http\Controllers\UsersManagementController@terminatePost');

    // beneficiaries
    Route::resource('beneficiaries', 'App\Http\Controllers\BeneficiariesController');

    // assign beneficiaries
    Route::get('assign-beneficiary', 'App\Http\Controllers\BeneficiariesController@assignBeneficiary');
    Route::get('get-beneficiary-id/{beneficiary}', 'App\Http\Controllers\BeneficiariesController@getIdNumber');
    Route::post('assign-beneficiary-post', 'App\Http\Controllers\BeneficiariesController@assignBeneficiaryPost');

    Route::get('import-beneficiary', 'App\Http\Controllers\BeneficiariesController@getImport');
    Route::post('/beneficiary-import-send', 'App\Http\Controllers\BeneficiariesController@postImport');

    Route::get('/all-employee-beneficiaries', 'App\Http\Controllers\BeneficiariesController@allEmployeeAndBeneficiaries');
});

Route::group(['middleware' => ['auth', 'activated', 'web', 'activity', 'manageradmin']], function () {

    // allocations
    Route::resource('allocations', 'App\Http\Controllers\AllocationsController');
    Route::get('import-allocation', 'App\Http\Controllers\AllocationsController@allocationImportForm');
    Route::post('allocation-import-send', 'App\Http\Controllers\AllocationsController@allocationImportSend');
    Route::get('all-alloctions', 'App\Http\Controllers\AllocationsController@allAllocations');
    Route::get('/department-users/{department}', 'App\Http\Controllers\AllocationsController@getDepartmentalUsers');
    Route::resource('deleted-allocations', 'App\Http\Controllers\SoftDeleteAllocationsController');
    Route::get('/get-allocation/{paynumber}', 'App\Http\Controllers\AllocationsController@getAllocation');
    Route::get('/allocation-download', 'App\Http\Controllers\AllocationsController@downloadAllocationForm');
});

Route::group(['middleware' => ['auth', 'activated', 'web', 'activity', 'manageradmin']], function () {

    // jobcards
    Route::resource('jobcards', 'App\Http\Controllers\JobcardsController');
    Route::resource('deleted-jobcards', 'App\Http\Controllers\SoftDeleteJobcardsController');
    Route::get('restore-job/{id}', 'App\Http\Controllers\SoftDeleteJobcardsController@restoreJob');
    Route::get('get-jobcard-import', 'App\Http\Controllers\JobcardsController@importJobcards');
    Route::post('import-jobcard', 'App\Http\Controllers\JobcardsController@uploadJobcards');
    Route::get('/jobcard-download', 'App\Http\Controllers\JobcardsController@downloadJobcardForm');

    Route::get('/available/jobcard', [JobcardsController::class, 'getAvailableJobCard']);
});

Route::group(['middleware' => ['auth', 'activated', 'web', 'activity']], function () {

    // admin food requests
    Route::get('/get-bulk-approval', 'App\Http\Controllers\FoodRequestController@bulkApproveRequest')->middleware('manageradmin');
    Route::get('searchallocation', 'App\Http\Controllers\FoodRequestController@searchResponse');
    Route::post('multi-insert-post', 'App\Http\Controllers\FoodRequestController@multiInsertPost');

    Route::get('/approved-requests', 'App\Http\Controllers\FoodRequestController@getApproved');
    Route::get('/pending-requests', 'App\Http\Controllers\FoodRequestController@getPending');
    Route::get('/collected-requests', 'App\Http\Controllers\FoodRequestController@getCollectedRequests');

    Route::get('/get-allocation-request/{paynumber}', 'App\Http\Controllers\FoodRequestController@getAllocation');
    Route::get('/get-daily-approval', 'App\Http\Controllers\FoodRequestController@dailyApproval');
    Route::post('/get-daily-post', 'App\Http\Controllers\FoodRequestController@dailyApprovalSearch')->name("daily");

    // Admin Meat Requests
    Route::get('/get-bulk-meat-approval', 'App\Http\Controllers\MeatRequestController@bulkApproveRequest')->middleware('manageradmin');
    Route::get('meat-searchallocation', 'App\Http\Controllers\MeatRequestController@searchResponse');
    Route::post('multi-insert-meat-post', 'App\Http\Controllers\MeatRequestController@multiInsertPost');

    Route::get('/approved-meat-requests', 'App\Http\Controllers\MeatRequestController@getApproved');
    Route::get('/pending-meat-requests', 'App\Http\Controllers\MeatRequestController@getPending');
    Route::get('/collected-meat-requests', 'App\Http\Controllers\MeatRequestController@getCollectedRequests');

    Route::get('/get-allocation-meat-request/{paynumber}', 'App\Http\Controllers\MeatRequestController@getAllocation');
    Route::get('/get-daily-meat-approval', 'App\Http\Controllers\MeatRequestController@dailyApproval');
    Route::post('/get-daily-meat-post', 'App\Http\Controllers\MeatRequestController@dailyApprovalSearch')->name("daily");
});

Route::group(['middleware' => ['auth', 'activated', 'web', 'activity']], function () {

    // food collection
    Route::resource('fcollections', 'App\Http\Controllers\FoodCollectionController')->middleware('hampercollection');
    Route::get('get-food-request/{id}', 'App\Http\Controllers\FoodCollectionController@getFoodRequest');
    Route::get('getfrequestallocation/{id}', 'App\Http\Controllers\FoodCollectionController@getFoodRequestAllocation');
    Route::get('getuserbeneficiaries/{id}', 'App\Http\Controllers\FoodCollectionController@getUserBeneficiaries');
    Route::get('/get-jobcard-request/{id}', 'App\Http\Controllers\FoodCollectionController@getRequestJobcard');
    Route::get('/getmeattype/{id}', 'App\Http\Controllers\FoodCollectionController@getMeatType');

    // meat collection
    Route::resource('mcollections', 'App\Http\Controllers\MeatCollectionController')->middleware('hampercollection');
    Route::get('/get-request-type/{id}', 'App\Http\Controllers\MeatCollectionController@getRequestType');
});

Route::group(['middleware' => ['auth', 'activated', 'web', 'activity', 'manageradmin']], function () {

    // Reports
    Route::get('user-collection-report', 'App\Http\Controllers\ReportsController@getUserCollection');
    Route::post('user-collection-post', 'App\Http\Controllers\ReportsController@postUserCollection');

    Route::get('get-month-report', 'App\Http\Controllers\ReportsController@getMonthReport');
    Route::post('get-month-post', 'App\Http\Controllers\ReportsController@postMonthReport');
});

Route::group(['middleware' => ['auth', 'activated', 'web', 'activity']], function () {

    // food request
    Route::resource('frequests', 'App\Http\Controllers\FoodRequestController');
    Route::get('/getusername/{paynumber}', 'App\Http\Controllers\FoodRequestController@getUsername');
    Route::get('/approve-request/{id}', 'App\Http\Controllers\FoodRequestController@approveRequest')->middleware('manageradmin');
    Route::get('/reject-request/{id}', 'App\Http\Controllers\FoodRequestController@rejectRequest')->middleware('manageradmin');

    Route::get('my-user-allocation', 'App\Http\Controllers\UserController@myAllocations');
    Route::get('my-user-requests', 'App\Http\Controllers\UserController@myRequets');

    // meat request
    Route::resource('mrequests', 'App\Http\Controllers\MeatRequestController');
    Route::get('/getusername/meat/{paynumber}', 'App\Http\Controllers\MeatRequestController@getUsername');
    Route::get('/approve-meat-request/{id}', 'App\Http\Controllers\MeatRequestController@approveRequest')->middleware('manageradmin');
    Route::get('/reject-meat-request/{id}', 'App\Http\Controllers\MeatRequestController@rejectRequest')->middleware('manageradmin');
});
