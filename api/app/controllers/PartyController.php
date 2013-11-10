<?php

class PartyController extends BaseController {

	public function all()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "Party";
		$response["Message"] 	= "All parties.";

		$parties = Party::all();

		foreach($parties as $party)
			$party->politician->toArray();

		$response["Data"] = $parties->toArray();

		return $response;
	}

	public function info($id = null)
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["From"]		= "Party";

		if($id == null)
		{
			$response["Code"]		= 1;
			$response["Message"] 	= "Please give me an ID.";

			return $response;
		}

		$response["Code"] = 0;

		$party = Party::find($id);

		if($party == null)
		{
			$response["Code"]		= 2;
			$response["Message"] 	= "Sorry, couldn't find this ID.";

			return $response;
		}

		$curr=0;
		$beg=0;
		$med=0;
		$j=0;

		foreach($party->politician as $politician)
		{
			$city = $politician->city;

			$education = array();
			$security  = array();
			$transport = array();

			$beg = $curr;

			if($city->educations)
			{
				for($j=0;$j<2;$j++)
				{
					$med = 0;

					for($i=$beg; $i<$beg+4; $i++)
						$med += $city->educations[$j]->data[$i]->percentage;

					$med /= 4;

					$data = new stdClass();

					$data->id = $city->educations[$j]->id;
					$data->name = $city->educations[$j]->name;
					$data->description = $city->educations[$j]->description;
					$data->value = $med;

					array_push($education,$data);
				}
			}

			if($city->securities)
			{
				for($j=0;$j<2;$j++)
				{
					$med = 0;

					for($i=$beg; $i<$beg+4; $i++)
						$med += $city->securities[$j]->data[$i]->percentage;

					$med /= 4;

					$data = new stdClass();

					$data->id = $city->securities[$j]->id;
					$data->name = $city->securities[$j]->name;
					$data->description = $city->securities[$j]->description;
					$data->value = $med;

					array_push($security,$data);
				}
			}

			if($city->transports)
			{
				for($j=0;$j<2;$j++)
				{
					$med = 0;

					for($i=$beg; $i<$beg+4; $i++)
						$med += $city->transports[$j]->data[$i]->percentage;

					$med /= 4;

					$data = new stdClass();

					$data->id = $city->transports[$j]->id;
					$data->name = $city->transports[$j]->name;
					$data->description = $city->transports[$j]->description;
					$data->value = $med;

					array_push($transport,$data);
				}
			}

			$politician->education = $education;
			$politician->security = $security;
			$politician->transport = $transport;

			unset($politician->city);

			$curr += 3;
		}

		$party->politician->toArray();

		$response["Data"] = $party->toArray();

		return $response;
	}

	public function index()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "Party";
		$response["Message"] 	= "Everything is fine!";

		return $response;
	}

	public function create()
	{
		$response = array();

		$response["Status"] = 200;

		$validation = Validator::make(Input::all(), array(
			'name' => array('required'),
			'flag' => array('required'),
		));

		if(!$validation->fails())
		{
			$party = new Party;

			$party->name = Input::get('name');
			$party->flag = Input::get('flag');

			$party->save();

			$response["Code"]	 = 0;
			$response["From"]	 = "Party";
			$response["Message"] = "Data #".$party->id." registered!";

			$party->politician->toArray();

			$response["Data"] 	 = $party->toArray();
		
			return $response;
		}
		else
		{
			$response["From"]	 = "Party";
			$response["Code"]	 = 1;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}

}