<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "DB061196";

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	// Create database
	$sql = "CREATE DATABASE " . $dbname;
	if ($conn->query($sql) === TRUE) {
    	echo "Database created successfully";
    	echo "<br>";
	} else {
	    echo "Error creating database: " . $conn->error;
	    echo "<br>";
	}
	$conn->close();

	// Start a new connection now that the table is created
	$con = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($con->connect_error) {
	    die("Connection failed: " . $con->connect_error);
	}

	//add player table
    $sql = "CREATE TABLE Players (
    	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,  
    	username VARCHAR(256),
    	password VARCHAR(256), 
    	firstname VARCHAR(256),
    	lastname VARCHAR(256), 
    	age VARCHAR(256),
    	gender VARCHAR(256), 
    	location VARCHAR(100)
    	)";

    if($con->query($sql) === TRUE)
    {
    	echo "Player table created successfully";
    	echo "<br>";
    }
    else
    {
    	echo "Failed to create player table: " . $con->error;
    	echo "<br>";
    }

    $sql = "INSERT INTO Players (username, password, firstname, lastname, age, gender, location)
		VALUES ('frost', '', 'john@example.com')";

	if ($conn->query($sql) === TRUE) {
	    echo "New record created successfully";
	} 
	else 
	{
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}


    //add games table
    $sql = "CREATE TABLE Games (
    	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,  
    	player VARCHAR(256), 
    	duration VARCHAR(256), 
    	level VARCHAR(256)
    	)";

    if($con->query($sql) === TRUE)
    {
    	echo "Games table created successfully\n";
    	echo "<br>";
    }
    else
    {
    	echo "Failed to create games table: " . $con->error;
    	echo "<br>";
    }

    //add levels table
    $sql = "CREATE TABLE Levels (
    	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,  
    	jsonData VARCHAR(256)
    	)";

    if($con->query($sql) === TRUE)
    {
    	echo "Levels table created successfully";
    	echo "<br>";
    }
    else
    {
    	echo "Failed to create levels table: " . $con->error;
    	echo "<br>";
    }



	$con->close();
?> 