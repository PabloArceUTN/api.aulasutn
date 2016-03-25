<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/users', 'UsersController');
Route::resource('/offices', 'OfficesController');
Route::resource('/careers', 'CareersController');
Route::resource('/courses', 'CoursesController');

Route::post('/users/office/{user}/{office}', 'UsersController@add_office');
Route::post('/users/career/{user}/{career}', 'UsersController@add_career');
Route::post('/users/course/{user}/{course}', 'UsersController@add_course');

Route::post('/offices/user/{office}/{user}', 'OfficesController@add_user');

Route::post('/careers/course/{career}/{course}', 'CareersController@add_course');
Route::post('/careers/user/{career}/{user}', 'CareersController@add_user');

Route::post('/courses/career/{course}/{career}', 'CoursesController@add_career');
Route::post('/courses/user/{course}/{user}', 'CoursesController@add_user');