<?php 
class Customers extends Eloquent {
	
	public function orders() {
			return $this->hasMany('Orders');
		}

	//Return Customer data in array
	public function info() {
		$customerData = array(	'Id' 			=> $this->id,
								'Name' 			=> $this->name,
								'Address 1' 	=> $this->address1,
								'Address 2' 	=> $this->address2,
								'Address 3' 	=> $this->address3,
								'City' 			=> $this->city,
								'State' 		=> $this->state,
								'Postal Code' 	=> $this->postal_code,
								'Country Code' 	=> $this->country_code,
								'Phone' 		=> $this->phone,
								'Email' 		=> $this->email
					);
		return $customerData;
	}
}

?>