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
	echo "</br>";echo "</br>";
	echo $sql;
	echo "</br>";echo "</br>";
    $res = mysql_query($sql);

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
	
	
	public function selectTableWithColumn($tableName, $columnName, $columnValue){
		$sql = "SELECT * FROM $tableName where $columnName = \"$columnValue\"";
		return $this->query($sql);
	}
	
	public function clearTable($tableName){
		$sql="DELETE FROM ".$tableName;
		
		// Execute query
		$result = $this->query($sql);
		if($result){
			echo "Deleted all records from '$tableName'";
		}
		else{
			echo "Could not delete records from '$tableName'";
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
		$sql="CREATE TABLE IF NOT EXISTS User(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), Name VARCHAR(40) NOT NULL, Email VARCHAR(40) NOT NULL, Password VARCHAR(120) NOT NULL, Salt VARCHAR(120) NOT NULL, Premium BOOL NOT NULL);";

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
	}
	//TODO delete, update
	
	/////////////////////////////////////////////// OFFERS ////////////////////////////////////////////////

	public function createOfferTable()
	{
		// Create table
		$sql="CREATE TABLE IF NOT EXISTS Offer(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), Name VARCHAR(40), Category VARCHAR(40), Description VARCHAR(120) NOT NULL)";

		// Execute query
		if($this->query($sql)){
			echo "Table created successfully";
		}
		else{
			echo "Error creating Offer table: " . mysql_error();
		}
	}

	public function getOffer(){
		
		$sql = "SELECT * FROM Offer";
		$offer = $this->query($sql);
		return $offer;
	}

	public function insertOffer($name, $category, $description)
	{
		// Insert data
		$sql = "INSERT INTO `Offer`(`Name`, `Category`, `Description`) VALUES ('".$name."', '".$category."', '".$description."')";
		
		if(!$this->query($sql)){
			echo "Error inserting offer: " . mysql_error();
		}
	}

	/////////////////////////////////////////////// DEMANDS ////////////////////////////////////////////////

	public function createDemandTable()
	{
		// Create table
		$sql="CREATE TABLE IF NOT EXISTS Demand(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), Name VARCHAR(40), Category VARCHAR(40), Description VARCHAR(120) NOT NULL)";

		// Execute query
		if($this->query($sql)){
			echo "Table created successfully";
		}
		else{
			echo "Error creating Demand table: " . mysql_error();
		}
	}

	public function getDemand($connection){
		
		$sql = "SELECT * FROM Offer";
		$demand = mysqli_query($connection,$sql);
		$demand = mysqli_fetch_array($demand);
		return $demand;
	}

	public function insertDemand($connection, $name, $category, $description)
	{
		// Insert data
		$sql = "INSERT INTO `Demand`(`Name`, `Category`, `Description`) VALUES ('".$name."', '".$category."', '".$description."')";
		$result = $this->query($sql);
		if(!$result){
			echo "Error inserting offer: " . mysql_error();
		}
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
