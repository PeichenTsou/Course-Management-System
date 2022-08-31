<?php
//include the file session.php
include("session.php");

//if the session for id has been set, automatically go to "signin_success.php"
if($session_id!="") {
	header('location: ./UDW_homePage.php');
}

//if there is any received error message 
if(isset($_GET['error']))
{
	$errormessage=$_GET['error'];
	//show error message using javascript alert
	echo "<script>alert('$errormessage');</script>";
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<!-- Link to use icon-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<!-- add library-->
		<script src="./js/j.tabledit.js"></script>
		<script src="./js/j.tabledit.min.js"></script>
    </head>
	<style>
		.signin_form {
			margin-top: 200px;
		}	
	</style>
	<body>
		<div class="signin_form">
			<form action="./login_engine.php" method="post">
				<fieldset>
					<div class="form-group row justify-content-center">
						<h2>Please sign in</h1>
					</div>
					<div class="form-group row justify-content-center">
						<div class="col-sm-3">
							<input name="id" type="text" class="form-control" id="id" placeholder="Student ID or Staff ID">
						</div>
					</div>
					<div class="form-group row justify-content-center">
						<div class="col-sm-3">
							<input name="password" type="password" class="form-control" id="password" placeholder="Password">
						</div>
					</div>
					<div class="form-group row justify-content-center">
						<div class="col-sm-3">
							<button name="submit" type="submit" class="btn btn-primary btn-block" value="Sign in">Sign in</button>
						</div>
					</div>
					<div class="form-group row justify-content-center">
						<div class="col-sm-3">
							<a href="UDW_homePage.php" class="btn btn-danger btn-block" role="button">Cancel</a>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
    </body>  
</html>  


