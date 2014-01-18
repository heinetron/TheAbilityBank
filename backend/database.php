<?php

class DB {
	private function dbconnect(){
		// Create connection
		$connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
		// If connection fails, die
		or die ("<br/>Could not connect to MySQL server");
		// If not, select our database
		mysql_select_db(DB_NAME,$connection)
    	or die ("<br/>Could not select the indicated database");
			
		return $connection;
	}
	
	private function query($sql){
		
	$this->dbconnect();
    $res = mysql_query($sql);
	//echo "</br></br>";
	//echo $sql;
    if ($res){
      if (strpos($sql,'SELECT') === false){
        return true;
      }
    }
    else{
      if (strpos($sql,'SELECT') === false){
        return false;
      }
      else{
        return null;
      }
    }

    $results = array();

    while ($row = mysql_fetch_array($res))	{
		$queryResult = new DBQueryResult();
		foreach ($row as $key=>$value){
			$queryResult->$key = $value;
		}
		$results[] = $queryResult;
    }
    return $results;				
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// Selects all rows from a table
	public function selectAll($tableName){
		$sql = "SELECT * FROM $tableName";
		return $this->query($sql);
	}
	
	// Selects a single cell
	public function selectTableWithColumn($tableName, $columnName, $columnValue){
		$sql = "SELECT * FROM $tableName WHERE $columnName = \"$columnValue\"";
		return $this->query($sql);
	}
	
	public function clearTable($tableName){
		$sql="DELETE FROM $tableName";
		
		// Execute query
		$result = $this->query($sql);
		if($result){
			//echo "Deleted all records from $tableName";
		}
		else{
			//echo "Could not delete records from $tableName";
		}
	}

//    public function deleteTable($tableName){
//        $sql="DROP TABLE $tableName";
//
//        // Execute query
//        $result = $this->query($sql);
//        if($result){
//            //echo "Drop $tableName";
//        }
//        else{
//            //echo "Could not drop $tableName";
//        }
//    }
	
	public function printTable($tableName){
		$results = $this->query("SELECT * FROM $tableName");
		
		if($results){
			var_dump($results);
		}
	}
	

	/////////////////////////////////////////////// USER ////////////////////////////////////////////////

	public function createUserTable()
	{
		// Create table
		$sql="CREATE TABLE IF NOT EXISTS User(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), Name VARCHAR(40) NOT NULL, UNIQUE(Name), Email VARCHAR(40) NOT NULL, Password VARCHAR(120) NOT NULL, Salt VARCHAR(120) NOT NULL, Premium BOOL NOT NULL, IsAdmin BOOL NOT NULL, Valoraciones INT NOT NULL, BanDate INT NOT NULL);";

		// Execute query
		if($this->query($sql)){
			//echo "Table created successfully";
		}
		else{
			//echo "Error creating User table: " . mysql_error();
		}
	}
	
	public function insertUser($name, $email, $password, $salt, $premium, $isAdmin, $valoraciones, $banDate)
	{
		// Insert data		
		$sql = "INSERT INTO `User`(`Name`, `Email`, `Password`, `Salt`, `Premium`, `IsAdmin`, `Valoraciones`, `BanDate`) VALUES ('$name', '$email', '$password','$salt','$premium', '$isAdmin', '$valoraciones', '$banDate')";
		
		if(!$this->query($sql)){
			//echo "Error inserting user: " . mysql_error();
			return false;
		}
		return true;
	}
	public function updateUser($name, $email, $password, $salt, $premium, $isAdmin, $valoraciones, $banDate)
	{
		$sql = "UPDATE `User` SET `Email`=\"$email\",`Password`=\"$password\",`Salt`=\"$salt\",`Premium`=\"$premium\",`IsAdmin`=\"$isAdmin\",`Valoraciones`=\"$valoraciones\",`BanDate`=\"$banDate\" WHERE Name=\"$name\"";
		if(!$this->query($sql)){
			//echo "Error updating user: " . mysql_error();
			return false;
		}		
		return true;
	}
	
	public function deleteUser($name){
		$sql = "DELETE FROM `User` WHERE `Name` = \"$name\"";
		if(!$this->query($sql)){
			//echo "Error deleting user: " . mysql_error();
			return false;
		}		
		return true;		
	}
	
	/////////////////////////////////////////////// SERVICE ////////////////////////////////////////////////

	public function createServiceTable()
	{
		// Create table
		$sql="CREATE TABLE `Service` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`Name` varchar(40) NOT NULL,
							`Description` varchar(120) DEFAULT NULL,
							`ServiceType` char(6) NOT NULL DEFAULT 'Offer',
							`Category_id` int(11) NOT NULL,
							`User_id` int(11) NOT NULL,
							PRIMARY KEY (`id`),
							UNIQUE KEY `Name` (`Name`)
							) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8";

		// Execute query
		if($this->query($sql)){
			//echo "Table created successfully";
		}
		else{
			//echo "Error creating service table: " . mysql_error();
		}
	}

