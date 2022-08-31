<?php
//starting session
session_start();

//if the session for username has not been set, initialise it
if(!isset($_SESSION['session_id'])){
	$_SESSION['session_id']="";
}
//save username in the session 
$session_id=$_SESSION['session_id'];



//if the session for access has not been set, initialise it
if(!isset($_SESSION['session_access'])){
	$_SESSION['session_access']="";
}
//save username in the session 
$session_access=$_SESSION['session_access'];



?>