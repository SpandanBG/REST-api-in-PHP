<?php
require_once 'rest.php';
require_once 'getdb.php';

/*
 REST Handler class
*/
class Handler{
	// REST object
	private $rest;
	
	public function __construct(){
		$this->rest = new REST();
	}
	
	/*
	 The method checks if a function exists and gets the json dataset to be sent
	*/
	public function run(){
		$_func = $this->rest->get_function();
		$_dataset = $this->rest->get_data();
		if(function_exists($_func)){
			$this->rest->respond($_func($this->rest->get_http(),$_dataset,$this->rest->get_http_scheme()),200);
		} else {
			$this->rest->respond(array('dataset'=>"$_func"),404);
		}
	}
}

// DEMO method to retrive blog dataset
function blog($http, $ds, $https){
	if($http==='POST' and $https === 'https'){
		$bname = @$ds['bname'];
		if(!empty($bname)){
			$db = new GetDB("sudocoding");
			$db->setcollection('blogs');
			$set = $db->getdata(array('title'=>"$bname"),array(),array(),null,null)->getNext();
			return $set;
		} else {
			return null;
		}
	} else {
		return null;
	}
}

// Starting the handler
$rest = new Handler();
$rest->run();
?>