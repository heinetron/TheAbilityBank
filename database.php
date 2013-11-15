<?php

function clearTable($connection, $tableName){
	
	$sql="DELETE FROM ".$tableName;

	// Execute query
	if (mysqli_query($connection,$sql))
	{
		echo "Deleted all records from ".$tableName;
	}
	else
	{
		echo "Error deleting records: " . mysqli_error($connection);
	}
}


function printTable($connection, $tableName)
{
	$result = mysqli_query($connection,"SELECT * FROM ".$tableName);
	if(!$result){
		echo "Error selecting from table ".$tableName.": " . mysqli_error($connection);
	}
	
	while($row = mysqli_fetch_array($result))
	{
		var_dump($row);
		echo "<br>";
	}
}

function createDBConnection()
{
	// Create connection
	$connection = mysqli_connect("localhost","tab","tab2013","tab");
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	return $connection;
}

/////////////////////////////////////////////// USER ////////////////////////////////////////////////

function createUserTable($connection)
{
	// Create table
	$sql="CREATE TABLE IF NOT EXISTS Users(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), Name VARCHAR(40) NOT NULL, Email VARCHAR(40) NOT NULL, Password VARCHAR(120) NOT NULL)";

	// Execute query
	if (mysqli_query($connection,$sql))
	{
		echo "Table created successfully";
	}
	else
	{
		echo "Error creating table: " . mysqli_error($connection);
	}
}

function insertUser($connection, $name, $email, $password)
{
	$password = getEncryptedPassword($connection, $password);
	// Insert data
	$result = mysqli_query($connection,"INSERT INTO `Users`(`Name`, `Email`, `Password`) VALUES ('".$name."', '".$email."', '".$password."')");
	if(!$result){
		echo "Error inserting user: " . mysqli_error($connection);
	}
}

/////////////////////////////////////////////// SECURE ////////////////////////////////////////////////

function createSaltTable($connection){
	// Create table
	$sql="CREATE TABLE IF NOT EXISTS Salt(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), Salt VARCHAR(32) NOT NULL)";
	// Execute query
	if (mysqli_query($connection,$sql))
	{
		echo "Table created successfully";
	}
	else
	{
		echo "Error creating table: " . mysqli_error($connection);
	}
}

function insertSalt($connection)
{
	//$salt = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 50) , 1) .substr( md5( time() ), 1);
	$salt = md5( time() );
	$result = mysqli_query($connection,"INSERT INTO `Salt`(`Salt`) VALUES ('".$salt."')");
	if(!$result){
		echo "Error inserting user: " . mysqli_error($connection);
	}
}

function getSalt($connection, $saltId){
	
	$sql = "SELECT Salt FROM Salt WHERE id = ".$saltId;
	$salt = mysqli_query($connection,$sql);
	$salt = mysqli_fetch_array($salt);
	return $salt[0];
}

function getEncryptedPassword($connection, $password){
	
	// Get the first salt
	$salt = getSalt($connection, 1);
	
	//Encrypt password
	$encryptedPassword = crypt("password", $salt);
	
	mysqli_close($con);
	return $encryptedPassword;
}

/////////////////////////////////////////////// OFFERS ////////////////////////////////////////////////

function createOfertTable($connection)
{
	// Create table
	$sql="CREATE TABLE IF NOT EXISTS Ofert(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), Name VARCHAR(40), Category VARCHAR(40), Description VARCHAR(120) NOT NULL)";

	// Execute query
	if (mysqli_query($connection,$sql))
	{
		echo "Table created successfully";
	}
	else
	{
		echo "Error creating table: " . mysqli_error($connection);
	}
}

function getOfert($connection){
	
	$sql = "SELECT * FROM Ofert";
	$ofert = mysqli_query($connection,$sql);
	$ofert = mysqli_fetch_array($ofert);
	return $ofert;
}

function insertOfert($connection, $name, $category, $description)
{
	// Insert data
	$result = mysqli_query($connection,"INSERT INTO `Ofert`(`Name`, `Category`, `Description`) VALUES ('".$name."', '".$category."', '".$description."')");
	if(!$result){
		echo "Error inserting ofert: " . mysqli_error($connection);
	}
}

/////////////////////////////////////////////// DEMANDS ////////////////////////////////////////////////

function createDemandTable($connection)
{
	// Create table
	$sql="CREATE TABLE IF NOT EXISTS Demand(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), Name VARCHAR(40), Category VARCHAR(40), Description VARCHAR(120) NOT NULL)";

	// Execute query
	if (mysqli_query($connection,$sql))
	{
		echo "Table created successfully";
	}
	else
	{
		echo "Error creating table: " . mysqli_error($connection);
	}
}

function getDemand($connection){
	
	$sql = "SELECT * FROM Ofert";
	$demand = mysqli_query($connection,$sql);
	$demand = mysqli_fetch_array($demand);
	return $demand;
}

function insertDemand($connection, $name, $category, $description)
{
	// Insert data
	$result = mysqli_query($connection,"INSERT INTO `Demand`(`Name`, `Category`, `Description`) VALUES ('".$name."', '".$category."', '".$description."')");
	if(!$result){
		echo "Error inserting ofert: " . mysqli_error($connection);
	}
}


/////////////////////////////////////////////////////////////////////////////////////////////////////


$connection = createDBConnection();
//createUserTable($connection);
//createSaltTable($connection);

//createOfertTable($connection);
//createDemandTable($connection);

//printTable($connection, "Users");
//insertUser($connection, "Usuario2","usuario2@usuario.com", "usuariopass");
//clearTable($connection, "Users");


//Close connection
mysqli_close($con);

?>
