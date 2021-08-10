<?php

	class DB{
		//properties
		 public $_pdo;


			//connect to database
		 public function __construct(){
		 	try{

		 	$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host'). ';dbname=' .Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
		 	}catch(PDOException $e){
		 		die($e->getMessage());
		 	}
		return $this->_pdo;
		 }
		 		 	//create instance to check database connection


 public function test_input($data){
			 $data = trim($data);
			 $data = stripslashes($data);
			 $data = htmlentities($data, ENT_QUOTES, 'UTF-8');
			 $data = htmlspecialchars($data);
			 $data = strip_tags($data);
			 return $data;

		 }
	 //error message

	 public function showMessage($type = 'success', $message, $ico){
	return '
	<div id="regError" class="alert alert-'.$type.' alert-dismissible">
	<button type="button" class="close" data-dismiss="alert">
					 &times;
					 </button>
		<i class="fa fa-'.$ico.'"></i>&nbsp;
		<span>'.$message.'</span>
	</div>';
	 }


//end of class
	}
