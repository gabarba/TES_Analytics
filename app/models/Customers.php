<?php 
class Customers extends Eloquent {
	
public function orders() {
		return $this->hasMany('Orders');
	};
}

?>