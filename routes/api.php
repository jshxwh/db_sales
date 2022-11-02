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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/customer/all',['uses' => 'CustomerController@getCustomerAll','as' => 'customer.getcustomerall'] );

Route::resource('customer', 'CustomerController');
Route::resource('item', 'ItemController');

Route::post('/item/checkout',[
    'uses' => 'ItemController@postCheckout',
    'as' => 'checkout'
]); 

Route::get('/dashboard/title-chart',[
    'uses' => 'DashboardController@titleChart',
    'as' => 'dashboard.titleChart'
]);
Route::get('/dashboard/sales-chart',[
    'uses' => 'DashboardController@salesChart',
    'as' => 'dashboard.salesChart'
]);
Route::get('/dashboard/items-chart',[
    'uses' => 'DashboardController@itemsChart',
    'as' => 'dashboard.itemsChart'
]);

