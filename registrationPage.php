<?php
//include the file session.php
include("session.php");

//if the session for username has been set, automatically go to "signin_success.php"
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
		<!-- Tabledit library-->
		<!-- <script src="./js/j.tabledit.js"></script>
		<script src="./js/j.tabledit.min.js"></script> -->
		<!-- Link to use font-awesome icon-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Link to use google-font-->
        <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan+2&display=swap" rel="stylesheet">
        <!-- Link to use css file-->
        <link rel="stylesheet" type="text/css" href="./css/02_RegistrationPage.css">
    </head>
	<style>
		.signin_form {
			margin-top: 200px;
		}	
	</style>
	<body>
		<nav class="navbar navbar-expand-md navbar-light bg-light">
			<a href="#" class="navbar-brand">
				<img class="logo_svg" src="https://image.flaticon.com/icons/svg/2258/2258528.svg" height="28" alt="CoolBrand">
				<span>UDW</span>
			</a>
			<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarCollapse">
				<div class="navbar-nav">
					<a href="UDW_homePage.php" class="nav-item nav-link">Home</a>
					<a href="UnitDetailPage.php" class="nav-item nav-link">Unit Detail</a>
					<a href="UnitEnrolmentPage.php" class="nav-item nav-link">Unit Enrollment</a>
					<a href="IndividualTimetablePage.php" class="nav-item nav-link">Individual Timetable</a>
                </div>
				<div class="navbar-nav ml-auto">
					<!-- <a id="register_button" href="registrationPage.php" class="nav-item nav-link">Register</a> -->
                    <a id="login_button" href="login_form.php" class="nav-item nav-link">Login</a>
                    <a id="user_id_text" href="UserAccountPage.php" class="nav-item nav-link"><?php echo $session_id;?></a>
                    <a id="logout_button" href="signout.php" class="nav-item nav-link">Logout</a>
				</div>
			</div>
		</nav>

		<div id="banner" class="jumbotron">
			<div id="banner_textblock">
				<h1>Registration</h1>
				<!-- <p><button id="fButton_student" class="btn btn-info banner_button disabled">Student</button>
					<button id="fButton_staff" class="btn btn-outline-info banner_button">Academic Staff</button></p> -->
			</div>
		</div>

		<div class="forms">
			<!-- <h1 class="border-bottom pb-3 mb-4">Studnet Registration</h1> -->
			<form action="./signup_engine.php" method="post" class="needs-validation" novalidate>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="userID">Student or Staff ID:</label>
					<div class="col-sm-9">
						<input name="userID" type="number" class="form-control" id="userID" placeholder="eg. 569842" max="99999999">
						<div class="invalid-feedback">Please fill out number lower than 99999999.</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="name">Name:</label>
					<div class="col-sm-9">
						<input name="name" type="text" class="form-control" id="name" placeholder="eg. John Smith">
						<div class="invalid-feedback">Please fill out this field.</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="password">Password:</label>
					<div class="col-sm-9">
						<input name="password" type="password" class="form-control" id="password" placeholder="Password">
						<div class="invalid-feedback">Please enter a valid password. </br> The password should be 6 to 12 characters in length / Contains at least 1 lower case letter, 1 upper case letter, 1 number and 1 of
