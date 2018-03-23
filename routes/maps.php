<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// View
Route::get('/map/{id}', 'MapViewController@show');
Route::get('/map/{id}/getTile/{z}/{x}/{y}', 'MapViewController@getTile');

// Edit
Route::get('/map/{id}/edit', 'MapEditController@show');
Route::post('/map/{id}/get-tile-for-update', 'MapEditController@getTileForUpdate');
Route::post('/map/{id}/remove-map-part', 'MapEditController@removeMapPart');

// New Map Part
Route::post('/map/{id}/map-part/upload-image', 'MapEditController@uploadImage');
Route::get('/map-part/{id}/get-creation-progress', 'MapEditController@getMapPartCreationProgress');
Route::get('/map-part/{id}/finish-creation', 'MapEditController@finishMapPartCreation');
