<?php 
class OrderItem extends Eloquent {

	protected $table = "order_item";

	public $timestamps = false;

	public function order() {
		return $this->belongsTo('Orders');
	}

	public function product() {
		return $this->belongsTo('Products');
	}

}

?>