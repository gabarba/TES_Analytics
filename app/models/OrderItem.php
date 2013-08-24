<?php 
class OrderItem extends Eloquent {

	protected $table = "order_item";

	public function order() {
		return $this->belongsTo('Orders');
	};

}

?>