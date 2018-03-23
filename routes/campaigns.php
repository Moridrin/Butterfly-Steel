<?php

use Illuminate\Http\Request;

// Campaigns
Route::get('/campaign/new', function () {
    return view('forms/campaign');
})->middleware('auth');

Route::post('/campaign/new', function (Request $request) {
    if (!Auth::check()) {
        return redirect('/');
    }
    $data            = $request->validate([
        'title'       => 'required|max:255',
        'description' => 'required|max:255',
    ]);
    $data['user_id'] = Auth::user()->id;
    $campaign        = tap(new App\Campaign($data))->save();
    return redirect('/campaign/' . $campaign->id);
})->middleware('auth');

Route::get('/campaign/{id}', function ($id) {
    $campaign = \App\Campaign::all()->keyBy('id')->get($id);
    return view('campaign')->with('campaign', $campaign);
})->middleware('auth');