	public function insertService($name, $description, $serviceType, $category_id,  $user_id)
	{
		// Insert data
		$sql = "INSERT INTO `Service`(`Name`, `Description`, `ServiceType`, `Category_id`, `User_id`) VALUES  ('$name', '$description', '$serviceType' ,'$category_id', '$user_id')";
		//echo $sql;
		if(!$this->query($sql)){
			//echo "Error inserting service: " . mysql_error();
		}
	}

	public function updateService($name, $description, $serviceType, $category_id, $user_id)
	{
		$sql = "UPDATE `Service` SET `Description`=\"$description\",`ServiceType`=\"$serviceType\",`Category_id`=\"$category_id\",`User_id`=\"$user_id\" WHERE Name=\"$name\"";
		if(!$this->query($sql)){
			//echo "Error updating service: " . mysql_error();
			return false;
		}		
		return true;
	}
	
	public function deleteService($name){
		$sql = "DELETE FROM `Service` WHERE `Name` = \"$name\"";
		if(!$this->query($sql)){
			//echo "Error deleting service: " . mysql_error();
			return false;
		}		
		return true;		
	}
	
	public function selectUserServices($userID) {
		$results = $this->query("SELECT * FROM `Service` WHERE `User_id` = '$userID'");
		return $results;
	}
	/////////////////////////////////////////////// MESSAGES ////////////////////////////////////////////////

	public function createMessageTable()
	{
		// Create message
		$sql = "CREATE TABLE `Message` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			 `Subject` varchar(200) NOT NULL,
			 `Body` varchar(1000) NOT NULL,
			 `Read` int(11) NOT NULL,
			 `Date` int(11) NOT NULL,
			 `Sender` int(11) NOT NULL,
			 `Receiver` int(11) NOT NULL,
			 `Notification`  int(11) NOT NULL,
			 PRIMARY KEY (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8";
		// Execute query
		if($this->query($sql)){
//			echo "Table created successfully";
		}
		else{
//			echo "Error creating Message table: " . mysql_error();
		}
	}
	
	public function insertMessage($subject, $body, $read, $date, $sender, $receiver, $notification)
	{
		// Insert data		
		$sql = "INSERT INTO `Message`(`subject`, `body`, `read`, `date`, `sender`, `receiver`, `notification` ) VALUES ('$subject', '$body', '$read', '$date', '$sender', '$receiver', '$notification')";
		
		if(!$this->query($sql)){
			echo "Error inserting message: " . mysql_error();
			return false;
		}
		// echo "Row inserted";
		return true;
	}
	public function updateMessage($id, $subject, $body, $read, $date, $sender, $receiver, $notification)
	{
		$sql = "UPDATE `Message` SET `subject`='$subject',`body`='$body',`read`='$read',`date`='$date',`sender`='$sender',`receiver`='$receiver', `notification`='$notification' WHERE `id`='$id'";
		if(!$this->query($sql)){
			echo "Error updating message: " . mysql_error();
			return false;
		}
		// echo "Row updated";		
		return true;
	}
	
	public function deleteMessage($id){
		$sql = "DELETE FROM `Message` WHERE `id`='$id'";
		if(!$this->query($sql)){
			echo "Error deleting message: " . mysql_error();
			return false;
		}
		// echo "Row deleted";
		return true;		
	}
	
	public function selectUserMessages($userID) {
		$results = $this->query("SELECT * FROM `Message` WHERE `sender` = '$userID' OR `receiver` = $userID");
		return $results;
	}
	
}


class DBQueryResult {

	private $_results = array();
	
	public function __set($var,$val){
		$this->_results[$var] = $val;
	}

	public function __get($var){	
		if (isset($this->_results[$var]))
		{
			return $this->_results[$var];
		}
		else
		{
			return null;
		}
	}
}

?>
