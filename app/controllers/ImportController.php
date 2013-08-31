<?php 

class ImportController extends BaseController {
	
	protected $layout = 'layouts.base';

    public function getIndex()
    {
       $this->layout->contents = View::make('import.index'); 
    }


    public function postIndex() 
    {

    }

}