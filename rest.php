<?php
/*
 @author: Spandan Buragohain
 REST class to handle all the requests and response
*/
class REST {
	
	private $_inpst = array();							// array of received inputs
	private $_func, $_http, $_http_scheme; // $_func -> page tried to access, $_http -> the http request method, $_http_scheme -> http/https
	
	// Constructor to grab the http method, http scheme, the page access and the form data
	public function __construct(){
		$this->_http = $_SERVER['REQUEST_METHOD'];
		$this->_http_scheme = $_SERVER['REQUEST_SCHEME'];
		$this->inprc();
	}

	// This method returns the page tired to access
	public function get_function(){
		return $this->_func;
	}

	// This method returns the set of form data
	public function get_data(){
		return $this->_inpst;
	}

	// This method returns the http request method
	public function get_http(){
		return $this->_http;
	}

	// This method is responsible to return the http scheme
	public function get_http_scheme(){
		return $this->_http_scheme;
	}

	/*
	 The method returns the json object of the dataset
	 Also sets the appropriate header
	*/
	public function respond($dataset, $_code){
		header("HTTP/1.1 ".$_code." ".$this->gstat_msg($_code));
		header("Content-Type: application/json");
		echo json_encode($dataset);
	}

	// This method is responsible to extract the form data into an array
	private function inprc(){
		$this->_func = basename($this->validate(@$_REQUEST['rquest']), ".php");
		if($this->_func===null){
			$this->respond(null,500);
		} else {
			switch($this->get_http()){
				case 'POST':
					$this->_inpst = $this->scrapinp(@$_POST);
					break;
				case 'GET':
					$this->_inpst = $this->scrapinp(@$_GET);
					break;
				default:
					$this->respond(null,500);
			}
		}
	}
	
	// This mehtod words in coordination with the inprc() method
	private function scrapinp($dataset){
		$inps = array();
		if(is_array($dataset)){
			foreach($dataset as $key => $val){
				if($key !== 'rquest'){
					$inps[$key] = $this->scrapinp($val);
				}
			}
			return $inps;
		} else {
			return $this->validate($dataset);
		}
	}
	
	// This method stips the data of html chars
	private function validate($data){
		if(is_array($data)){
			return null;
		}
		$data = stripslashes($data);
		$data = trim($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	// This method returns the string of the response code
	private function gstat_msg($_code){
		$status = array(
			100 => 'Continue',  
			101 => 'Switching Protocols',  
			200 => 'OK',
			201 => 'Created',  
			202 => 'Accepted',  
			203 => 'Non-Authoritative Information',  
			204 => 'No Content',  
			205 => 'Reset Content',  
			206 => 'Partial Content',  
			300 => 'Multiple Choices',  
			301 => 'Moved Permanently',  
			302 => 'Found',  
			303 => 'See Other',  
			304 => 'Not Modified',  
			305 => 'Use Proxy',  
			306 => '(Unused)',  
			307 => 'Temporary Redirect',  
			400 => 'Bad Request',  
			401 => 'Unauthorized',  
			402 => 'Payment Required',  
			403 => 'Forbidden',  
			404 => 'Not Found',  
			405 => 'Method Not Allowed',  
			406 => 'Not Acceptable',  
			407 => 'Proxy Authentication Required',  
			408 => 'Request Timeout',  
			409 => 'Conflict',  
			410 => 'Gone',  
			411 => 'Length Required',  
			412 => 'Precondition Failed',  
			413 => 'Request Entity Too Large',  
			414 => 'Request-URI Too Long',  
			415 => 'Unsupported Media Type',  
			416 => 'Requested Range Not Satisfiable',  
			417 => 'Expectation Failed',  
			500 => 'Internal Server Error',  
			501 => 'Not Implemented',  
			502 => 'Bad Gateway',  
			503 => 'Service Unavailable',  
			504 => 'Gateway Timeout',  
			505 => 'HTTP Version Not Supported'
		);
		return $status[$_code]?$status[$_code]:$status[500];
	}
}
?>