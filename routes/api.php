<?php

Route::get('/getContent/{path}', 'IndexController@index');
Route::post('/create', 'IndexController@create');
