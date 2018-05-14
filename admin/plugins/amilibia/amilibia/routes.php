<?php

Route::get('/api/{locale}/products/', 'Amilibia\Amilibia\Api\Products@index');
Route::get('/api/works', 'Amilibia\Amilibia\Api\Works@index');
Route::get('/api/locations', 'Amilibia\Amilibia\Api\Locations@index');
Route::post('/api/contact', 'Amilibia\Amilibia\Api\Contact@send');
