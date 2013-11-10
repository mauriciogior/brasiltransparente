<?php

use Illuminate\Database\Migrations\Migration;

class CreatePoliticiansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('politicians', function($table)
		{
			$table->increments('id');

			$table->string('name');
			$table->integer('party_id');
			$table->string('role');
			$table->string('avatar');
			$table->integer('start');
			$table->integer('end');

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
		Schema::drop('politicians');
	}

}