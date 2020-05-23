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
Route::get('/profile/{user}/dashboard', 'UserController@showProfile')->name('profile.show');
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
Route::post('/invoicepaid', 'UserController@setInvoiceAsPaid')->name('profile.setInvoiceAsPaid');
Route::post('/invoiceunpaid', 'UserController@setInvoiceAsUnpaid')->name('profile.setInvoiceAsUnpaid');


//TrainingPlan routes
Route::post('/training', 'TrainingPlanController@store')->name('trainingPlan.store');
Route::post('/deletePlan', 'TrainingPlanController@destroy')->name('trainingPlan.destroy');


/**
 * GROUP ROUTES
 */
//Creation
Route::post('/newGroup', 'GroupController@store')->name('group.store');
Route::get('/group', 'GroupController@index')->name('group.show');
