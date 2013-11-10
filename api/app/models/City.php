<?php

class City extends Eloquent {

	protected $table = 'cities';

	public $timestamps = true;

	public function politicians()
	{
		return $this->hasMany('Politician');
	}

	public function educations()
	{
		return $this->hasMany('Education');
	}

	public function securities()
	{
		return $this->hasMany('Security');
	}

	public function transports()
	{
		return $this->hasMany('Transport');
	}
	
}