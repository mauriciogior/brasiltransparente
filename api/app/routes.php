<?php

function lost()
{
	$response = array();

	$response["Status"]  = 404;
	$response["Code"] 	 = 0;
	$response["Message"] = "URL not found";

	return $response;
}

/*
|--------------------------------------------------------------------------
| Rotas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', 'PublicController@index');

//EDUCATION
Route::get('education', 'EducationController@index');
Route::get('education/all', 'EducationController@all');
Route::get('education/{id}', 'EducationController@info');

Route::post('education/create', 'EducationController@create');
Route::post('education/attach', 'EducationController@attach');

//TRANSPORT
Route::get('transport', 'TransportController@index');
Route::get('transport/all', 'TransportController@all');
Route::get('transport/{id}', 'TransportController@info');

Route::post('transport/create', 'TransportController@create');
Route::post('transport/attach', 'TransportController@attach');

//SECURITY
Route::get('security', 'SecurityController@index');
Route::get('security/all', 'SecurityController@all');
Route::get('security/{id}', 'SecurityController@info');

Route::post('security/create', 'SecurityController@create');
Route::post('security/attach', 'SecurityController@attach');

//POLITICIAN
Route::get('politician', 'PoliticianController@index');
Route::get('politician/all', 'PoliticianController@all');
Route::get('politician/{id}', 'PoliticianController@info');

Route::post('politician/create', 'PoliticianController@create');

//PARTY
Route::get('party', 'PartyController@index');
Route::get('party/all', 'PartyController@all');
Route::get('party/{id}', 'PartyController@info');

Route::post('party/create', 'PartyController@create');

//CITY
Route::get('city', 'CityController@index');
Route::get('city/all', 'CityController@all');
Route::get('city/{id}', 'CityController@info');

Route::post('city/create', 'CityController@create');

App::missing(function($exception)
{
	return lost();
});