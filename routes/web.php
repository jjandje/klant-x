<?php

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

Route::get('/home', function () {
    return view('pages/front_page');
});

/**
 * Application
 */
Route::get('/aanmelden', ['uses' => 'ApplicationController@index', 'as' => 'application.index']);
Route::post('/aanmelden', ['uses' => 'ApplicationController@store', 'as' => 'application.store']);

Route::get('/how_it_works', function () {
    return view('pages/how_it_works');
});

Route::get('/prices', function () {
    return view('pages/template_prices');
});

Route::get('/algemene_voorwaarden', function () {
    return view('pages/template_content');
});

Route::get('/privacy_statement', function () {
    return view('pages/template_content');
});

// forgot/set password stuff
Auth::routes(['register' => false, 'login' => false]);

/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/
Route::get('{page}/{subs?}', ['uses' => '\App\Http\Controllers\PageController@index', 'as' => 'page.show'])
     ->where(['page' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*']);
