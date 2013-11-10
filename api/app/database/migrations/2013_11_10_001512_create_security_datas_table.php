<?php

use Illuminate\Database\Migrations\Migration;

class CreateSecurityDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('security_datas', function($table)
		{
			$table->increments('id');

			$table->integer('security_id');
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
		Schema::drop('security_datas');
	}

}