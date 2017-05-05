<?php
Route::get('img/{w}/{h}/{filename}', 'PublicController@getResize')->where('w', '[\d\.]+')->where('h', '[\d\.]+')->where('filename', '.+\.\w{3,4}');
Route::post('storage/save', 'PublicJsonController@postSave');
Route::group(['middleware' => ['web', 'auth']], function(){
	Route::controller('storage', 'PublicJsonController');
});
