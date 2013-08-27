<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sku')->unique();
			$table->string('name');
			$table->string('image_url');
			$table->string('product_url');
			$table->decimal('current_price',6,2);
			$table->decimal('current_cost',6,2);
			$table->decimal('current_special',6,2);
			$table->string('manufacturer');
			$table->string('vendor');
			$table->string('type');
			$table->boolean('status');
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
		Schema::drop('products');
	}

}
