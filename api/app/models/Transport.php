<?php

class Transport extends Eloquent {

	protected $table = 'transports';

	public $timestamps = true;
	
	public function data()
	{
		return $this->hasMany('TransportData');
	}
}