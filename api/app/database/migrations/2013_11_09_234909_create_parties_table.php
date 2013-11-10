<?php

use Illuminate\Database\Migrations\Migration;

class CreatePartiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('parties', function($table)
		{
			$table->increments('id');

			$table->string('name');
			$table->string('flag');

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
		Schema::drop('parties');
	}

}