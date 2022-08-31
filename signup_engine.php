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

$add_by_dc=$_POST['add_by_dc'];

//encryption for password
$salt = substr($password, 0, 2); 
$password_en=crypt($password,$salt);

//query to check whether username is in the table (check whether the user has been signed up)
$query = "SELECT * FROM users_udw WHERE id='$id'";
//execute query to the database and retrieve the result ($result)
$result = $mysqli->query($query);

//convert the result to array (the key of the array will be the column names of the table)
	$row=$result->fetch_array(MYSQLI_ASSOC);

//if the username from table is not same as the username data from the form(from login_form.php)
if($row['id']!=$id || $id=="")
{   // NO same user > check password match or not
    if (!$mysqli -> query("INSERT INTO users_udw (ID, name, password, email, access, qualification, expertise, mobile, address, birth_date) 
                            VALUES ('$id', '$name', '$password_en', '$email', '$access', '$qualification', '$expertise', '$mobile','$address', '$birth_date')")) {
        echo("Error description: " . $mysqli -> error);
        echo("<br>id: " . $id. ", row['id']=". $row['id']);
    } else {

        if ($add_by_dc != "add_by_dc") {
            //save the username in the session
            $session_id=$id;
            $_SESSION['session_id']=$session_id;
            // save the access right in the sesstion
            $session_access=$access;
            $_SESSION['session_access']=$session_access;
            //automatically go to UDW_homePage.php
            // header('Location: ./UDW_homePage.php');
            header('Location: ./registrationPage.php?error=Passwd is '.$password); //test
        } else if ($add_by_dc == "add_by_dc") {
            // Added by Degree coordinator
            header('Location: ./MasterList_AcademicStaff.php');
        }
    }
}
//if the username is same as the username data from the form(from registrationPage.php)  
else { // There is username >> username already existing
    header('Location: ./registrationPage.php?error=ID_Exist');
}

$mysqli -> close();

?>