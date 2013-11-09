<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserLogged extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_logged', function($table){

			$table->increments('id');

			$table->integer('user_id');
			$table->boolean('at_office');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_logged');
	}

}