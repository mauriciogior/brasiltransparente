<?php

class EnterpriseController extends BaseController {

	public function enterpriseInfo()
	{
		$enterprise = Auth::user()->enterprise;

		$enterprise->common->toArray();
		$enterprise->federation->toArray();
		$enterprise->university->toArray();

		return $enterprise->toArray();
	}
	public function all()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Auth"] 		= PublicController::getAuth();
		$response["Code"]		= 0;
		$response["Message"] 	= "List of enterprises.";

		$enterprises = Enterprise::all();

		foreach($enterprises as $enterprise)
		{
			$enterprise->common->toArray();
			$enterprise->federation->toArray();
			$enterprise->university->toArray();
		}

		$response["Enterprises"] = $enterprises->toArray();

		return $response;
	}

	public function index()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Auth"] 		= PublicController::getAuth();
		$response["Code"]		= 0;
		$response["Message"] 	= "You are authenticated!";

		return $response;
	}

	public function info()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Auth"] 		= PublicController::getAuth();
		$response["Code"]		= 0;
		$response["Message"] 	= "You are authenticated!";
		$response["Data"] 		= $this->enterpriseInfo();

		return $response;
	}

	public function create()
	{
		$response = array();

		$response["Status"] = 200;

		$validation = Validator::make(Input::all(), array(
			'username' => array('required'),
			'password' => array('required'),
			'federation_id' => array('required'),
			'university_id' => array('required'),
			'cnpj' => array('required'),
			'phone' => array('required'),
			'website' => array('required'),
			'email' => array('required'),
			'name' => array('required'),
			'address' => array('required'),
			'city' => array('required'),
			'state' => array('required'),
			'country' => array('required')
		));

		if(!$validation->fails())
		{
			$auth 		= new SystemAuth;
			$enterprise = new Enterprise;
			$common = new Common;

			$common->name = Input::get('name');
			$common->email = Input::get('email');
			$common->address = Input::get('address');
			$common->city = Input::get('city');
			$common->state = Input::get('state');
			$common->country = Input::get('country');

			$common->save();

			$enterprise->common_id = $common->id;
			$enterprise->federation_id = Input::get('federation_id');
			$enterprise->university_id = Input::get('university_id');
			$enterprise->cnpj = Input::get('cnpj');
			$enterprise->phone = Input::get('phone');
			$enterprise->website = Input::get('website');

			$enterprise->save();

			$auth->username = Input::get('username');
			$auth->password = Hash::make(Input::get('password'));
			$auth->enterprise_id = $enterprise->id;

			$auth->save();

			$credentials = array('username' => Input::get('username'),
				'password' => Input::get('password'));

			if (Auth::attempt($credentials))
			{
				$response["Auth"] 	 = PublicController::getAuth();
				$response["Code"]	 = 0;
				$response["Message"] = "Enterprise #".$enterprise->id." registered!";
				$response["Data"] 	 = $this->enterpriseInfo();
			
				return $response;
			}
			else
			{
				$response["Auth"] 	 = PublicController::getAuth();
				$response["Code"]	 = 0;
				$response["Message"] = "Something really weird just occured!";
				$response["Data"] 	 = "Can't get any... sorry =/";
			
				return $response;
			}
		}
		else
		{
			$response["Auth"] 	 = PublicController::getAuth();
			$response["Code"]	 = 1;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}

	public function auth()
	{
		$response = array();

		$response["Status"] = 200;

		$validation = Validator::make(Input::all(), array(
			'username' => array('required'),
			'password' => array('required'),
		));

		if(!$validation->fails())
		{
			$credentials = array('username' => Input::get('username'),
				'password' => Input::get('password'));

			if (Auth::attempt($credentials))
			{
				if(!Auth::user()->enterprise_id)
				{
					Auth::logout();
					$response["Auth"] 	 = PublicController::getAuth();
					$response["Code"]	 = 1;
					$response["Message"] = "Username or password incorrect!";

					return $response;
				}
				$response["Auth"] 	 = PublicController::getAuth();
				$response["Code"]	 = 0;
				$response["Message"] = "You are authenticated!";

				return $response;
			}
			else
			{
				$response["Auth"] 	 = PublicController::getAuth();
				$response["Code"]	 = 1;
				$response["Message"] = "Username or password incorrect!";

				return $response;
			}
		}
		else
		{
			$response["Auth"]    = PublicController::getAuth();
			$response["Code"]	 = 2;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}

	public function logout()
	{
		$response = array();

		$response["Status"] = 200;

		Auth::logout();

		$response["Auth"] 	 = PublicController::getAuth();
		$response["Code"]	 = 0;
		$response["Message"] = "You've signed out!";

		return $response;
	}
}