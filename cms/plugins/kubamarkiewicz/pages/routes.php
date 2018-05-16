<?php

Route::get('/api/pages', 'KubaMarkiewicz\Pages\Api\Pages@index');
Route::get('/api/metadata/{url?}', 'KubaMarkiewicz\Pages\Api\Metadata@index');
