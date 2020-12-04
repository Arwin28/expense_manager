<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'users' => 'API\UserController',
    'categories' => 'API\CategoryController',
    'expenses' => 'API\ExpenseController',
    'chart' => 'API\ExpenseController',
]);

Route::get('profile','API\UserController@profile');
Route::get('findUser','API\UserController@search');
Route::put('profile','API\UserController@updateProfile');
Route::get('categories','API\CategoryController@index');
Route::get('get_data_dropdown', 'API\CategoryController@getCountries');
Route::get('chart','API\ExpenseController@chart');
