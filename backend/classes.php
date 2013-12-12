<?php

class User{
	private $_id;
	private $_name;
	private $_email;
	private $_password;
	private $_salt;
	
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
	private function fill(DBQueryResult $result){
		$this->_id = $result->id;
		$this->_name = $result->Name;
		$this->_email = $result->Email;
		$this->_password = $result->Password;
		$this->_salt = $result->Salt;
		$this->_premium = $result->Premium;
	}
	
	public function save(){
		$db = new DB();
		$queryResults = $db->insertUser($this->_name, $this->_email, $this->_password, $this->_salt, $this->_premium);
		return $queryResults;
	}
	
	public function update(){
		$db = new DB();
		$queryResults = $db->updateUser($this->_name, $this->_email, $this->_password, $this->_salt, $this->_premium);
		return $queryResults;
	}
	
	public function delete(){
		$db = new DB();
		$queryResults = $db->deleteUser($this->_name);
		return $queryResults;
	}
		
	// Returns true if password matches the user password
	// if ($user->checkPassword("usuario_pass"))
	public function checkPassword($password){
		if($this->hashPassword($password, $this->_salt) == $this->_password){
			return true;
		}
		return false;
	}
	
	// increases password security
	public static function hashPassword($password, $salt){
		return hash(HASH_ALGO, $salt . $password . $salt);
	}
	
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

	public function getID(){
		return $this->_id;
	}
	public function getName(){
		return $this->_name;
	}
	public function getEmail(){
		return $this->_email;
	}
	public function getPremium(){
		return $this->_premium;
	}
	public function setName($name){
		$this->_name = $name;
	}
	public function setEmail($email){
		$this->_email = $email;
	}	
	public function setPassword($password){
		$salt = md5( time() );
		$password = User::hashPassword($password, $salt);
		$this->_password = $password;
		$this->_salt = $salt;
	}	
	public function setPremium($premium){
		$this->_premium = $premium;
	}


	public function __toString(){
		return "ID: " . $this->_id . 
		" / Name: " . $this->_name . 
		" / Email: " . $this->_email;
	}
		
}

// A service an be either an offer or a demand.
class Service{
	
	// Constants to identify the type of service.
	// $offerService = new Service(Service::TYPE_OFFER);
	const TYPE_OFFER = "Offer";
	const TYPE_DEMAND = "Demand";
	
	private $_id;
	private $_name;
	private $_category;
	private $_description;
	private $_user;
	private $_serviceType;
		
	function __construct($serviceType){
		$this->_serviceType = $serviceType;
	}
		
	// Loads a service using its ID
	// $service = Service::withID(1)
	public static function withID($id, $servicetype){
		$instance = new self($servicetype);
		$instance->loadByID($id);
		return $instance;
	}
	
	private function loadByID($id){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("Service", "id", $id);
		if($queryResults){
			$this->fill($queryResults[0]);
		} else {
			return false;
		}
	}
	
	// Loads an service using its name
	// $service = Service::withName("Oferta1")
	public static function withName($name,$servicetype ){
		$instance = new self($servicetype);
		$instance->loadByName($name);
		return $instance;
	}
	
	private function loadByName($name){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("Service", "Name", $name);
		if($queryResults){
			$this->fill($queryResults[0]);
		} else {
			return false;
		}
	}

    // Loads an service using his user
    public static function withUser($user,$servicetype ){
        $instance = new self($servicetype);
        $instance->loadByUser($user);
        return $instance;
    }

    private function loadByUser($user){
        $db = new DB();
        $queryResults = $db->selectTableWithColumn("Service", "User", $user);
        if($queryResults){
            $this->fill($queryResults[0]);
        } else {
            return false;
        }
    }

	// Sets all attributes using a QueryResult array
	private function fill(DBQueryResult $result){
		$this->_id = $result->id;
		$this->_name = $result->Name;
		$this->_description = $result->Description;
		$this->_serviceType = $result->ServiceType;
		$this->_category = Category::withID($result->Category_id);
		$this->_user = User::withID($result->User_id);		
	}

	public function save(){
		$db = new DB();
		$queryResults = $db->insertService($this->_name, $this->_description, $this->_serviceType, $this->_category->getID(), $this->_user->getID());
		return $queryResults;
	}
	
	public function update(){
		$db = new DB();
		$queryResults = $db->updateService($this->_name, $this->_description, $this->_serviceType, $this->_category->getID(), $this->_user->getID());
		return $queryResults;
	}
	
	public function delete(){
		$db = new DB();
		$queryResults = $db->deleteService($this->_name);
		return $queryResults;
	}		

    //loads all services posted by one user

    public static function getAllWithUser($user){
        $db = new DB();
        $queryResults = $db->selectTableWithColumn("Service", "User", $user);
        $services = array();
        foreach($queryResults as $qr){
            $service = new Service($qr->ServiceType);
            $service->fill($qr);
            $services[] = $service;
        }
        return $services;
    }

