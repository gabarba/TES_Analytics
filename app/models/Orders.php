<?php 
class Orders extends Eloquent {
	
public function items() {
		return $this->hasMany('OrderItem','id');
	};

public function customer() {
		return $this->belongsTo('Customers');
	};

}

?>