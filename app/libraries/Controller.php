<?php 
/* base controller
* loads the models and views
*/
class Controller
{
	public function model($model){
		require_once '../app/models/' . $model . '.php';
		//Instatiate model
		return new $model();
	}

	public function view($view, $data = []){
		//check for view file
		if (file_exists('../app/views/' . $view . '.php')){
			require_once '../app/views/' . $view . '.php';
		} else {
			//view does not exist 
			die('View does not exist');
		}
	}
}