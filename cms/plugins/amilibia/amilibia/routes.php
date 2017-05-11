<?php

Route::get('/api', 'Amilibia\Amilibia\Api\ApiIndex@index');

// Route::get('/api/{locale}/pages/{slug?}', 'Amilibia\Amilibia\Api\Pages@find');
Route::get('/api/{locale}/pages', 'Amilibia\Amilibia\Api\Pages@index');
Route::get('/api/{locale}/products/', 'Amilibia\Amilibia\Api\Products@index');
Route::get('/api/works', 'Amilibia\Amilibia\Api\Works@index');
// Route::post('/api/comments/{video_id}/{audio_id}', 'Amilibia\Amilibia\Api\Comments@save');
