<?php
//include the file session.php
include("session.php");
//include the file db_conn.php
include("db_conn.php");

//receive the id data from the form (in signin_form.php)
$id=$_POST['id'];
//receive the password data from the form (in signin_form.php)
$password=$_POST['password'];
//encryption for password
$salt = substr($password, 0, 2); 
$password_en=crypt($password,$salt);


//query to check whether id is in the table (check whether the user has been signed up)
$query = "SELECT * FROM users_udw WHERE id='$id'";
//execute query to the database and retrieve the result ($result)
$result = $mysqli->query($query);

//check if sql is successful or not
if (!$mysqli -> query($query)) {
	// echo("Error description: " . $mysqli -> error);
	header('Location: ./UDW_homePage.php?error=SQL_error');
}

//convert the result to array (the key of the array will be the column names of the table)
	$row=$result->fetch_array(MYSQLI_ASSOC);

//if the id from table is not same as the id data from the form(from signin_form.php)
if($row['ID']!=$id || $id=="")
{
	//automatically go back to signin_form and pass the error message
	header('Location: ./login_form.php?error=Do_not_have_a_record');
}
//if the id is same as the id data from the form(from signin_form.php) 
else {
	//if the password from table is same as the password data from the form(from signin_form.php)
	if($row['password']==$password_en) {
		//save the id in the session
		$session_id=$row['ID'];
		$_SESSION['session_id']=$session_id;
		// save the access right in the sesstion
		$session_access=$row['access'];
		$_SESSION['session_access']=$session_access;
		//automatically go to UDW_homePage.php
		header('Location: ./UDW_homePage.php'); 

	}//if the password from table does not match with the password data from the signin form
	else{
		//automatically go back to signin_form and pass the error message
		header('Location: ./login_form.php?error=invalid_password');
	}
}
?>