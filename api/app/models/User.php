<?php

class User extends Eloquent {

	protected $table = 'users';

	public function common()
	{
		return $this->belongsTo('Common');
	}

	public function enterprise()
	{
		return $this->belongsTo('Enterprise');
	}

}