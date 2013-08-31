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
    	$hasFile = Input::hasFile('csv_import');
    	$delimiter = Input::get('delimiter','^');
    	$enclosure = Input::get('enclosure','|');

    	if($hasFile) {
    		$file = Input::file('csv_import');
    		$fileName = $file->getClientOriginalName();
    		//$extension = $file->getCientOriginaExtension();

    		$file->move($this->_importPath,$fileName);
    		$hasFile = $fileName;

    		$csvFile = new Keboola\Csv\CsvFile($this->_importPath.$fileName,$delimiter,$enclosure);

    		$rowCount = 0;
    		$importArray = array();
    		foreach($csvFile as $row) {
    			if($row[0] != 'order_id') 
    			{

    				$importArray[] = array(
    				'order_id' 			=> $row[0],
    				'order_date' 		=> $row[1],
    				'local_status' 		=> $row[2],
    				'online_status' 	=> $row[3],
    				'item_qty' 			=> $row[4],
    				'item_name' 		=> $row[5],
    				'item_sku' 			=> $row[6],
    				'item_total' 		=> $row[7],
    				'shipping_total' 	=> $row[8],
    				'ship_name' 		=> $row[9],
    				'ship_address1' 	=> $row[10],
    				'ship_address2' 	=> $row[11],
    				'ship_address3' 	=> $row[12],
    				'ship_city' 		=> $row[13],
    				'ship_state' 		=> $row[14],
    				'ship_postal_code' 	=> $row[15],
    				'ship_country_code' => $row[16],
    				'ship_phone' 		=> $row[17],
    				'ship_email' 		=> $row[18],
    				'bill_name' 		=> $row[19],
    				'bill_address1' 	=> $row[20],
    				'bill_address2' 	=> $row[21],
    				'bill_address3' 	=> $row[22],
    				'bill_city' 		=> $row[23],
    				'bill_state' 		=> $row[24],
    				'bill_postal_code' 	=> $row[25],
    				'bill_country_code' => $row[26],
    				'bill_phone' 		=> $row[27],
    				'bill_email' 		=> $row[28],
					'import_status' 	=> 0
    				);
    			}
    			$rowCount++;
    			// Import 100 rows at a time into import database reset count and import array afterwards
   				if($rowCount == 100) 
   				{
   					DB::table('import_orders')->insert($importArray);
   					$rowCount = 0;
   					$importArray = array();
   				}
    		}
    	//Import the rest of the rows into import database 
    	DB::table('import_orders')->insert($importArray);
    	};
    	

    	$this->layout->contents = View::make('import.index',compact('hasFile')); 
    }

}