<?php
Route::get('img/{w}/{h}/{filename}', 'PublicController@getResize')->where('w', '[\d\.]+')->where('h', '[\d\.]+')->where('filename', '.+\.\w{3,4}');

Route::group(['middleware' => ['api', 'auth.api', 'auth']], function(){
	Route::controller('storage', 'PublicJsonController');
});