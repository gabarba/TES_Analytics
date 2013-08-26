<?php 
class Orders extends Eloquent {
	
public function items() {
		return $this->hasMany('OrderItem','order_id');
	}

public function customer() {
		return $this->belongsTo('Customers');
	}

}

?>