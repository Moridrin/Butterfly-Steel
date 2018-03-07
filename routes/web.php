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

use App\Campaign;

Route::get('/', function () {
    if (Auth::check()) {
        $campaigns = Campaign::whereUserId(Auth::user()->id)->orderBy('updated_at')->get();
    } else {
        $campaigns = [];
    }
    return view('welcome')->with('campaigns', $campaigns);
})->name('home');

Auth::routes();

$this->get('logout', function (Request $request) {
    Auth::logout();
    $request->redirect('/');
});

require_once 'campaigns.php';
require_once 'maps.php';
