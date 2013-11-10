<?php

class SecurityController extends BaseController {

	public function all()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "Security";
		$response["Message"] 	= "All years data.";

		$securitys = Security::all();

		foreach($securitys as $security)
			$security->data->toArray();

		$response["Data"] = $securitys->toArray();

		return $response;
	}

	public function info($id = null)
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["From"]		= "Security";

		if($id == null)
		{
			$response["Code"]		= 1;
			$response["Message"] 	= "Please give me an ID.";

			return $response;
		}

		$response["Code"] = 0;

		$security = Security::find($id);

		if($security == null)
		{
			$response["Code"]		= 2;
			$response["Message"] 	= "Sorry, couldn't find this ID.";

			return $response;
		}

		$security->data->toArray();

		$response["Data"] = $security->toArray();

		return $response;
	}

	public function index()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "Security";
		$response["Message"] 	= "Everything is fine!";

		return $response;
	}

	public function create()
	{
		$response = array();

		$response["Status"] = 200;

		$validation = Validator::make(Input::all(), array(
			'name' => array('required'),
			'description' => array('required'),
		));

		if(!$validation->fails())
		{
			$security = new Security;

			$security->name = Input::get('name');
			$security->description = Input::get('description');

			$security->save();

			$response["Code"]	 = 0;
			$response["From"]	 = "Security";
			$response["Message"] = "Data #".$security->id." registered!";
			$response["Data"] 	 = $security->toArray();
		
			return $response;
		}
		else
		{
			$response["From"]	 = "Security";
			$response["Code"]	 = 1;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}

	public function attach()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["From"]		= "Security";

		$validation = Validator::make(Input::all(), array(
			'security_id' => array('required'),
			'year' => array('required'),
			'percentage' => array('required'),
		));

		if(!$validation->fails())
		{
			$security = Security::find(Input::get('security_id'));

			if($security == null)
			{
				$response["Code"]		= 2;
				$response["Message"] 	= "Sorry, couldn't find this ID.";

				return $response;
			}

			$securityData = new SecurityData;

			$securityData->security_id = Input::get('security_id');
			$securityData->year = Input::get('year');
			$securityData->percentage = Input::get('percentage');

			$security->data()->save($securityData);

			$security->data->toArray();

			$response["Code"]		 = 0;
			$response["From"]		 = "Security";
			$response["Message"]	 = "Data attached!";
			$response["Data"] 		 = $security->toArray();
		
			return $response;
		}
		else
		{
			$response["From"]	 = "Security";
			$response["Code"]	 = 1;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}
}