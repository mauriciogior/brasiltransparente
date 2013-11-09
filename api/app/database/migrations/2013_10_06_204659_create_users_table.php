<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table){

			$table->increments('id');

			$table->integer('auth_id');
			$table->integer('common_id');
			$table->integer('enterprise_id');
			$table->integer('facebook_id');
			$table->integer('google_id');

			$table->string('professional_email');
			$table->date('birth');
			$table->string('phone');
			$table->string('mobile_phone');

			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}