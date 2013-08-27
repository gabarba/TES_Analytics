<?php 
class Customers extends Eloquent {
	
	public function orders() {
			return $this->hasMany('Orders');
		}

	//Return Customer data in array
	public function info() {
		$customerData = array(	'id' 			=> $this->id,
								'name' 			=> $this->name,
								'address 1' 	=> $this->address1,
								'address 2' 	=> $this->address2,
								'address 3' 	=> $this->address3,
								'city' 			=> $this->city,
								'state' 		=> $this->state,
								'postal code' 	=> $this->postal_code,
								'country code' 	=> $this->country_code,
								'phone' 		=> $this->phone,
								'email' 		=> $this->email
					);
		return $customerData;
	}
	public function calculateAvgOrderTotal() {
		$orders = $this->orders;
		$total = 0;
		foreach($orders as $order) {
			$total += $order->calculatedOrderTotal();
			echo $order->calculatedOrderTotal();
		}
		echo 'Total:'.$total.'<br/>';
		$average = $total/$orders->count();
		echo $average .'<br/>';
		$this->avg_order_total = $average;
		$this->save();
		return $average;
	}

	public function calculateLastOrderPlaced() {
		$orders = $this->orders;
		$newestOrderDate = null;

		foreach($orders as $order){
			if(strtotime($order->order_date) > strtotime($newestOrderDate)) {
				$newestOrderDate = $order->order_date;
			}
		}
		$this->last_purchase_date = $newestOrderDate;
		$this->save();
		return $newestOrderDate;
	}

	public function calculateHighestOrderTotal() {
		$orders = $this->orders;
		$total = 0;
		foreach($orders as $order) {
			if($order->calculatedOrderTotal() > $total) {
				$total = $order->calculatedOrderTotal();
			}
		}
		$this->highest_order_total = $total;
		$this->save();
		return $total;
	}

	public function calculateLowestOrderTotal() {
		$orders = $this->orders;
		$total = 20000;
		foreach($orders as $order) {
			if($order->calculatedOrderTotal() < $total) {
				$total = $order->calculatedOrderTotal();
			}
		}
		$this->lowest_order_total = $total;
		$this->save();
		return $total;
	}

	public function calculateAvgTimeBetweenOrders() {
		$orders = $this->orders;
		$previousDate = null;
		$diff = 0;
			foreach($orders as $order) {

				if($previousDate) {
					$diff += strtotime($order->order_date) - strtotime($previousDate);
					$previousDate = $order->order_date;
				}else {
					$previousDate = $order->order_date;
				}

			
		}
		$avgTime = $diff/($orders->count()-($orders->count() >1 ? 1: 0));
		$this->avg_time_between_orders = floor($avgTime/(60*60*24));
		$this->save();
		return $avgTime;
	}
}

?>