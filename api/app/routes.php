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

Route::filter('authentication', function($route, $request, $value)
{
	if($value == "enterprise")
	{
		if(Auth::user())
		{
			if(!Auth::user()->enterprise_id)
			{
				return lost();
			}
		}
		else
		{
			return lost();
		}
	}
	else if($value == "user")
	{
		if(Auth::user())
		{
			if(!Auth::user()->user_id)
			{
				return lost();
			}
		}
		else
		{
			return lost();
		}
	}
});

/*
|--------------------------------------------------------------------------
| Rotas que exigem autenticação
|--------------------------------------------------------------------------
*/

Route::group(array('before' => 'authentication:enterprise'), function()
{
	Route::get('enterprise', 'EnterpriseController@index');
	Route::get('enterprise/logout', 'EnterpriseController@logout');
	Route::get('enterprise/info', 'EnterpriseController@info');
});

Route::group(array('before' => 'authentication:user'), function()
{
	Route::get('user', 'UserController@index');
	Route::get('user/logout', 'UserController@logout');
	Route::get('user/info', 'UserController@info');
});

/*
|--------------------------------------------------------------------------
| Rotas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', 'PublicController@index');

//Route::get('newsletter/all', 'NewsletterController@all');
Route::get('newsletter/{id}', 'NewsletterController@info');

Route::post('newsletter/create', 'NewsletterController@create');
Route::post('newsletter/create/{ref}', 'NewsletterController@create');
Route::get('newsletter/create', function()
{
	return lost();
});

Route::post('enterprise/auth', 'EnterpriseController@auth');
Route::get('enterprise/auth', function()
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