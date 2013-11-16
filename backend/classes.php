<?php

class User{
	private $_id;
	private $_name;
	private $_email;
	private $_password;
	private $_salt;
		
	public static function withID($id){
		$instance = new self();
		$instance->loadByID($id);
		return $instance;
	}
	
	private function loadByID($id){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("User", "id", $id);
		if($queryResults){
			$this->fill($queryResults[0]);
		} else {
			return false;
		}
	}
	
	public static function withName($name){
		$instance = new self();
		$instance->loadByName($name);
		return $instance;
	}
	
	private function loadByName($name){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("User", "Name", $name);
		if($queryResults){
			$this->fill($queryResults[0]);
		} else {
			return false;
		}
	}
	
	public function fill(DBQueryResult $result){
		$this->_id = $result->id;
		$this->_name = $result->Name;
		$this->_email = $result->Email;
		$this->_password = $result->Password;
		$this->_salt = $result->Salt;
		$this->_premium = $result->Premium;
	}
	
	public function checkPassword($password){
		if($this->hashPassword($password, $this->_salt) == $this->_password){
			return true;
		}
		return false;
	}
	
	private function hashPassword($password, $salt){
		return hash(HASH_ALGO, $salt . $password . $salt);
	}

	public function __toString(){
		return "ID: " . $this->_id . 
		" / Name: " . $this->_name . 
		" / Email: " . $this->_email;
	}
}

class Offer{
	
	private $_id;
	private $_name;
	private $_category;
	private $_description;
	
		public static function withID($id){
		$instance = new self();
		$instance->loadByID($id);
		return $instance;
	}
	
	private function loadByID($id){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("Offer", "id", $id);
		if($queryResults){
			$this->fill($queryResults[0]);
		} else {
			return false;
		}
	}
	
	public static function withName($name){
		$instance = new self();
		$instance->loadByName($name);
		return $instance;
	}
	
	private function loadByName($name){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("Offer", "Name", $name);
		if($queryResults){
			$this->fill($queryResults[0]);
		} else {
			return false;
		}
	}

	public function fill(DBQueryResult $result){
		$this->_id = $result->id;
		$this->_name = $result->Name;
		$this->_category = $result->Category;
		$this->_description = $result->Description;
	}	
	public function __toString(){
		return "ID: " . $this->_id . 
		" / Name: " . $this->_name . 
		" / Category: " . $this->_category;
	}
}
?>
