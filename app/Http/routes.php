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
Route::resource('/classrooms', 'ClassroomController');
Route::resource('/precincts', 'PrecinctController');
Route::resource('/schedules', 'ScheduleController');
Route::resource('/periods', 'PeriodController');

Route::post('/users/office/{user}/{office}', 'UsersController@add_office');
Route::post('/users/career/{user}/{career}', 'UsersController@add_career');
Route::post('/users/course/{user}/{course}', 'UsersController@add_course');
Route::delete('/users/office/{user}/{office}', 'UsersController@remove_office');
Route::delete('/users/career/{user}/{career}', 'UsersController@remove_career');
Route::delete('/users/course/{user}/{course}', 'UsersController@remove_course');

Route::post('/offices/user/{office}/{user}', 'OfficesController@add_user');
Route::delete('/offices/user/{office}/{user}', 'OfficesController@remove_user');

Route::post('/careers/course/{career}/{course}', 'CareersController@add_course');
Route::post('/careers/user/{career}/{user}', 'CareersController@add_user');
Route::delete('/careers/course/{career}/{course}', 'CareersController@remove_course');
Route::delete('/careers/user/{career}/{user}', 'CareersController@remove_user');

Route::post('/courses/career/{course}/{career}', 'CoursesController@add_career');
Route::post('/courses/user/{course}/{user}', 'CoursesController@add_user');
Route::delete('/courses/career/{course}/{career}', 'CoursesController@remove_career');
Route::delete('/courses/user/{course}/{user}', 'CoursesController@remove_user');

Route::post('/precincts/schedule/{precinct}/{schedule}', 'PrecinctController@add_schedule');
Route::delete('/precincts/schedule/{precinct}/{schedule}', 'PrecinctController@remove_schedule');

Route::post('/schedules/precinct/{schedule}/{precinct}', 'PrecinctController@add_precinct');
Route::delete('/schedules/precinct/{schedule}/{precinct}', 'PrecinctController@add_precinct');

//Authentication middleware group
Route::group(['prefix' => 'api'], function()
{
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
});
