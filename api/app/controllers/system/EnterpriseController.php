<?php

class EnterpriseController extends BaseController {

	public function index()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Auth"]		= true;
		$response["Message"] 	= "You are authenticated!";

		return $response;
	}

	public function auth()
	{
		$response = array();

		$response["Status"] = 200;

		$validation = Validator::make(Input::all(), array(
			'email' => array('required'),
			'password' => array('required'),
		));

		if($validation->valid())
		{
			$credentials = array('username' => Input::get('email'),
				'password' => Input::get('password'));

			Config::set('auth.model', 'Enterprise');
			Config::set('auth.table', 'enterprises');

			if (Auth::attempt($credentials))
			{
				$response["Auth"] 	 = true;
				$response["Code"]	 = 0;
				$response["Message"] = "You are authenticated!";

				$enterprise = Auth::user();

				Config::set('auth.model', 'User');
				Config::set('auth.table', 'users');

				return $response;
			}
			else
			{
				$response["Auth"] 	 = false;
				$response["Code"]	 = 1;
				$response["Message"] = "Username or password incorrect!";

				Config::set('auth.model', 'User');
				Config::set('auth.table', 'users');

				return $response;
			}
		}
		else
		{
			$response["Auth"] 	 = false;
			$response["Code"]	 = 2;
			$response["Message"] = "Please fill every field!";
		}
	}

}