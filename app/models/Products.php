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
								->where('orders.status',1)
								->sum('qty');
		return $orderItems;
	}

	public function earnedBetween($startDate, $endDate) {

		$start = new DateTime($startDate);
		$end   = new DateTime($endDate);

		/*
		$orderItems = OrderItem::with(array('order'=> function($query) {
			$query->where('order_date','>=',$date->format('Y-m-d'));
		}))->where('products_id',$this->id)->sum('qty');
		*/
		$orderItems = OrderItem::where('products_id',$this->id)
								->join('orders','order_item.order_id','=','orders.id')
								//->whereBetween('orders.order_date',array($start->format('Y-m-d'),$end->format('Y-m-d')))
								->whereBetween('orders.order_date',array($startDate,$endDate))
								->where('orders.status',1)
								->sum('total');
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

	public static function scopeReturnSalesCount($query, $days = array())
	{
		if(empty($days))
		{
			$days = array(
					7 =>'Sold in 7 Days',
					14 =>'Sold in 14 Days',
					30 =>'Sold in 30 Days',
					90 =>'Sold in 90 Days',
					180 =>'Sold in 180 Days',
					365 =>'Sold in 1 Year',
					 0  => 'Sold All Time'
				);
		}

		if(!isset($days[0]))
		{
			$days[0] = 'Sold All Time';
		}

		$rawSQL = "test_products.id,test_products.sku,";
		//$rawSQL = "";
		foreach($days as $day=>$label)
		{
			if($day == 0)
			{
				$rawSQL .= "SUM(CASE WHEN test_orders.order_date <= '". \Carbon\Carbon::now()->subDays($day)->format('Y-m-d')."' THEN test_order_item.qty ELSE 0 END) as '".$label."'";
				continue;
			}
			$rawSQL .= "SUM(CASE WHEN test_orders.order_date >= '". \Carbon\Carbon::now()->subDays($day)->format('Y-m-d')."' THEN test_order_item.qty ELSE 0 END) as '".$label."',";
		}
		
			$query->select(DB::raw($rawSQL))
			->join('order_item','products.id','=','order_item.products_id')
			->join('orders','order_item.order_id','=','orders.id')
			->where('orders.status',1)
			->groupBy('products.sku')
			->orderBy('products.sku', 'asc');
			/*
			return $query = DB::table('products')
			->select(DB::raw($rawSQL))
			->join('order_item','products.id','=','order_item.products_id')
			->join('orders','order_item.order_id','=','orders.id')
			->where('orders.status',1)
			->groupBy('products.sku')
			->orderBy('products.sku', 'asc');
			*/
			
	}
	
	
}

?>