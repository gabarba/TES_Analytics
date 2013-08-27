<?php 
class Orders extends Eloquent {
	
public function items() {
		return $this->hasMany('OrderItem','order_id');
	}

public function customer() {
		return $this->belongsTo('Customers','customers_id');
	}
public function calculatedOrderTotal() {
		$items = $this->items;
		$total = 0;
		foreach($items as $item) {
			$total += $item->total;
		}
		return $total;
	}
public function calculatedQtyTotal() {
		$items = $this->items;
		$total = 0;
		foreach($items as $item) {
			$total += $item->qty;
		}
		return $total;
	}

}

?>