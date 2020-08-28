<?php

use App\Forum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Athlete ROUTES
 */
Route::get('/home/dashboard/{tab}', 'HomeController@athleteHome')->name('athlete.home');

/**
 * USER CONTROLLER ROUTES
 */
// Profile
Route::get('/profile/edit', 'UserController@showEditProfile')->name('profileEdit.show');
Route::get('/profile/{user}/dashboard/{tab}', 'UserController@showProfile')->name('profile.show');
Route::post('/profile', 'UserController@updateAvatar')->name('profile.update_avatar');
Route::post('/profile/updateProfile', 'UserController@updateProfileInfo')->name('profile.edit');
Route::post('/profile/updateThirdPartiesInfo', 'UserController@updateThirdPartiesInfo')->name('profile.thirdparties');

// Forum, threads and replies 
Route::post('/updateThread', 'ForumThreadController@update')->name('thread.update');
Route::post('/createThread', 'ForumThreadController@store')->name('thread.store');
Route::post('/destroyThread', 'ForumThreadController@destroy')->name('thread.destroy');
Route::post('/pinThread', 'ForumThreadController@pinThread')->name('thread.pin');
Route::post('/storeReply', 'ForumReplyController@store')->name('reply.store');
Route::post('/updateReply', 'ForumReplyController@update')->name('reply.update');
Route::post('/destroyReply', 'ForumReplyController@destroy')->name('reply.destroy');

// UserFiles 
Route::post('/newUserFile', 'UserFileController@store')->name('userFile.store');
Route::post('/updateUserFile', 'UserFileController@update')->name('userFile.update');
Route::post('/destroyUserFile', 'UserFileController@destroy')->name('userFile.destroy');

// ->> JQ LOAD COMPONENTS 
Route::get('/thread/{thread}/{isGroup?}', 'ForumThreadController@show')->name('thread.show');
Route::get('/component/reply/{reply}', 'ForumReplyController@show')->name('reply.show');

//Files uploads and downloads
Route::post('/upload', 'UserController@uploadFile')->name('profile.uploadFile');


//Train this user
Route::post('/train', 'UserController@trainThisAthlete')->name('trainUser');
Route::post('/stopTraining', 'UserController@stopTrainingThisAthlete')->name('stopTrainingThisAthlete');


//Deactivate account
Route::post('/activate', 'UserController@activateAccount')->name('profile.activate');
Route::post('/deactivate', 'UserController@deactivateAccount')->name('profile.deactivate');


//Monthly payment
Route::post('/pay', 'UserController@setMonthAsPaid')->name('profile.setMonthAsPaid');
Route::post('/delpayment', 'UserController@setMonthAsNotPaid')->name('profile.setMonthAsNotPaid');

//Invoices status
Route::post('/invoicepaid', 'InvoiceController@setInvoiceAsPaid')->name('invoice.setInvoiceAsPaid');
Route::post('/invoiceunpaid', 'InvoiceController@setInvoiceAsUnpaid')->name('invoice.setInvoiceAsUnpaid');


//Athlete's subscription forms 
Route::post('/updatesubscription', 'AthleteController@updateSubscriptionOnAthlete')->name('athlete.updateSubscription');
Route::post('/togglepayment', 'AthleteController@toggleCurrentMonthPaymentStatus')->name('athlete.toggleMonthPayment');

//TrainingPlan routes
Route::post('/training', 'TrainingPlanController@store')->name('trainingPlan.store');
Route::post('/deletePlan', 'TrainingPlanController@destroy')->name('trainingPlan.destroy');
Route::post('/updatePlan', 'TrainingPlanController@update')->name('trainingPlan.update');


//Tutorship
Route::post('/tutorship', 'TutorshipController@store')->name('tutorship.store');
Route::post('/tbookmark', 'TutorshipController@toggleBookmark')->name('tutorship.toggleBookmark');
Route::post('/tupdate', 'TutorshipController@update')->name('tutorship.update');
Route::post('/tdestroy', 'TutorshipController@destroy')->name('tutorship.destroy');

//Access log
Route::post('/updateAccess', 'UserController@updateServiceAccessesDates')->name('user.updateAccess');

//My wall
Route::post('/myWall', 'UserController@myWall')->name('user.myWall');

/**
 * GROUP ROUTES
 */
Route::post('/newGroup', 'GroupController@store')->name('group.store');
Route::post('/updateGroup', 'GroupController@update')->name('group.update');
Route::post('/toggleAdmin', 'GroupController@toggleGroupAdmin')->name('group.toggleGroupAdmin');
Route::post('/removeGroupImage', 'GroupController@removeGroupImage')->name('group.removeGroupImage');

//View
Route::get('/group/{group}/{tab}', 'GroupController@show')->name('group.show');


//Group Member methods  
Route::post('/addToGroup', 'GroupController@addMember')->name('group.addMember');
Route::post('/removeFromGroup', 'GroupController@removeMember')->name('group.removeMember');
Route::post('/gdestroy', 'GroupController@destroy')->name('group.destroy');
