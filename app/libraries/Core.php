<?php
/*
* App Core Class
* Creates url & loads core controller
* url format - /controller/method/params
*/

class Core
{
	protected $currentController = 'Pages';
	protected $currentMethod = 'index';
	protected $params = [];

	public function __construct(){
		//var_dump($this->getUrl());
		$url = $this->getUrl();
		//look in controllers for first value
		// .. we use cuz all pages routing into index.php
		if(file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
			//if exists, set as controller
			$this->currentController = ucwords($url[0]);
			unset($url[0]);
		}

		require_once '../app/controllers/'.$this->currentController.'.php';
		//Instantiate controller class
		$this->currentController = new $this->currentController;

		//check for method
		if (isset($url[1])){
			if(method_exists($this->currentController, $url[1])){
				$this->currentMethod = $url[1];
				unset($url[1]);
			}
		}

		//get params
		$this->params = $url ? array_values($url) : [];
		//$this->params = array_values($url) ?? []; хуйня

		//call a callback with array of params
		call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
	}
 
	public function getUrl(){
		if (isset($_GET['url'])){
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/', $url);
			return $url;
		}
	}
}