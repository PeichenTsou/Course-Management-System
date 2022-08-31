<?php
//include the file session.php
include("session.php");
//include the file db_conn.php
include("db_conn.php");

//receive the username data from the form (in registrationPage.php)
$id=$_POST['userID'];
$name=$_POST['name'];
$password=$_POST['password'];
$email=$_POST['email'];
$access=$_POST['status'];
// $access=2;
$qualification=$_POST['qualification'];
$expertise=$_POST['expertise'];
$address=$_POST['address'];
$mobile=$_POST['mobile'];
$birth_date=$_POST['birth_date'];

//encryption for password
$salt = substr($password, 0, 2); 
$password_en=crypt($password,$salt);

$query = "UPDATE users_udw
SET name = '$name',
    password = '$password_en',
    email = '$email',
    qualification = '$qualification',
    expertise = '$expertise',
    mobile = '$mobile',
    address = '$address',
    birth_date = '$birth_date'

WHERE ID = '$id'";

$result = $mysqli->query($query);

if (!$result) {
        echo("Error description: " . $mysqli -> error);
    }  else {
        header('Location: ./UserAccountPage.php?mgs=Updated!'); 
    } 
$mysqli -> close();

?>