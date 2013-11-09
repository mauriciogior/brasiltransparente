<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_role', function($table){

			$table->increments('id');

			$table->integer('role_id');
			$table->integer('user_id');

			$table->boolean('current');

			$table->date('from_date');
			$table->date('to_date');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_role');
	}

}