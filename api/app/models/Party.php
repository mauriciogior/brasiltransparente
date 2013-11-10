<?php

class Party extends Eloquent {

	protected $table = 'parties';

	public $timestamps = true;

	public function politician()
	{
		return $this->hasMany('Politician');
	}
}