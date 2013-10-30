<?php 

class ImportController extends BaseController {
	
	protected $layout = 'layouts.base';

	protected $_importPath = '/home/agena/www/analytics/public/csv_import/';

    public function getIndex()
    {
    	$hasFile = false;
       $this->layout->contents = View::make('import.index',compact('hasFile')); 
    }


    public function postIndex() 
    {

    	//Set execution timeout 
    	set_time_limit(0);
    	ini_set('memory_limit','500M');
    	$hasFile = Input::hasFile('csv_import');
    	//$hasFile = true;
    	$delimiter = Input::get('delimiter','^');
    	$enclosure = Input::get('enclosure','|');

    	if($hasFile) {
    		$file = Input::file('csv_import');
    		$fileName = $file->getClientOriginalName();
    		//$fileName = 'test_import.csv';
    		//$extension = $file->getCientOriginaExtension();

    		$file->move($this->_importPath,$fileName);
    		$hasFile = $fileName;

    		$csvFile = new Keboola\Csv\CsvFile($this->_importPath.$fileName,$delimiter,$enclosure);

    		$rowCount = 0;
    		$importArray = array();
            $errors = array();

    		foreach($csvFile as $key =>$row) {
    			if($row[0] != 'OrderID') 
    			{
                    
                    if(count($row) != 30 ) {
                        //$errors[] = 'Row '.$key;
                        echo 'Row '.$key. '<br>';
                        continue;
                    }

    				$importArray[] = array(
    				'order_id' 			=> $row[0],
    				'order_date' 		=> $row[1],
    				'local_status' 		=> $row[2],
    				'online_status' 	=> $row[3],
    				'item_qty' 			=> $row[4],
    				'item_name' 		=> $row[5],
                    'item_code'         => $row[6],
    				'item_sku' 			=> $row[7],
    				'item_total' 		=> $row[8],
    				'shipping_total' 	=> $row[9],
    				'ship_name' 		=> $row[10],
    				'ship_address1' 	=> $row[11],
    				'ship_address2' 	=> $row[12],
    				'ship_address3' 	=> $row[13],
    				'ship_city' 		=> $row[14],
    				'ship_state' 		=> $row[15],
    				'ship_postal_code' 	=> $row[16],
    				'ship_country_code' => $row[17],
    				'ship_phone' 		=> $row[18],
    				'ship_email' 		=> $row[19],
    				'bill_name' 		=> $row[20],
    				'bill_address1' 	=> $row[21],
    				'bill_address2' 	=> $row[22],
    				'bill_address3' 	=> $row[23],
    				'bill_city' 		=> $row[24],
    				'bill_state' 		=> $row[25],
    				'bill_postal_code' 	=> $row[26],
    				'bill_country_code' => $row[27],
    				'bill_phone' 		=> $row[28],
    				'bill_email' 		=> $row[29],
					'import_status' 	=> 0
    				);
    			}
    			$row = null;
    			unset($row);
    			$rowCount++;
    			// Import 150 rows at a time into import database reset count and import array afterwards
   				if($rowCount == 150) 
   				{
   					DB::table('import_orders')->insert($importArray);
   					$rowCount = 0;
   					unset($importArray);
   					gc_collect_cycles();
   					$importArray = array();
   				}
    		}
    	
    	
    	//Import the rest of the rows into import database 
    	DB::table('import_orders')->insert($importArray);
    	//Destroy CsvFile , $file, $importArray
    	$csvFile = null;
    	$file = null;
    	$importArray = null;
    	unset($csvFile,$file,$importArray);
    	gc_collect_cycles();
    	};
    	
        return Redirect::to('import/process-import');
    	//$this->layout->contents = View::make('import.index',compact('hasFile')); 
    }
public function postShipworks() 
    {

        //Set execution timeout 
        set_time_limit(0);
        ini_set('memory_limit','500M');
        $fileName = Input::get('import_file','latest_import.csv');
        //$hasFile = true;
        $delimiter = Input::get('delimiter','^');
        $enclosure = Input::get('enclosure','|');

        if($fileName) {

            $csvFile = new Keboola\Csv\CsvFile($this->_importPath.$fileName,$delimiter,$enclosure);

            $rowCount = 0;
            $importArray = array();
            $errors = array();

            foreach($csvFile as $key =>$row) {
                if($row[0] != 'OrderID') 
                {
                    
                    if(count($row) != 30 ) {
                        //$errors[] = 'Row '.$key;
                        echo 'Row '.$key. '<br>';
                        continue;
                    }

                    $importArray[] = array(
                    'order_id'          => $row[0],
                    'order_date'        => $row[1],
                    'local_status'      => $row[2],
                    'online_status'     => $row[3],
                    'item_qty'          => $row[4],
                    'item_name'         => $row[5],
                    'item_code'         => $row[6],
                    'item_sku'          => $row[7],
                    'item_total'        => $row[8],
                    'shipping_total'    => $row[9],
                    'ship_name'         => $row[10],
                    'ship_address1'     => $row[11],
                    'ship_address2'     => $row[12],
                    'ship_address3'     => $row[13],
                    'ship_city'         => $row[14],
                    'ship_state'        => $row[15],
                    'ship_postal_code'  => $row[16],
                    'ship_country_code' => $row[17],
                    'ship_phone'        => $row[18],
                    'ship_email'        => $row[19],
                    'bill_name'         => $row[20],
                    'bill_address1'     => $row[21],
                    'bill_address2'     => $row[22],
                    'bill_address3'     => $row[23],
                    'bill_city'         => $row[24],
                    'bill_state'        => $row[25],
                    'bill_postal_code'  => $row[26],
                    'bill_country_code' => $row[27],
                    'bill_phone'        => $row[28],
                    'bill_email'        => $row[29],
                    'import_status'     => 0
                    );
                }
                $row = null;
                unset($row);
                $rowCount++;
                // Import 150 rows at a time into import database reset count and import array afterwards
                if($rowCount == 150) 
                {
                    DB::table('import_orders')->insert($importArray);
                    $rowCount = 0;
                    unset($importArray);
                    gc_collect_cycles();
                    $importArray = array();
                }
            }
        
        
        //Import the rest of the rows into import database 
        DB::table('import_orders')->insert($importArray);
        //Destroy CsvFile , $file, $importArray
        $csvFile = null;
        $file = null;
        $importArray = null;
        unset($csvFile,$file,$importArray);
        gc_collect_cycles();
        };
        
        return Redirect::to('import/process-import');
        //$this->layout->contents = View::make('import.index',compact('hasFile')); 
    }
 public function getProcessImport()
    {
        //Set execution timeout 
        set_time_limit(0);
        ini_set('memory_limit','500M');


        $importOrders = ImportOrders::where('import_status',0)->take(5000)->get();

        foreach($importOrders as $order) {

            //Find Customer by email - if it does not exist create new customer
            $customer  = Customers::where('email',$order->bill_email)->first();

            if(!$customer) {
                $customer = new Customers;
                $customer->name                 = $order->bill_name;
                $customer->email                = $order->bill_email;
                $customer->address1             = $order->bill_address1;
                $customer->address2             = $order->bill_address2;
                $customer->address3             = $order->bill_address3;
                $customer->city                 = $order->bill_city;
                $customer->state                = $order->bill_state;
                $customer->postal_code          = $order->bill_postal_code;
                $customer->country_code         = $order->bill_country_code;
                $customer->phone                = $order->bill_phone;
                $customer->save();
            }
            //Find Order by shipworks order_id - if it does not exist create new order under customer 
            $newOrder = Orders::where('shipworks_order_id',$order->order_id)->first();

            if(!$newOrder) {
                $newOrder = new Orders;
                $newOrder->shipworks_order_id        = $order->order_id;
                $newOrder->order_date                = date('Y-m-d',strtotime($order->order_date));

                $newOrder->ship_name                 = $order->ship_name;
                $newOrder->ship_address1             = $order->ship_address1;
                $newOrder->ship_address2             = $order->ship_address2;
                $newOrder->ship_address3             = $order->ship_address3;
                $newOrder->ship_city                 = $order->ship_city;
                $newOrder->ship_state                = $order->ship_state;
                $newOrder->ship_postal_code          = $order->ship_postal_code;
                $newOrder->ship_country_code         = $order->ship_country_code;
                $newOrder->ship_phone                = $order->ship_phone;

                $newOrder->bill_name                 = $order->bill_name;
                $newOrder->bill_address1             = $order->bill_address1;
                $newOrder->bill_address2             = $order->bill_address2;
                $newOrder->bill_address3             = $order->bill_address3;
                $newOrder->bill_city                 = $order->bill_city;
                $newOrder->bill_state                = $order->bill_state;
                $newOrder->bill_postal_code          = $order->bill_postal_code;
                $newOrder->bill_country_code         = $order->bill_country_code;
                $newOrder->bill_phone                = $order->bill_phone;
                $newOrder->status                    = $this->resolveStatus($order->local_status, $order->online_status);

                //Associate and Save Order to Customer
                $newOrder = $customer->orders()->save($newOrder);                
            }

            $orderItem = OrderItem::where('shipworks_order_id',$order->order_id)->where('sku',$this->resolveSku($order->item_code, $order->item_sku))->first();

          

            if(!$orderItem and $this->resolveSku($order->item_code, $order->item_sku)) {
                $orderItem = new OrderItem;

                $orderItem->shipworks_order_id        = $order->order_id;
                $orderItem->name                      = $order->item_name;
                $orderItem->sku                       = $this->resolveSku($order->item_code, $order->item_sku);
                $orderItem->qty                       = $order->item_qty;
                $orderItem->unit_price                = ($order->item_total/$order->item_qty);
                $orderItem->total                     = $order->item_total;

                $orderItem = $newOrder->items()->save($orderItem);
                
            }
            // Map Order item to Product 
            $product = Products::where('sku',$this->resolveSku($order->item_code, $order->item_sku))->first();
            if($product) {
                $product->itemsSold()->save($orderItem);
                $product->save();
                $orderItem->product_mapped = 1;
                $orderItem->save();
            }
            // Mark Import Status Complete
            $order->import_status = 1;
            $order->save();
        }


        //Log::error('Message');
        $hasFile = 'ProcessComplete';
       $this->layout->contents = View::make('import.index',compact('hasFile')); 
    }

    //Find return an Agena Sku not eBay item number
    private function resolveSku($item_code,$item_sku) {

           if(strpos($item_sku,"-") !== false) {
                return $item_sku;
            };
            if(strpos($item_code,"-") !== false) {
                return $item_code;
            }
            
        }
    //Find whether or not the order is cancelled
     private function resolveStatus($local_status,$online_status) {
        if($online_status == 'Canceled') {
            return false;
        }
        if($local_status == 'Cancelled') {
            return false;
        }
        return true;
        }
}