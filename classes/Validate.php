<?php

	class Validate{
		private $_passed,
				$_errors = false,
				$_db;


		public function __construct(){
			$this->_db = new DB();
		}

		public function check($source, $items =array()){
			foreach ($items as $item => $rules) {
			 	foreach ($rules as $rule => $rule_value) {
			 		$value = trim($source[$item]);
			 		$item  =$this->_db->test_input($item);

			 	if ($rule === 'required' && empty($value)) {
			 		$this->addError("{$item} is required!");
			 	}else if(!empty($value)){
			 		switch ($rule) {
			 			case 'min':
			 				if (strlen($value) < $rule_value) {
			 					$this->addError("{$item} must be a minimum of {$rule_value}");
			 				}
			 				break;
			 			case 'max':
			 				if (strlen($value) > $rule_value) {
			 					$this->addError("{$item} must be a maximin of {$rule_value}");
			 				}
			 				break;
			 			case 'matches':
			 					if ($value != $source[$rule_value]) {
			 						$this->addError("{$rule_value} must match!");
			 					}
			 				break;
			 			case 'unique':
						$sql = "SELECT * FROM $rule_value WHERE $item = ?";
					  $stmt = $this->_db->prepare($sql);
					  $stmt->execute([$value]);
					  $result = $stmt->rowCount();
						if ($result) {
							$this->addError("{$item} already exists!");
						 }

			 				break;

			 		}
			 	}

			 	}
			 }

			 //check if error array is empty
			 if (empty($this->_errors)) {
			 	$this->_passed = true;
			 }
			 return $this;
		}

		//define add error
		private function addError($error){
			$this->_errors[] = $error;
		}
		public function errors(){
			return $this->_errors;
		}

		public function passed(){
			return $this->_passed;
		}

		//end of class
	}
