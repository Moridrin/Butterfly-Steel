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
        return view('myCampaigns')->with('campaigns', $campaigns);
    } else {
        return view('welcome');
    }
})->name('home');

Auth::routes();

$this->get('logout', function (Request $request) {
    Auth::logout();
    $request->redirect('/');
});

require_once 'campaigns.php';
require_once 'maps.php';
