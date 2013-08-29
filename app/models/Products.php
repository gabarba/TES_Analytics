<?php 
class Products extends Eloquent {
	
public function itemsSold() {
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

	public function howManySoldIn($days = 90) {
		$date = new DateTime('today');
		$date->modify('-'.$days.' day');
		/*
		$orderItems = OrderItem::with(array('order'=> function($query) {
			$query->where('order_date','>=',$date->format('Y-m-d'));
		}))->where('products_id',$this->id)->sum('qty');
		*/
		$orderItems = OrderItem::where('products_id',$this->id)
								->join('orders','order_item.order_id','=','orders.id')
								->where('orders.order_date','>=',$date->format('Y-m-d'))
								->sum('qty');
		return $orderItems;
	}

	//Query Scope for filtering and sorting results
	public function scopeProductQuery($query,$filters = array(),$sortby = 'id')
	{
		$query->where('id','>',0);
		if(!empty($filters)) {
			foreach($filters as $key => $filter) {
				if($filter){
					$query->where($key,'LIKE','%'.$filter.'%');
				}				
			}
		}
		return $query->orderBy($sortby);
	}
}

?>