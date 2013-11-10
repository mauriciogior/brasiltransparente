<?php

class Security extends Eloquent {

	protected $table = 'securities';

	public $timestamps = true;
	
	public function data()
	{
		return $this->hasMany('SecurityData');
	}
}