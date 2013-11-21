<?php

class User{
	private $_id;
	private $_name;
	private $_email;
	private $_password;
	private $_salt;
	//todo private $_author;
		
	// Loads all user in the database
	public static function getAll(){
		$db = new DB();
		$queryResults = $db->selectAll("User");
		$users = array();
		foreach($queryResults as $qr){
			$user = new User();
			$user->fill($qr);
			$users[] = $user;
		}
		return $users;
	}
	
	// Loads a user using the ID
	// $user = User::withID(1)
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
	
	// Loads a user using its name
	// $user = User::withName("Usuario")
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
	
	// Sets all attributes using a QueryResult array
	public function fill(DBQueryResult $result){
		$this->_id = $result->id;
		$this->_name = $result->Name;
		$this->_email = $result->Email;
		$this->_password = $result->Password;
		$this->_salt = $result->Salt;
		$this->_premium = $result->Premium;
	}
	
	// Returns true if password matches the user password
	// if ($user->checkPassword("usuario_pass")
	public function checkPassword($password){
		if($this->hashPassword($password, $this->_salt) == $this->_password){
			return true;
		}
		return false;
	}
	
	// increases password security
	private function hashPassword($password, $salt){
		return hash(HASH_ALGO, $salt . $password . $salt);
	}

	public function __toString(){
		return "ID: " . $this->_id . 
		" / Name: " . $this->_name . 
		" / Email: " . $this->_email;
	}
	
	public function getID(){
		return $this->_id;
	}
	public function getName(){
		return $this->_name;
	}
	public function getEmail(){
		return $this->_email;
	}
	
}

class Offer{
	
	private $_id;
	private $_name;
	private $_category;
	private $_description;
	
	// Loads all offers in the database
	public static function getAll(){
		$db = new DB();
		$queryResults = $db->selectAll("Offer");
		$offers = array();
		foreach($queryResults as $qr){
			$offer = new Offer();
			$offer->fill($qr);
			$offers[] = $offer;
		}
		return $offers;
	}
	
	// Loads an offer using its ID
	// $offer = Offer::withID(1)
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
	
	// Loads an offer using its name
	// $offer = Offer::withName("Oferta1")
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

	// Sets all attributes using a QueryResult array
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
	
	public function getID(){
		return $this->_id;
	}
	public function getName(){
		return $this->_name;
	}
	public function getCategory(){
		return $this->_category;
	}
	public function getDescription(){
		return $this->_description;
	}
	
}

class Demand{
	
	private $_id;
	private $_name;
	private $_category;
	private $_description;
	
	// Loads all demands in the database
	public static function getAll(){
		$db = new DB();
		$queryResults = $db->selectAll("Demand");
		$demands = array();
		foreach($queryResults as $qr){
			$demand = new Demand();
			$demand->fill($qr);
			$demands[] = $demand;
		}
		return $demands;
	}
	
	// Loads a demand using its ID
	// $demand = Demand::withID(1)	
	public static function withID($id){
		$instance = new self();
		$instance->loadByID($id);
		return $instance;
	}
	
	private function loadByID($id){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("Demand", "id", $id);
		if($queryResults){
			$this->fill($queryResults[0]);
		} else {
			return false;
		}
	}
	// Loads a demand using its name
	// $demand = Demand::withName("Demanda1")		
	public static function withName($name){
		$instance = new self();
		$instance->loadByName($name);
		return $instance;
	}
	
	private function loadByName($name){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("Demand", "Name", $name);
		if($queryResults){
			$this->fill($queryResults[0]);
		} else {
			return false;
		}
	}

	// Sets all attributes using a QueryResult array
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
	
	public function getID(){
		return $this->_id;
	}
	public function getName(){
		return $this->_name;
	}
	public function getCategory(){
		return $this->_category;
	}
	public function getDescription(){
		return $this->_description;
	}
		
}

class Category{

	private $_id;
	private $_name;
	
	// Loads all categories in the database
	public static function getAll(){
		$db = new DB();
		$queryResults = $db->selectAll("Category");
		$categories = array();
		foreach($queryResults as $qr){
			$category = new Dategory();
			$category->fill($qr);
			$categories[] = $category;
		}
		return $demands;
	}
	
	// Loads a category using its ID
	// $category = Dategory::withID(1)	
	public static function withID($id){
		$instance = new self();
		$instance->loadByID($id);
		return $instance;
	}
	
	private function loadByID($id){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("Category", "id", $id);
		if($queryResults){
			$this->fill($queryResults[0]);
		} else {
			return false;
		}
	}
	// Loads a category using its name
	// $category = Category::withName("Demanda1")		
	public static function withName($name){
		$instance = new self();
		$instance->loadByName($name);
		return $instance;
	}
	
	private function loadByName($name){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("Category", "Name", $name);
		if($queryResults){
			$this->fill($queryResults[0]);
		} else {
			return false;
		}
	}

	// Sets all attributes using a QueryResult array
	public function fill(DBQueryResult $result){
		$this->_id = $result->id;
		$this->_name = $result->Name;
	}
	
	public function __toString(){
		return "ID: " . $this->_id . 
		" / Name: " . $this->_name;
	}
		public function getID(){
		return $this->_id;
	}
	public function getName(){
		return $this->_name;
	}
}
?>
