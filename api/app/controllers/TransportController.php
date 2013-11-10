<?php

class TransportController extends BaseController {

	public function all()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "Transport";
		$response["Message"] 	= "All years data.";

		$transports = Transport::all();

		foreach($transports as $transport)
			$transport->data->toArray();

		$response["Data"] = $transports->toArray();

		return $response;
	}

	public function info($id = null)
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["From"]		= "Transport";

		if($id == null)
		{
			$response["Code"]		= 1;
			$response["Message"] 	= "Please give me an ID.";

			return $response;
		}

		$response["Code"] = 0;

		$transport = Transport::find($id);

		if($transport == null)
		{
			$response["Code"]		= 2;
			$response["Message"] 	= "Sorry, couldn't find this ID.";

			return $response;
		}

		$transport->data->toArray();

		$response["Data"] = $transport->toArray();

		return $response;
	}

	public function index()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "Transport";
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
			$transport = new Transport;

			$transport->name = Input::get('name');
			$transport->description = Input::get('description');

			$transport->save();

			$response["Code"]	 = 0;
			$response["From"]	 = "Transport";
			$response["Message"] = "Data #".$transport->id." registered!";
			$response["Data"] 	 = $transport->toArray();
		
			return $response;
		}
		else
		{
			$response["From"]	 = "Transport";
			$response["Code"]	 = 1;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}

	public function attach()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["From"]		= "Transport";

		$validation = Validator::make(Input::all(), array(
			'transport_id' => array('required'),
			'year' => array('required'),
			'percentage' => array('required'),
		));

		if(!$validation->fails())
		{
			$transport = Transport::find(Input::get('transport_id'));

			if($transport == null)
			{
				$response["Code"]		= 2;
				$response["Message"] 	= "Sorry, couldn't find this ID.";

				return $response;
			}

			$transportData = new TransportData;

			$transportData->transport_id = Input::get('transport_id');
			$transportData->year = Input::get('year');
			$transportData->percentage = Input::get('percentage');

			$transport->data()->save($transportData);

			$transport->data->toArray();

			$response["Code"]		 = 0;
			$response["From"]		 = "Transport";
			$response["Message"]	 = "Data attached!";
			$response["Data"] 		 = $transport->toArray();
		
			return $response;
		}
		else
		{
			$response["From"]	 = "Transport";
			$response["Code"]	 = 1;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}
}