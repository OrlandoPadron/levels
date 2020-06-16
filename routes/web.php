<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * USER CONTROLLER ROUTES
 */
// Profile
Route::get('/profile/edit', 'UserController@showEditProfile')->name('profileEdit.show');
Route::get('/profile/{user}/dashboard/{tab}', 'UserController@showProfile')->name('profile.show');
Route::post('/profile', 'UserController@updateAvatar')->name('profile.update_avatar');

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


//Tutorship
Route::post('/tutorship', 'TutorshipController@store')->name('tutorship.store');
Route::post('/bookmark', 'TutorshipController@toggleBookmark')->name('tutorship.toggleBookmark');
Route::post('/update', 'TutorshipController@update')->name('tutorship.update');
Route::post('/destroy', 'TutorshipController@destroy')->name('tutorship.destroy');

/**
 * GROUP ROUTES
 */
//Creation
Route::post('/newGroup', 'GroupController@store')->name('group.store');
Route::get('/group', 'GroupController@index')->name('group.show');

//View
Route::get('/group/{id}/{tab}', 'GroupController@show')->name('group.show');
