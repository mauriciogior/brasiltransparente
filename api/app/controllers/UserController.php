<?php

class UserController extends BaseController {

	public function userInfo()
	{
		$user = Auth::user()->user;

		$user->common->toArray();
		$user->enterprise->common->toArray();
		$user->enterprise->federation->toArray();
		$user->enterprise->university->toArray();
		$user->enterprise->toArray();

		return $user->toArray();
	}

	public function all()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Auth"] 		= PublicController::getAuth();
		$response["Code"]		= 0;
		$response["Message"] 	= "List of enterprises.";

		$enterprises = Enterprise::all(array('id','website'))->toArray();

		$response["Enterprises"] = $enterprises;

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
		$response["Data"] 		= $this->userInfo();

		return $response;
	}

	public function create()
	{
		$response = array();

		$response["Status"] = 200;

		$validation = Validator::make(Input::all(), array(
			'username' => array('required'),
			'password' => array('required'),
			'enterprise_id' => array('required'),
			'professional_email' => array('required'),
			'phone' => array('required'),
			'mobile_phone' => array('required'),
			'email' => array('required'),
			'name' => array('required'),
			'address' => array('required'),
			'city' => array('required'),
			'state' => array('required'),
			'country' => array('required')
		));

		if(!$validation->fails())
		{
			$auth = new SystemAuth;
			$user = new User;
			$common = new Common;

			$common->name = Input::get('name');
			$common->email = Input::get('email');
			$common->address = Input::get('address');
			$common->city = Input::get('city');
			$common->state = Input::get('state');
			$common->country = Input::get('country');

			$common->save();

			$user->common_id = $common->id;
			$user->enterprise_id = Input::get('enterprise_id');
			$user->professional_email = Input::get('professional_email');
			$user->phone = Input::get('phone');
			$user->mobile_phone = Input::get('mobile_phone');

			$user->save();

			$auth->username = Input::get('username');
			$auth->password = Hash::make(Input::get('password'));
			$auth->user_id = $user->id;

			$auth->save();

			$credentials = array('username' => Input::get('username'),
				'password' => Input::get('password'));

			if (Auth::attempt($credentials))
			{
				$response["Auth"] 	 = PublicController::getAuth();
				$response["Code"]	 = 0;
				$response["Message"] = "User #".$user->id." registered!";
				$response["Data"] 	 = $this->userInfo();
			
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
				if(!Auth::user()->user_id)
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