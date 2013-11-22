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
	echo "</br></br>";
	echo $sql;
	echo "</br></br>";
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
			echo "Deleted all records from $tableName";
		}
		else{
			echo "Could not delete records from $tableName";
		}
	}
	
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
		$sql="CREATE TABLE IF NOT EXISTS User(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), Name VARCHAR(40) NOT NULL, UNIQUE(Name), Email VARCHAR(40) NOT NULL, Password VARCHAR(120) NOT NULL, Salt VARCHAR(120) NOT NULL, Premium BOOL NOT NULL);";

		// Execute query
		if($this->query($sql)){
			echo "Table created successfully";
		}
		else{
			echo "Error creating User table: " . mysql_error();
		}
	}
	
	public function insertUser($name, $email, $password, $salt, $premium)
	{
		// Insert data		
		$sql = "INSERT INTO `User`(`Name`, `Email`, `Password`, `Salt`, `Premium`) VALUES ('$name', '$email', '$password','$salt','$premium')";
		
		if(!$this->query($sql)){
			echo "Error inserting user: " . mysql_error();
			return false;
		}
		return true;
	}
	public function updateUser($name, $email, $password, $salt, $premium)
	{
		$sql = "UPDATE `User` SET `Email`=\"$email\",`Password`=\"$password\",`Salt`=\"$salt\",`Premium`=\"$premium\" WHERE Name=\"$name\"";
		if(!$this->query($sql)){
			echo "Error updating user: " . mysql_error();
			return false;
		}		
		return true;
	}
	
	public function deleteUser($name){
		$sql = "DELETE FROM `User` WHERE `Name` = \"$name\"";
		if(!$this->query($sql)){
			echo "Error deleting user: " . mysql_error();
			return false;
		}		
		return true;		
	}
	
	/////////////////////////////////////////////// OFFERS ////////////////////////////////////////////////

	public function createOfferTable()
	{
		// Create table
		$sql="CREATE TABLE IF NOT EXISTS Offer(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), Name VARCHAR(40), UNIQUE(Name), Category VARCHAR(40) NOT NULL, Description VARCHAR(120))";

		// Execute query
		if($this->query($sql)){
			echo "Table created successfully";
		}
		else{
			echo "Error creating Offer table: " . mysql_error();
		}
	}

	public function insertOffer($name, $description, $category_id,  $user_id)
	{
		// Insert data
		$sql = "INSERT INTO `Offer`(`Name`, `Description`, `Category_id`, `User_id`) VALUES ('$name', '$description', '$category_id', '$user_id')";
		
		if(!$this->query($sql)){
			echo "Error inserting offer: " . mysql_error();
		}
	}

	public function updateOffer($name, $description, $category_id, $user_id)
	{
		$sql = "UPDATE `Offer` SET `Description`=\"$description\",`Category_id`=\"$category_id\",`User_id`=\"$user_id\" WHERE Name=\"$name\"";
		if(!$this->query($sql)){
			echo "Error updating offer: " . mysql_error();
			return false;
		}		
		return true;
	}
	
	public function deleteOffer($name){
		$sql = "DELETE FROM `Offer` WHERE `Name` = \"$name\"";
		if(!$this->query($sql)){
			echo "Error deleting offer: " . mysql_error();
			return false;
		}		
		return true;		
	}	
	/////////////////////////////////////////////// DEMANDS ////////////////////////////////////////////////

	public function createDemandTable()
	{
		// Create table
		$sql="CREATE TABLE IF NOT EXISTS Demand(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), Name VARCHAR(40), UNIQUE(Name), Category VARCHAR(40), Description VARCHAR(120) NOT NULL)";

		// Execute query
		if($this->query($sql)){
			echo "Table created successfully";
		}
		else{
			echo "Error creating Demand table: " . mysql_error();
		}
	}

	public function insertDemand($name, $description, $category_id,  $user_id)
	{
		// Insert data
		$sql = "INSERT INTO `Demand`(`Name`, `Description`, `Category_id`, `User_id`) VALUES ('$name', '$description', '$category_id', '$user_id')";
		
		if(!$this->query($sql)){
			echo "Error inserting demand: " . mysql_error();
		}
	}

	public function updateDemand($name, $description, $category_id, $user_id)
	{
		$sql = "UPDATE `Demand` SET `Description`=\"$description\",`Category_id`=\"$category_id\",`User_id`=\"$user_id\" WHERE Name=\"$name\"";
		if(!$this->query($sql)){
			echo "Error updating demand: " . mysql_error();
			return false;
		}		
		return true;
	}
	
	public function deleteDemand($name){
		$sql = "DELETE FROM `Demand` WHERE `Name` = \"$name\"";
		if(!$this->query($sql)){
			echo "Error deleting demand: " . mysql_error();
			return false;
		}		
		return true;		
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
