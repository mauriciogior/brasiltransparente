<?php

use Illuminate\Database\Migrations\Migration;

class CreateAuthsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('auths', function($table){

			$table->increments('id');

			$table->string('enterprise_id');
			$table->string('user_id');
			$table->string('username');
			$table->string('password');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('auths');
	}

}