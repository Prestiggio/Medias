<?php
Route::get("ry/medias/ngmodel", function(){
	return view("rymedias::ngmodel");
});
Route::get("ry/medias/upload-simple", function(){
	return view("rymedias::simple");
});
Route::get("ry/medias/upload", function(){
	return view("rymedias::upload");
});
Route::get('/meotoken', function(){
	$ch = curl_init("https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=691462271025098&client_secret=635f60e1510231ea5bb5cae9a3f60b47&fb_exchange_token=EAAJ04ZAsKP8oBANGbI3QsOpt83whsDq3DFXVTeLCCphlzM9v4eh1vvZCQvG4cpt5AITNhOirwlxGd3swagiUb40E7orjGaKKjnNZCZAKRWXZCynptvf1bX6MCb14afRbGVvIIWnLteS8Q6PwbgBQMunHjkLbE7ZAfMNtsoc8mYDWwg65JHGJkLzxp0u6maYrkZD");
	curl_exec($ch);
	curl_close($ch);
});
Route::get('img/{w}/{h}/{filename}', 'PublicController@getResize')->where('w', '[\d\.]+')->where('h', '[\d\.]+')->where('filename', '.+\.\w{3,4}');
Route::post('storage/save', 'PublicJsonController@postSave');
Route::group(['middleware' => ['web', 'auth']], function(){
	Route::get('storage', 'PublicJsonController@getIndex');
	Route::post('storage/save', 'PublicJsonController@postSave');
});
