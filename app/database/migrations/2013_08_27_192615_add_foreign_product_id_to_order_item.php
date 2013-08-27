<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignProductIdToOrderItem extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('order_item', function(Blueprint $table)
		{
			$table->integer('products_id')->after('sku')->unsigned();
			$table->foreign('products_id')->references('id')->on('products');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('order_item', function(Blueprint $table)
		{
			$table->dropForeign('order_item_products_id_foreign');
		});
	}

}