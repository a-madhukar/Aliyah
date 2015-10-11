<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prescriptions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('booking_id')->unsigned();
			$table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
			$table->string('sickness');
			$table->text('prescription');  
			$table->text('description'); 
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
		Schema::drop('prescriptions');
	}

}
