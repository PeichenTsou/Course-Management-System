<?php
//connect to mysql
$mysqli = new mysqli('localhost', 'username', 'password', 'dbname'); 

if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
?>