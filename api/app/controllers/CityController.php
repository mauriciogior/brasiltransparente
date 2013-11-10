<?php

class CityController extends BaseController {

	private function cityToArray(&$city)
	{	
		if($city->politicians)
		{
			foreach($city->politicians as $politician)
			{
				$politician->party->toArray();
				$politician->toArray();
			}
		}

		if($city->educations)
		{
			foreach($city->educations as $education)
			{
				$education->data->toArray();
				$education->toArray();
			}
		}

		if($city->securities)
		{
			foreach($city->securities as $security)
			{
				$security->data->toArray();
				$security->toArray();
			}
		}

		if($city->transports)
		{
			foreach($city->transports as $transport)
			{
				$transport->data->toArray();
				$transport->toArray();
			}
		}

		return;
	}
	public function all()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "City";
		$response["Message"] 	= "All cities data.";

		$cities = City::all();

		foreach($cities as $city)
			$this->cityToArray($city);

		$response["Data"] = $cities->toArray();

		return $response;
	}

	public function info($id = null)
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["From"]		= "City";

		if($id == null)
		{
			$response["Code"]		= 1;
			$response["Message"] 	= "Please give me an ID.";

			return $response;
		}

		$response["Code"] = 0;

		$city = City::find($id);

		if($city == null)
		{
			$response["Code"]		= 2;
			$response["Message"] 	= "Sorry, couldn't find this ID.";

			return $response;
		}

		$this->cityToArray($city);

		$response["Data"] = $city->toArray();

		return $response;
	}

	public function index()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "City";
		$response["Message"] 	= "Everything is fine!";

		return $response;
	}

	public function create()
	{
		$response = array();

		$response["Status"] = 200;

		$validation = Validator::make(Input::all(), array(
			'name' => array('required'),
			'state' => array('required'),
			'state_acronym' => array('required'),
		));

		if(!$validation->fails())
		{
			$city = new City;

			$city->name = Input::get('name');
			$city->state = Input::get('state');
			$city->state_acronym = Input::get('state_acronym');

			$city->save();

			$response["Code"]	 = 0;
			$response["From"]	 = "City";
			$response["Message"] = "Data #".$city->id." registered!";
			$response["Data"] 	 = $city->toArray();
		
			return $response;
		}
		else
		{
			$response["From"]	 = "City";
			$response["Code"]	 = 1;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}

}