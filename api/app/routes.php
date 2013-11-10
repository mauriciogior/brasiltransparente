<?php

function lost()
{
	$response = array();

	$response["Status"]  = 404;
	$response["Auth"] 	 = PublicController::getAuth();
	$response["Code"] 	 = 0;
	$response["Message"] = "URL not found";

	return $response;
}

/*
|--------------------------------------------------------------------------
| Rotas públicas
|--------------------------------------------------------------------------
*/

Route::get('education/{$id}', 'EducationController@info');
Route::get('/', 'PublicController@index');

//Route::get('newsletter/all', 'NewsletterController@all');
Route::get('education', 'EducationController@index');
Route::get('education/all', 'EducationController@all');

Route::post('education/create', 'EducationController@create');
Route::get('education/create', function()
{
	return lost();
});

Route::post('user/auth', 'UserController@auth');
Route::get('user/auth', function()
{
	return lost();
});

Route::post('enterprise/create', 'EnterpriseController@create');
Route::get('enterprise/create', function()
{
	return lost();
});

Route::post('user/create', 'UserController@create');
Route::get('user/create', function()
{
	return lost();
});

Route::get('enterprises', 'EnterpriseController@all');

App::missing(function($exception)
{
	return lost();
});