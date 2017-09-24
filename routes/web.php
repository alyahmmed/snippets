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

    Route::get('task1', function () {
        return view('task1');
    });

    Route::get('task2', function () {
        return view('task2');
    });
    Route::post('task2', function (Request $request) {
        $type = $request->get('type');
        $request->request->remove('_token');
        $request->request->remove('type');

        if ($type == 'json') {
            return ($request->all());
        } else {
            $data = $request->all();
            $content = view('export', $data);

            return response($content, 200)
                ->header('Content-Type', 'text/xml');
        }
        return '';
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