    // Loads all services in the database based on the service type
	public static function getAllWithServiceType($serviceType){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("Service", "ServiceType", $serviceType);
		$services = array();
		foreach($queryResults as $qr){
			$service = new Service($serviceType);
			$service->fill($qr);
			$services[] = $service;
		}
		return $services;
	}
	// Loads all services
	public static function getAll(){
		$db = new DB();
		$queryResults = $db->selectAll("Service");
		$services = array();
		foreach($queryResults as $qr){
			$service = new Service($qr->ServiceType);
			$service->fill($qr);
			$services[] = $service;
		}
		return $services;
	}	
	public function getID(){
		return $this->_id;
	}
	public function getName(){
		return $this->_name;
	}
	public function getDescription(){
		return $this->_description;
	}
	public function getServiceType(){
		return $this->_serviceType;
	}
	public function getCategory(){
		return $this->_category;
	}	
	public function getUser(){
		return $this->_user;	
	}
	
	public function setName($name){
		$this->_name = $name;;
	}
	public function setDescription($description){
		$this->_description = $description;
	}	
	public function setCategory($category){
		$this->_category = $category;
	}
	public function setUser($user){
		$this->_user = $user;	
	}
		
	public function __toString(){
		return "ID: " . $this->_id . 
		" / Type: " . $this->_serviceType .
		" / Name: " . $this->_name . 
		" / Category: " . $this->_category->getName() .
		" / User: " . $this->_user->getName();
	}
		
}

class Category{

	private $_id;
	private $_name;
	
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
	private function fill(DBQueryResult $result){
		$this->_id = $result->id;
		$this->_name = $result->Name;
	}
	
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
	public function getID(){
		return $this->_id;
	}
	public function getName(){
		return $this->_name;
	}
	public function __toString(){
		return "ID: " . $this->_id . 
		" / Name: " . $this->_name;
	}	
}

////////////////////////// MESSAGES

class Message{
	private $_id;
	private $_subject;
	private $_body;
	private $_read;
	private $_date;
	private $_sender;
	private $_receiver;
	
	// Carga un mensaje usando su id
	// $message = Message::withID(1)
	public static function withID($id){
		$instance = new self();
		$instance->loadByID($id);
		return $instance;
	}
	
	private function loadByID($id){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("Message", "id", $id);
		if($queryResults){
			$this->fill($queryResults[0]);
		} else {
			return false;
		}
	}
	
	// Carga un mensaje usando su subject
	// $message = Message::withName("subject")
	public static function withSubject($subject){
		$instance = new self();
		$instance->loadBySubject($subject);
		return $instance;
	}
	
	private function loadBySubject($subject){
		$db = new DB();
		$queryResults = $db->selectTableWithColumn("Message", "Subject", $subject);
		if($queryResults){
			$this->fill($queryResults[0]);
		} else {
			return false;
		}
	}
	
	

	// Sets all attributes using a QueryResult array
	private function fill(DBQueryResult $result){
		$this->_id = $result->id;
		$this->_subject = $result->Subject;
		$this->_body = $result->Body;
		$this->_read = $result->Read;
		$this->_date = $result->Date;
		$this->_sender = $result->Sender;
		$this->_receiver = $result->Receiver;
	}
	
	public function save(){
		$db = new DB();
		$queryResults = $db->insertMessage($this->_subject, $this->_body, $this->_read, $this->_date, $this->_sender, $this->_receiver);
		return $queryResults;
	}
	
	public function update(){
		$db = new DB();
		$queryResults = $db->updateMessage($this->_subject, $this->_body, $this->_read, $this->_date, $this->_sender, $this->_receiver);
		return $queryResults;
	}
	
	public function delete(){
		$db = new DB();
		$queryResults = $db->deleteMessage($this->_id);
		return $queryResults;
	}
		
	// Loads all messages in the database
	public static function getAll(){
		$db = new DB();
		$queryResults = $db->selectAll("Message");
		$messages = array();
		foreach($queryResults as $qr){
			$message = new Message();
			$message->fill($qr);
			$messages[] = $message;
		}
		return $messages;
	}

	public static function getMessagesByUserID($userID) {
		$db = new DB();
		$messages = $db->selectUserMessages($userID);
		return $messages;
	}
	public static function getMessagesByUserName($username) {
		$user = User::withName($username);
		return getAllByUserID($user->getID());
	}
	
	public function getID(){
		return $this->_id;
	}
	public function getSubject(){
		return $this->_subject;
	}
	public function getBody(){
		return $this->_body;
	}
	public function getRead(){
		return $this->_read;
	}
	public function getDate(){
		return $this->_date;
	}
	public function getSender(){
		return $this->_sender;
	}
	public function getReceiver(){
		return $this->_receiver;
	}
	
	public function setSubject($subject){
		$this->_subject = $subject;
	}
	public function setBody($body){
		$this->_body = $body;
	}
	public function setRead($read){
		$this->_read = $read;
	}
	public function setDate($date){
		$this->_date = $date;
	}
	public function setSender($sender){
		$this->_sender = $sender;
	}
	public function setReceiver($receiver){
		$this->_receiver = $receiver;
	}

	public function __toString(){
		return "ID: " . $this->_id . 
		" / subject: " . $this->_subject . 
		" / body: " . $this->_body .
		" / read: " . $this->_read . 
		" / Fecha envio: " . $this->_date .
		" / sender: " . $this->_sender . 
		" / receiver: " . $this->_receiver;
		
	}
		
}



?>
