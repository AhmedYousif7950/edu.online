<?php

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

Route::get('/','HomeController@getHome');
Route::get('/home','HomeController@getHome')->name('home');
Route::get('/login', 'Auth\LoginController@getLogin')->name('login');
Route::post('/login','Auth\LoginController@postLogin');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/register', 'Auth\RegisterController@getRegister')->name('register');
Route::post('/register','Auth\RegisterController@postRegister');


Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'middleware' => ['web', 'auth']], function () {
    Route::get('/','DashboardController@dashobard')->name('dashboard');
    Route::get('/courses','DashboardController@courses')->name('courses');
    Route::post('/courses/add','DashboardController@add_course')->name('course.add');
    Route::post('/courses/{id?}','DashboardController@edit_course')->name('course.edit')->where(['id' => '[0-9]+']);;
    Route::get('/courses/{id?}','DashboardController@delete_course')->name('course.delete')->where(['id' => '[0-9]+']);;

});