following special characters ! @ # $ % ^ </div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="confirm_password">Confirm Password:</label>
					<div class="col-sm-9">
						<input name="confirm_password" type="password" class="form-control" id="confirm_password" placeholder="Confirm Password">
						<div class="invalid-feedback">Please enter the same password.</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="email">Email Address:</label>
					<div class="col-sm-9">
						<input name="email"  type="email" class="form-control" id="email" placeholder="example@abc.com">
						<div class="invalid-feedback">Please enter a valid email.</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="status">Status:</label>
					<div class="col-sm-9">
						<select name="status" class="custom-select" id="status">
							<option value="0">Student</option>
							<option value="1">Staff</option>
						</select>
					</div>	
				</div>
				<div class="form-group row staff_option">
					<label class="col-sm-3 col-form-label">Qualification:</label>
					<div class="col-sm-9">
						<select name="qualification" class="custom-select form-control" id="qualification">
							<option value="Qualification">Qualification</option>
							<option value="Bachelor">Bachelor</option>
							<option value="Master">Master</option>
							<option value="PhD">PhD</option>
						</select>
						<div class="invalid-feedback">Please selet this field.</div>
					</div>
				</div>
				<div class="form-group row staff_option">
					<label class="col-sm-3 col-form-label">Expertise:</label>
					<div class="col-sm-9">
						<input name="expertise" type="text" class="form-control" id="expertise" placeholder="eg. Big data analytics" >
						<div class="invalid-feedback">Please fill out this field.</div>
					</div>
				</div>
				<div class="form-group row optional_field">
					<label class="col-sm-3 col-form-label" for="mobile">Mobile:</label>
					<div class="col-sm-9">
						<input name="mobile" type="mobile" class="form-control" id="mobile" placeholder="eg. 0412345678">
					</div>
				</div>
				<div class="form-group row optional_field">
					<label class="col-sm-3 col-form-label" for="address">Address:</label>
					<div class="col-sm-9">
						<input name="address" type="text" class="form-control" id="address" placeholder="eg. 1 Colledge road">
					</div>
				</div>
				<div class="form-group row optional_field">
					<label class="col-sm-3 col-form-label" for="birth_date">Date of Birth:</label>
					<div class="col-sm-9">
						<input name="birth_date" type="date" class="form-control" id="birth_date" placeholder="dd/mm/yyyy">
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-9 offset-sm-3">
						<input name="submit" type="submit" class="btn btn-primary submitButton" value="Submit">
					</div>
				</div>
			</form>
		</div>

		<script>
			// Example starter JavaScript for disabling form submissions if there are invalid fields
			(function() {
			'use strict';
			window.addEventListener('load', function() {
				// Fetch all the forms we want to apply custom Bootstrap validation styles to
				var forms = document.getElementsByClassName('needs-validation');
				// Loop over them and prevent submission
				var validation = Array.prototype.filter.call(forms, function(form) {
				form.addEventListener('submit', function(event) {
					if (form.checkValidity() === false) {
					event.preventDefault();
					event.stopPropagation();
					}
					form.classList.add('was-validated');
				}, false);
				});
			}, false);
			})();
		</script>

		<script>
			var email_reg = /\w+[@]{1}\w+[.]\w+/;
			var passwd_reg =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^])[^]{6,12}$/;
			
			$(document).ready(function(){
				
				// Show the staff option if status is not 1
				if($("#status" ).val() == 0 ){
					$( ".staff_option" ).css("display","none");
				} else {
					$(".staff_option" ).fadeIn( "slow", function() {  });
				}

				// Show the staff option if status is not 1 on change of selecting
				$('select').on('change', function() {
					if(this.value == 0) {
						$( ".staff_option" ).css("display","none");
					} else if (this.value == 1) {
						$(".staff_option" ).fadeIn( "slow", function() {  });
					}
				});
		
				var validation_done = 0;
				// Format check for Registration form
				$(".submitButton").click(function(e){
					// check ID
					if($("#userID").val()==""){
						$("#userID").addClass("is-invalid");
					} else {
						$("#userID").removeClass("is-invalid");
						// check name
						if($("#name").val()==""){
							$("#name").addClass("is-invalid");
						} else {
							$("#name").removeClass("is-invalid");
							if(!($("#password").val().search(passwd_reg) != -1) || ($("#password").val()=="")){
								$("#password").addClass("is-invalid");
							} else {
								$("#password").removeClass("is-invalid");
								// check confirm_password
								if(($("#confirm_password").val()!==$("#password").val()) || ($("#confirm_password").val()=="")){
									$("#confirm_password").addClass("is-invalid");
								} else {
									$("#confirm_password").removeClass("is-invalid");
									// check email
									if(!($("#email").val().search(email_reg) != -1) || ($("#email").val()=="")){
										$("#email").addClass("is-invalid");
									} else {
										$("#email").removeClass("is-invalid");
										validation_done = 1;
										// if user is staff
										if($("#status" ).val() == 1 ) {
											validation_done = 0;
											// check qualification
											if($("#qualification").val()=="Qualification"){
												$("#qualification").addClass("is-invalid");
											} else {
												$("#qualification").removeClass("is-invalid");
												// check expertise
												if($("#expertise").val()==""){
													$("#expertise").addClass("is-invalid");
												} else {
													$("#expertise").removeClass("is-invalid");
													validation_done = 1;
												}
											}
										}
									}
								}
							}
						}
					}
				
					if (validation_done == 1) {
						alert("validation_done == 1");
					} else {
						e.preventDefault();
					}
				});	
			})

		</script>

		<script>
            var session_id='<?php echo $session_id;?>';
            var session_access='<?php echo $session_access;?>';

            $("#view_button").click(function(e)
            {
                if (session_id == ""){
                    alert("Login is required");
                    // Cancel the default action
                    e.preventDefault();
                }
            });
   
            if(! session_id == "") {
                // login > Hide login and register button and show logout button
                $( "#login_button" ).css("display","none");
                // $( "#register_button" ).css("display","none");
                $( "#logout_button" ).css("display","block");
            } else {
                // logout > Show login and register button and hide logout button
                $( "#login_button" ).css("display","block");
                // $( "#register_button" ).css("display","block");
                $( "#logout_button" ).css("display","none");
            }

  
            if( session_access != 2) {
                // Access 0 (student) > Hide master list and unit management buttons
                $( "#stafflist_button" ).css("display","none");
                $( "#unitlist_button" ).css("display","none");       
                if (session_access == 0){
                    $( "#unitMgmt_button" ).css("display","none");
                    $( "#enrollStudent_button" ).css("display","none");
                } else if (session_access == 1){
                    $( "#unitMgmt_button" ).css("display","block");
                    $( "#tutorialAllocate_button" ).css("display","none");
                }
            } else {
                 // Access 1 (DC)  > unit management buttons
                if (session_access == 2){
                    // Access 2 (DC)  > Show master list buttons
                    $( "#stafflist_button" ).css("display","block");
                    $( "#unitlist_button" ).css("display","block");
                    $( "#tutorialAllocate_button" ).css("display","none");
                      
                }
            }
	

            
        </script>
    </body>  
</html>  


