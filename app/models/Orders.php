<?php 
class Orders extends Eloquent {
	
public function items() {
		return $this->hasMany('OrderItem');
	}

public function customer() {
		return $this->belongsTo('Customers');
	}

}

?>