<?php

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

function createUserTable($connection)
{
	// Create table
	$sql="CREATE TABLE IF NOT EXISTS Users(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), Name VARCHAR(40), Email VARCHAR(40), Password VARCHAR(120) NOT NULL)";

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
	// Insert data
	$result = mysqli_query($connection,"INSERT INTO `Users`(`Name`, `Email`, `Password`) VALUES ('".$name."', '".$email."', '".$password."')");
	if(!$result){
		echo "Error inserting user: " . mysqli_error($connection);
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
		echo $row['id'] . " " . $row['Name'] . " " . $row['Email'];
		echo "<br>";
	}
}

$connection = createDBConnection();
//createUserTable($connection);
//insertUser($connection, "Usuario2","usuario2@usuario.com", "usuariopass");
printTable($connection, "Users");

//Close connection
mysqli_close($con);

?>