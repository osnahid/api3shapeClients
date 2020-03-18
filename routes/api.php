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


Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');

    // customer endpoints
    Route::get('customers', 'API\CustomerController@index');
    Route::get('customers/{id}', 'API\CustomerController@show');
    Route::post('customers', 'API\CustomerController@store');
    Route::post('customers/{id}', 'API\CustomerController@update');
    Route::delete('customers/{id}', 'API\CustomerController@destroy');

    //employee endpoints
    Route::post('customers/{customer_id}/employees/{id}', 'API\EmployeController@update');
    Route::post('customers/{customer_id}/employees', 'API\EmployeController@store');
    Route::delete('employees/{id}', 'API\EmployeController@destroy');
    Route::get('employees/{id}', 'API\EmployeController@show');


    // company endpoints
    Route::get('companies', 'API\CompanyController@index');
    Route::get('companies/{id}', 'API\CompanyController@show');
    Route::post('companies', 'API\CompanyController@store');
    Route::post('companies/{id}', 'API\CompanyController@update');
    Route::delete('companies/{id}', 'API\CompanyController@destroy');

    //materiel endpoints
    Route::get('materiels', 'API\MaterielController@index');
    Route::get('materiels/{id}', 'API\MaterielController@show');
    Route::post('companies/{company_id}/materiels', 'API\MaterielController@store');
    Route::post('materiels/{id}', 'API\MaterielController@update');
    Route::delete('materiels/{id}', 'API\MaterielController@destroy');

    //software endpoints
    Route::get('softwares', 'API\SoftwareController@index');
    Route::get('softwares/{id}', 'API\SoftwareController@show');
    Route::post('companies/{company_id}/softwares', 'API\SoftwareController@store');
    Route::post('softwares/{id}', 'API\SoftwareController@update');
    Route::delete('softwares/{id}', 'API\SoftwareController@destroy');

    //action endpoints
    Route::get('actions', 'API\ActionController@index');
    Route::get('actions/{id}', 'API\ActionController@show');
    Route::post('actions', 'API\ActionController@store');
    Route::post('actions/{id}', 'API\ActionController@update');
    Route::delete('actions/{id}', 'API\ActionController@destroy');

});




