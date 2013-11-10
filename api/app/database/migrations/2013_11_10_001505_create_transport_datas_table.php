<?php

use Illuminate\Database\Migrations\Migration;

class CreateTransportDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transport_datas', function($table)
		{
			$table->increments('id');

			$table->integer('transport_id');
			$table->integer('year');
			$table->float('percentage');

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
		Schema::drop('transport_datas');
	}

}