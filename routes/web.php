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

//Tasks
Route::post('/tasks', 'TaskController@index')->name('taskIndex');
Route::post('/tasks/getStatuses', 'TaskController@getStatuses');
Route::post('/tasks/getDirectors', 'TaskController@getDirectors');
Route::post('/tasks/getResponsible', 'TaskController@getResponsible');
Route::post('/tasks/search', 'TaskController@search');


Route::get('/', function () {
    return view('welcome');
});
