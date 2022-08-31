<?php
//include the file session.php
include("session.php");

//if not logging in, automatically go to "UDW_homePage.php"
if($session_id=="") {
	header('Location: ./UDW_homePage.php?error=Please login');
}

//if there is any received error message 
if(isset($_GET['mgs']))
{
	$message=$_GET['mgs'];
	//show error message using javascript alert
	echo "<script>alert('$message');</script>";
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>University of DoWell in Wonderland</title>
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
		<!-- Link to use font-awesome icon-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Link to use google-font-->
        <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan+2&display=swap" rel="stylesheet">
        <!-- Link to use css file-->
		<link rel="stylesheet" type="text/css" href="./css/02_RegistrationPage.css">
		<!-- Tabledit library-->
        <script src="./js/j.tabledit.js"></script>
        <script src="./js/j.tabledit.min.js"></script>
    </head>
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
                    <a id="stafflist_button" href="MasterList_AcademicStaff.php" class="nav-item nav-link">Academic Staff</a>
                    <a id="unitlist_button" href="MasterList_Unit.php" class="nav-item nav-link">Unit List</a>
                    <a id="unitMgmt_button" href="UnitClassManagement.php" class="nav-item nav-link">Unit Management</a>
                    <a id="tutorialAllocate_button" href="TutorialAllocationPage.php" class="nav-item nav-link">Tutorial Allocation</a>
                    <a id="enrollStudent_button" href="EnrolledStudentDetailsPage.php" class="nav-item nav-link">Enrolled Student Details</a>
            </div>
				<div class="navbar-nav ml-auto">
					<a id="register_button" href="registrationPage.php" class="nav-item nav-link">Register</a>
                    <a id="login_button" href="login_form.php" class="nav-item nav-link">Login</a>
                    <a id="user_id_text" href="UserAccountPage.php" class="nav-item nav-link"><?php echo $session_id;?></a>
                    <a id="logout_button" href="signout.php" class="nav-item nav-link">Logout</a>
				</div>
			</div>
		</nav>

		<div id="banner" class="jumbotron">
			<div id="banner_textblock">
				<h1>User Account Details</h1>
				<!-- <p><button id="fButton_student" class="btn btn-info banner_button disabled">Student</button>
					<button id="fButton_staff" class="btn btn-outline-info banner_button">Academic Staff</button></p> -->
			</div>
		</div>

		<?php 
			include ('db_conn.php');

			// query for selecting / retrieving every row from the table user
			$query = "SELECT * FROM users_udw WHERE id='$session_id'";
			$result = $mysqli->query($query);
			$row=$result->fetch_array(MYSQLI_ASSOC);

			$name = $row["name"];
			// $password = $row["password"];
			$email = $row["email"];
			$access = $row["access"];
			$qualification = $row["qualification"]; 
			$expertise = $row["expertise"]; 
			$mobile = $row["mobile"]; 
			$address = $row["address"]; 
			$birth_date = $row["birth_date"]; 
			
			if (!$result) {
				echo("Error description: " . $mysqli -> error);
			}  

			$mysqli->close();
		?>
		
		<div class="forms">
			<!-- <h1 class="border-bottom pb-3 mb-4">Studnet Registration</h1> -->
			<form action="./userdetail_update_engine.php" method="post" class="needs-validation" novalidate>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="userID">Student or Staff ID:</label>
					<div class="col-sm-9">
						<input name="userID" type="hidden" class="form-control" id="userID" placeholder="eg. 569842" value="<?php echo $session_id;?>">
						<input type="number" class="form-control" value="<?php echo $session_id;?>" disabled>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="name">Name:</label>
					<div class="col-sm-9">
						<input name="name" type="text" class="form-control" id="name" placeholder="eg. John Smith" value="<?php echo $name;?>">
						<div class="invalid-feedback">Please fill out this field.</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="password">Password:</label>
					<div class="col-sm-9">
						<input name="password" type="password" class="form-control password_input" id="password" placeholder="Password">
						<label><input type="checkbox" class="agree">Change Password</label>
						<div class="invalid-feedback">Please enter a valid password. </br> The password should be 6 to 12 characters in length / Contains at least 1 lower case letter, 1 upper case letter, 1 number and 1 of
following special characters ! @ # $ % ^ </div>
						
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="confirm_password">Confirm Password:</label>
					<div class="col-sm-9">
						<input name="confirm_password" type="password" class="form-control password_input" id="confirm_password" placeholder="Confirm Password">
						<div class="invalid-feedback">Please enter the same password.</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="email">Email Address:</label>
					<div class="col-sm-9">
						<input name="email"  type="email" class="form-control" id="email" placeholder="example@abc.com" value="<?php echo $email;?>">
						<div class="invalid-feedback">Please enter a valid email.</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="status">Status:</label>
					<div class="col-sm-9">
						<select name="status" class="custom-select" id="status" disabled>
							<?php 
							 if ($access == 0){
								// if user is student
								echo '<option value="0" selected="selected">Student</option>
										<option value="1">Staff</option>';
							 } else if ($access == 1){
								// User is staff
								echo '<option value="0">Student</option>
										<option value="1" selected="selected">Staff</option>';
							 } else {
								echo '<option value="0">Student</option>
										<option value="1" selected="selected">Degree Coordinator</option>';
							 }
							?>
						</select>
					</div>	
				</div>
				<div class="form-group row staff_option">
					<label class="col-sm-3 col-form-label">Qualification:</label>
					<div class="col-sm-9">
						<select name="qualification" class="custom-select form-control" id="qualification">
							<option value="Qualification">Qualification</option>
							<?php 
								if ($qualification == "Bachelor"){
									// if 
									echo '<option value="Bachelor" selected="selected">Bachelor</option>
									<option value="Master">Master</option>
									<option value="PhD">PhD</option>';
								} else if ($qualification == "Master"){
									// if 
									echo '<option value="Bachelor">Bachelor</option>
									<option value="Master" selected="selected">Master</option>
									<option value="PhD">PhD</option>';
								} else if ($qualification == "PhD"){
									// if 
									echo '<option value="Bachelor">Bachelor</option>
									<option value="Master">Master</option>
									<option value="PhD" selected="selected">PhD</option>';
								} else {
									echo '<option value="Bachelor">Bachelor</option>
									<option value="Master">Master</option>
									<option value="PhD" selected="selected">PhD</option>';
								}
							?>
						</select>
						<div class="invalid-feedback">Please selet this field.</div>
					</div>
				</div>
				<div class="form-group row staff_option">
					<label class="col-sm-3 col-form-label">Expertise:</label>
					<div class="col-sm-9">
						<input name="expertise" type="text" class="form-control" id="expertise" placeholder="eg. Big data analytics" value="<?php echo $expertise;?>">
						<div class="invalid-feedback">Please fill out this field.</div>
					</div>
				</div>
				<div class="form-group row optional_field">
					<label class="col-sm-3 col-form-label" for="mobile">Mobile:</label>
					<div class="col-sm-9">
						<input name="mobile" type="mobile" class="form-control" id="mobile" placeholder="eg. 0412345678" value="<?php echo $mobile;?>">
					</div>
				</div>
				<div class="form-group row optional_field">
					<label class="col-sm-3 col-form-label" for="address">Address:</label>
					<div class="col-sm-9">
						<input name="address" type="text" class="form-control" id="address" placeholder="eg. 1 Colledge road" value="<?php echo $address;?>">
					</div>
				</div>
				<div class="form-group row optional_field">
					<label class="col-sm-3 col-form-label" for="birth_date">Date of Birth:</label>
					<div class="col-sm-9">
						<input name="birth_date" type="date" class="form-control" id="birth_date" placeholder="dd/mm/yyyy" value="<?php echo $birth_date;?>">
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-9 offset-sm-3">
						<input name="submit" type="submit" class="btn btn-primary submitButton" value="Update">
					</div>
				</div>
			</form>
			<hr/>

			<?php 
				if ($access == 0){
				// if user is student
				echo '<div class="col-sm-9 offset-sm-3">
							<a href="TutorialAllocationPage.php" class="btn btn-outline-info">Tutorial Allocation</a>
							<br>
							<br>
						</div>';

				} else {
				// User is staff
				
				// echo '<div class="col-sm-9 offset-sm-3">
				// 			<button class="btn btn-outline-info">Manage Unavailability</button>
				// 			Add, remove or update unavailability
				// 		</div>';

				echo '<div class ="container show_staff">
						<br>
						<h2 align ="center">Manage Unavalibility</h2>
				
							<table id="table_id" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>ID</th>
										<th>Day</th>
										<th>Time</th>
									</tr>
								</thead>
								<tbody>';

								include ('db_conn.php');

								// query for selecting / retrieving every row from the table customer
								$query = "SELECT * FROM staff_unavailability WHERE staff_id = $session_id ORDER BY FIELD(day,'Monday','Tuesday','Wednesday', 'Thursday', 'Friday'), time ASC";
								$result = $mysqli->query($query);
		
								if (!$result) {
									echo("Error description: " . $mysqli -> error);
									}  
		
									while ($row = $result->fetch_assoc()) {
										$field1name = $row["ID"];
										$field2name = $row["day"];
										$field3name = $row["time"];
		
										echo '<tr> 
												<td class="id">'.$field1name.'</td> 
												<td>'.$field2name.'</td> 
												<td>'.$field3name.'</td> 
											 </tr>';
									}
								// $mysqli->close();
						echo '</tbody>
							</table>
							<span style="color: red;"> * Time must start on the hour or half-hour</span>
							<div class="" align ="right">
								<button type="button" class="btn btn-primary create_button" data-toggle="modal" data-target="#modalId2" onclick="showModalAddUnit()"> Add Unavalibility</button>
							</div>
						</div>';
				
				echo '<div id="modalId2" class="modal" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document"> 
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Add Unavalibility</h5>
									</div>
									<div class="modal-body">
										<form action="" method="">
											<div class="form-group">
												<label for="unavalibility_day">Day</label>
												<select name="unavalibility_day" class="custom-select form-control" id="unavalibility_day" required>
													<option value="Monday">Monday</option>
													<option value="Tuesday">Tuesday</option>
													<option value="Wednesday">Wednesday</option>
													<option value="Thursday">Thursday</option>
													<option value="Friday">Friday</option>
												</select>
											</div>
											<div class="form-group">
												<label for="unavalibility_time">Time</label>
												<select name="unavalibility_time" class="custom-select form-control" id="unavalibility_time" required>
													<option value="09:00">09:00</option>';
													for ($hour = 10; $hour <= 18; $hour++) {
														echo '<option value="'.$hour.':00">'.$hour.':00</option>';
														echo '<option value="'.$hour.':30">'.$hour.':30</option>';
													}
										echo '</select>
										</div>

										<button id="new_unavalibility_submit" type="submit" class="btn btn-success">Add</button>
										<button id="close_new_unit" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
									</form>
									
								</div>
							</div>
						</div>
					</div>';
				}
			?>
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
							// if the checkbox is checked (to check passwd or not)
							if($(".agree").prop("checked") == true) {
								alert("checked");
								// check passwd
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

							} else {
								alert("Not checked");
								// Not to check passwd
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
				
					if (validation_done == 1) {
						alert("validation_done == 1");
					} else {
						e.preventDefault();
					}
				});


				// Disable / enable password change
				$('.password_input').prop("disabled", true);
				$(".agree").click(function(){
					if($(this).prop("checked") == true){
						$('.password_input').prop("disabled", false);
					}
					else if($(this).prop("checked") == false){
						$('.password_input').prop("disabled", true);
					}
				});

				// New Unavalibility
                $("#new_unavalibility_submit").click(function(){

                    if($("#unavalibility_day").val()==""){
                        alert("Please enter unavalibility_day");  
                    }else if($("#unavalibility_time").val()==""){
                        alert("Please enter unavalibility_time."); 
                    }else{

                        // get the value of username field and assign as username.
                        var unavalibility_day = $("#unavalibility_day").val();
                        var unavalibility_time = $("#unavalibility_time").val();
                        var staff_id='<?php echo $session_id;?>';
                        action = "add";
                     
                        $.get( "view_edit_unavailability.php", { staff_id: staff_id, action: action, day: unavalibility_day, time: unavalibility_time} )
                            .done(function( data ) {
                                alert (data);                        
                                location.reload();
                            });
                    }
                });

                $('#table_id').Tabledit({
                    url: 'tabledit.php',
                    columns: {
                        identifier: [0, 'ID'],
                        editable: [[1, 'Day'], [2, 'Time']]
                    },
                    restoreButton: false
                });

                $('.tabledit-save-button').click(function(){
                    id = $(this).closest('tr').attr('id');
                    action = "edit";
                    var day;
                    var time;

                    var x = 0;
                    $(this).closest('tr').find("input").each(function() {

                        if (x == 1){
                            day = this.value;
                            // alert(day);
                        } else if (x == 2) {
                            time = this.value;
                        } 
                        x = x+1;
                    });
                    $.get( "view_edit_unavailability.php", { id: id, action: action, day: day, time: time} )
                    .done(function( data ) {
                                alert (data);                        
                                location.reload();
                    });
                });

                $('.tabledit-confirm-button').click(function(){
                    id = $(this).closest('tr').attr('id');
                    action = "delete";

                    $.get( "view_edit_unavailability.php", { id: id, action: action} )
                    .done(function( data ) {
                        alert (data);
                        location.reload();
                    });
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
                $( "#register_button" ).css("display","none");
                $( "#logout_button" ).css("display","block");
            } else {
                // logout > Show login and register button and hide logout button
                $( "#login_button" ).css("display","block");
                $( "#register_button" ).css("display","block");
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


