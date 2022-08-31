<?php
//include the file session.php
include("session.php");
//db connection
include('db_conn.php'); 

// check if user is DC 
if($session_access==0) {
    header('Location: ./UDW_homePage.php?error=You don not have access right');
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
        <!-- Link to use font-awesome icon-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Link to use google-font-->
        <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan+2&display=swap" rel="stylesheet">
        <!-- Link to use css file-->
        <link rel="stylesheet" type="text/css" href="./css/04_UnitEnrolmentPage.css">
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
                    <a id="enrollStudent_button" href="EnrolledStudentDetailsPage.php" class="nav-item nav-link active">Enrolled Student Details</a>
               </div>
                <div class="navbar-nav ml-auto">
                    <a id="register_button" href="registrationPage.php" class="nav-item nav-link">Register</a>
                    <a id="login_button" href="login_form.php" class="nav-item nav-link">Login</a>
                    <a id="user_id_text" href="UserAccountPage.php" class="nav-item nav-link"><?php echo $session_id;?></a>
                    <a id="logout_button" href="signout.php" class="nav-item nav-link">Logout</a>
                </div>
            </div>
        </nav>

        <div class ="container ">
            </br>
            <h2 align ="center">Enrolled Student Details</h2>
           
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Unit Code</th>
                        <th>Student tutorial allocation (Student ID / Day / TIme)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        include ('db_conn.php');

                        if ($session_access != 2 ){
                            $query = "SELECT unit_code FROM staff_role WHERE staff_id='$session_id' ORDER BY unit_code ASC";
                        } else if ($session_access == 2){
                            $query = "SELECT unit_code FROM staff_role GROUP BY unit_code ASC";
                        }
                        
                        $result = $mysqli->query($query);

                        if (!$result) {
                            echo("Error description: " . $mysqli -> error);
                        }  
                        while ($row = $result->fetch_assoc()) {
                            
                            $unit_code = $row["unit_code"]; 
                    
                            echo '<tr> 
                                    <td>'.$unit_code.'</td> 
                                    <td><table class="table table-borderless">
                                        <tbody>';
                                    
                                    // each student and tutorial time
                                    // if (!$mysqli -> query("SELECT * FROM staff_role WHERE staff_id='$staff_id'")) {

                                    if (!$mysqli -> query("SELECT tut_allocation.student_id, unit_allocation.class_day, unit_allocation.class_time
                                        FROM unit_allocation INNER JOIN tut_allocation 
                                        ON unit_allocation.ID = tut_allocation.tut_class_id AND unit_code = '$unit_code'
                                        ORDER BY unit_code, FIELD(class_day,'Monday','Tuesday','Wednesday', 'Thursday', 'Friday'), class_time"))
                                    {
                                        echo("Error description: " . $mysqli -> error);
                                    
                                    } else {
                                        // // get roles
                                        $query = "SELECT tut_allocation.student_id, unit_allocation.class_day, unit_allocation.class_time
                                        FROM unit_allocation INNER JOIN tut_allocation 
                                        ON unit_allocation.ID = tut_allocation.tut_class_id AND unit_code = '$unit_code'
                                        ORDER BY unit_code, FIELD(class_day,'Monday','Tuesday','Wednesday', 'Thursday', 'Friday'), class_time";
                                        $result_roles = $mysqli->query($query);

                                        if (!$result_roles) {
                                        echo("Error description: " . $mysqli -> error);
                                        }  
                                        
                                        $result_num = $result_roles->num_rows;
                                
                                        if ($result_num != 0) {

                                            while ($row = $result_roles->fetch_assoc()) {
                                                $student_id = $row["student_id"];
                                                $class_day = $row["class_day"];
                                                $class_time = $row["class_time"];

                                                echo'<tr>
                                                        <td>'.$student_id.'</td>
                                                        <td>'.$class_day.'</td>
                                                        <td>'.$class_time.'</td>
                                                    </tr>
                                                    ';
                                            }
                                        } else if ($result_num == 0){
                                            echo 'No record.';
                                        }
                                        
                                    }
                                

                            echo'           </tbody>
                                        </table>
                                    </td>
                                </tr>';
                        
                        }
                    
                        $mysqli->close();
                    ?>
                </tbody>
            </table>
        </div>


        <div id="modalId" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document"> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Unavailability</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button> 
                    </div>
                    <div class="modal-body">
                        <div id="result_div" style="padding: 0px 20px;">
                            <label id="output" for="keyword"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="close" type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="allocateDialog" class="modal hide" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document"> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Staff Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button> 
                    </div>
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="selected_staff_id">Selected Staff ID</label>
                                <input name="selected_staff_id" type="text" class="custom-select form-control" id="selected_staff_id" value="" disabled/>
                            </div>                    
                            <div class="form-group">
                                <label for="unit_code">Unit Code</label>
                                <select name="unit_code" class="custom-select form-control" id="unit_code" required>
                                    <?php 
                                        include ('db_conn.php');
                                        // query for selecting / retrieving every row from the table customer
                                        $query = "SELECT * FROM `units` ORDER BY `ID` ASC";
                                        // query() <-function to execute the query in the database
                                        $result = $mysqli->query($query);

                                        if (!$result) {
                                            echo("Error description: " . $mysqli -> error);
                                            }  

                                            while ($row = $result->fetch_assoc()) {
                                                // $field1name = $row["id"];
                                                $unit_code = $row["unit_code"];
                                                echo '<option value="'.$unit_code.'">'.$unit_code.'</option>';
                                            }
                                        $mysqli->close();
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <!-- <input type="text" class="form-control" id="class_type" required > -->
                                <select name="role" class="custom-select form-control" id="role" required>
                                    <option value="Lecturer">Lecturer</option>
                                    <option value="Tutor">Tutor</option>
                                    <option value="Unit Coordinator">Unit Coordinator</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="campus">Campus</label>
                                <!-- <input type="text" class="form-control" id="class_type" required > -->
                                <select name="campus" class="custom-select form-control" id="campus">
                                    <option value=""> </option>
                                    <option value="Pandora">Pandora</option>
                                    <option value="Rivendell">Rivendell</option>
                                    <option value="Neverland">Neverland</option>
                                </select>
                            </div>
                            <button id="assign_submit" type="submit" class="btn btn-success">Assign</button>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button id="close_" type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div id="modalId2" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document"> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Staff</h5>
                    </div>
                    <div class="modal-body">
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
                                <div class="invalid-feedback">Please enter a valid password. </br> 
                                    The password should be 6 to 12 characters in length /
                                     Contains at least 1 lower case letter, 1 upper case letter, 
                                     1 number and 1 of following special characters ! @ # $ % ^ </div>
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
                                    <option value="1" selected="selected">Staff</option>
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
                        <!-- Hidden Value -->
                        <input name="add_by_dc" type="hidden" value="add_by_dc" id="add_by_dc">
                        <div class="form-group row">
                            <div class="col-sm-9 offset-sm-3">
                                <input name="submit" type="submit" class="btn btn-primary submitButton" value="Submit">
                            </div>
                        </div>
                    </form>
                        
                    </div>
                </div>
            </div>
        </div>
        
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

            $(document).ready(function(){
                // click and show the Unavailability for the staff
                $(".showUnavailability_button").click(function(){
                    
                    $("#output").empty();
                    var staff_id = $(this).attr('id');
                    var action = "view";

                    // send the data 'username' as username to checker.php and execute the following function (if the data sending is successful)
                    $.get( "view_edit_unavailability.php", { action: action, staff_id: staff_id} )
                    .done(function( data ) {
                        $("#output").html(data);
                    });

                    $('#modalId').modal('show'); 
                });

                // Stop user from choosing campus if the role is Unit Coordinator
				$('#role').on('change', function() {
					if(this.value == "Unit Coordinator") {
                        // alert("Coordinator");
                        $('#campus').val("");
                        $('#campus').prop("disabled", true);
					} else {
                        // alert("Not Coordinator");
                        $('#campus').prop("disabled", false);
					}
                });
                
                // Allocate role to staff 
                    // 1) Open the Allocate Dialog (and pass the selected class ID)
                    $(document).on("click", ".open-AllocateDialog", function () {
                        var staff_Id = $(this).data('id');
                        $(".modal-body #selected_staff_id").val( staff_Id );
                    });
            
                    // 3) Submit and allocate to class
                    $("#assign_submit").click(function(){

                        if($("#selected_staff_id").val()==""){
                            alert("Please select selected_staff_id");  
                        }else if($("#unit_code").val()==""){
                            alert("Please select unit_code."); 
                        }else if(($("#campus").val()=="") && $("#role").val()!="Unit Coordinator"){
                            alert("Please select campus."); 
                        }else if($("#role").val()==""){
                            alert("Please select role."); 
                        }else{

                            // get the value of username field and assign as username.
                            var selected_staff_id = $("#selected_staff_id").val();
                            var unit_code = $("#unit_code").val();
                            var role = $("#role").val();
                            var campus = $("#campus").val();
                            action = "assign";

                            // to assign role
                            $.post( "manage_role_engine.php", { action: action, selected_staff_id: selected_staff_id, unit_code: unit_code, role: role, campus: campus} )
                            .done(function( data ) {
                                    // print the data (output of checker.php) as a label for 'username' id='output'
                                    // $("#output").html(data);
                                    alert (data);
                                    location.reload();
                            });
                        }
                    });

                // delete role
                $('.delete_role_button').click(function(){
                    record_id = $(this).attr('id');
                    action = "delete";
                    
                    $.post( "manage_role_engine.php", { record_id: record_id, action: action} )
                    .done(function( data ) {
                        alert (data);
                        location.reload();
                    });
                });

                // Remove "staff details" and "roles info" and "time allocation data"
                $('.remove_staff_button').click(function(){
                    selected_staff_id = $(this).attr('title');
                    action = "remove_staff_data";
                    
                    $.post( "manage_role_engine.php", { selected_staff_id: selected_staff_id, action: action} )
                    .done(function( data ) {
                        alert (data);
                        location.reload();
                    });
                });

                var email_reg = /\w+[@]{1}\w+[.]\w+/;
			    var passwd_reg =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^])[^]{6,12}$/;
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
						alert("Staff Added!");
					} else {
						e.preventDefault();
					}
				});

                
                
                
            });
        </script>
    </body>  



</html>  
