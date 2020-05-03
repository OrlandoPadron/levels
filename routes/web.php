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

//User controllers routes 
Route::get('/profile/edit', 'UserController@showEditProfile')->name('profileEdit.show');
Route::get('/profile/{user}/dashboard', 'UserController@showProfile')->name('profile.show');
Route::post('/profile', 'UserController@updateAvatar')->name('profile.update_avatar');

//Train this user
Route::post('/train', 'UserController@trainThisAthlete')->name('trainUser');
Route::post('/stopTraining', 'UserController@stopTrainingThisAthlete')->name('stopTrainingThisAthlete');




//TrainingPlan routes
Route::post('/training', 'TrainingPlanController@store')->name('trainingPlan.store');
Route::post('/deletePlan', 'TrainingPlanController@destroy')->name('trainingPlan.destroy');
