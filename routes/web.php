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

use Illuminate\Http\Request;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('home', function () {
        return view('welcome');
    });

    Route::get('blocks', function () {
        return view('blocks');
    });
});

Auth::routes();

// DB migration route
Route::get('_db_migrate', function()
{
    $username = 'admin';
    $password = 'adm1n@';

    if( ( isset($_SERVER['PHP_AUTH_USER'] ) &&
        ( $_SERVER['PHP_AUTH_USER'] == $username ) ) AND
        ( isset($_SERVER['PHP_AUTH_PW'] ) &&
            ( $_SERVER['PHP_AUTH_PW'] == $password ) ) )
    {
        echo '<pre>';
        \Artisan::call('migrate', ['--force' => true]);
    } else {
        header('WWW-Authenticate: Basic realm="Unauthorized"');
        header('HTTP/1.0 401 Unauthorized');
        exit;
    }
});
