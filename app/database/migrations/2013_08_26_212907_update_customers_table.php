<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customers', function(Blueprint $table)
		{
			$table->decimal('avg_order_total',6,2);
			$table->decimal('highest_order_total',6,2);
			$table->decimal('lowest_order_total',6,2);
			$table->decimal('avg_time_between_orders',6,2);
			$table->decimal('estimated_profit',6,2);
			$table->decimal('avg_shipping_cost',6,2);
			$table->decimal('estimate_total_shipping_cost',6,2);
			$table->date('last_purchase_date');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('customers', function(Blueprint $table)
		{
			$table->dropColumn('avg_order_total','highest_order_total','lowest_order_total','avg_time_between_orders','estimated_profit','avg_shipping_cost','estimate_total_shipping_cost','last_purchase_date');
		});
	}

}