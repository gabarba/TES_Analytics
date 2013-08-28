<?php 
class Products extends Eloquent {
	
public function sold() {
			return $this->hasMany('OrderItem');
		}


//Return Product data in array
	public function info() {
		$productData = array(	'id' 			=> $this->id,
								'sku' 			=> $this->sku,
								'name'			=> $this->name,
								'image_url'		=> $this->image_url,
								'product_url'	=> $this->product_url,
								//Checks if product currently has special price
								'current_price' => ($this->current_price > $this->current_special & $this->current_special >0 ?$this->current_special: $this->current_price),
								'current_cost'	=> $this->current_cost,
								'manufacturer'	=> $this->manufacturer,
								'vendor'		=> $this->vendor,
								'type'			=> $this->type,
								'status'		=> $this->status,
								'updated_at'	=> $this->updated_at

					);
		return $productData;
	}
}

?>