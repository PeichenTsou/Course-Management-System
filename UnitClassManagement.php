<?php
//include the file session.php
include("session.php");
//db connection
include('db_conn.php'); 

if ($session_id==""){
    // check if logged in
    header('Location: ./UDW_homePage.php?error=Please login');
} else if($session_access == 0) {
    // check if user is student
    header('Location: ./UDW_homePage.php?error=You don not have access right');
} else if($session_access == 1) {
    // check if UC
    $query = "SELECT staff_id, unit_code FROM `staff_role` WHERE role = 'Unit Coordinator' AND staff_id = '$session_id'";   
    $result = $mysqli->query($query);

    if (!$result) {
        echo("Error description: " . $mysqli -> error);
    }  
    $result_num = $result->num_rows;
    
    if ($result_num != 0) {
        // echo("result_num != 0");
        } else {
        header('Location: ./UDW_homePage.php?error=You don not have access right');
    }
} else if($session_access==2) {
    // get all unit

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
                    <a id="unitMgmt_button" href="UnitClassManagement.php" class="nav-item nav-link active">Unit Management</a>
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
        <div class ="container ">
            <br>
            <h2 align ="center">Unit Management / Allocating teaching staff</h2>
            <table id="table_id" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Unit Code</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Staff ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        include ('db_conn.php');

                        if ($session_access == 2) { // UC can see his units 
                            $query = "SELECT * FROM `unit_allocation` ORDER BY unit_code, class_type, FIELD(class_day,'Monday','Tuesday','Wednesday', 'Thursday', 'Friday'), class_time ASC";
                        } else { // DC can see all units
                            $query = "SELECT * FROM `unit_allocation` WHERE unit_code IN (SELECT unit_code FROM staff_role WHERE role = 'Unit Coordinator' AND staff_id = '$session_id') ORDER BY unit_code, class_type, FIELD(class_day,'Monday','Tuesday','Wednesday', 'Thursday', 'Friday'), class_time ASC";
                        }
                        
                        // $mysqli is to help you to connect to mysql
                        // query() <-function to execute the query in the database
                        $result = $mysqli->query($query);

                        if (!$result) {
                            echo("Error description: " . $mysqli -> error);
                            }  
                            while ($row = $result->fetch_assoc()) {
                                $id = $row["ID"];
                                $unit_code = $row["unit_code"];
                                $class_day = $row["class_day"];
                                $class_time = $row["class_time"];
                                $class_location = $row["class_location"];
                                $class_type = $row["class_type"]; 
                                $class_staff_id = $row["staff_id"];
                        
                                echo '<tr> 
                                        <td>'.$id.'</td>
                                        <td>'.$unit_code.'</td>
                                        <td>'.$class_day.'</td>
                                        <td>'.$class_time.'</td>
                                        <td>'.$class_location.'</td>
                                        <td>'.$class_type.'</td>
                                        <td>'.$class_staff_id.'</td>
                                        <td>
                                            <a data-toggle="modal" data-id="'.$id.'" title="Add this item" class="btn btn-info banner_button open-AllocateDialog btn btn-primary" href="#allocateDialog">Allocate Staff</a>
                                            <hr><a id="'.$id.'"href="#" class="btn btn-danger banner_button delete_button">Delete</a>
                                        </td>
                                     </tr>';
                            }
                        $mysqli->close();
                    ?>
                </tbody>
            </table>

            <div class="" align ="right">
                 <button type="button" class="btn btn-primary create_button" data-toggle="modal" data-target="#modalId2" onclick="showModalAddUnit()"> Add New Class </button>
            </div>
        </div>

        <div id="modalId2" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document"> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Class</h5>
                    </div>
                    <div class="modal-body">
                        <form action="" method="">
                            <div class="form-group">
                                <label for="unit_code">Unit Code</label>
                                <!-- <input type="text" class="form-control" id="unit_code" required> -->
                                <select name="unit_code" class="custom-select form-control" id="unit_code" required>
                                    <!-- <option value="09:00">09:00</option> -->
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
                                <label for="class_day">Day</label>
                                <select name="class_day" class="custom-select form-control" id="class_day" required>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="class_time">Time</label>
                                <!-- <input type="text" class="form-control" id="class_time" required > -->
                                <select name="class_time" class="custom-select form-control" id="class_time" required>
                                    <option value="09:00">09:00</option>
                                    <?php 
                                        for ($hour = 10; $hour <= 18; $hour++) {
                                            echo '<option value="'.$hour.':00">'.$hour.':00</option>';
                                            echo '<option value="'.$hour.':30">'.$hour.':30</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="class_location">Location</label>
                                <input type="text" class="form-control" id="class_location" required >
                            </div>
                            <div class="form-group">
                                <label for="class_type">Type</label>
                                <!-- <input type="text" class="form-control" id="class_type" required > -->
                                <select name="class_type" class="custom-select form-control" id="class_type" required>
                                    <option value=""></option>
                                    <option value="Lecture">Lecture</option>
                                    <option value="Tutorial">Tutorial</option>
                                    <option value="Consultation">Consultation</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="class_capacity">Tutorial Capacity</label>
                                <input type="number" class="form-control" id="class_capacity" disabled >
                            </div>

                            <button id="new_class_submit" type="submit" class="btn btn-success">Add</button>
                            <button id="close_new_unit" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

        <div id="allocateDialog" class="modal hide" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document"> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Allocate Staff</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button> 
                    </div>
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="selectedClassId">Selected Class ID</label>
                                <!-- <input type="text" class="form-control" id="unit_code" required> -->
                                <!-- <select name="unit_code" class="custom-select form-control" id="unit_code" required> -->
                                <input name="selectedClassId" type="text" class="custom-select form-control" id="selectedClassId" value="" readonly/>
                            </div>
                        
                            <div class="form-group">
                                <label for="selected_staff_id">Selected Staff ID</label>
                                <input type="text" class="form-control" id="selected_staff_id" required >
                            </div>
                    
                            <table id="table_id" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Staff ID</th>
                                        <th>Name</th>
                                        <!-- <th>Qualification</th> -->
                                        <th>Expertise</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                        include ('db_conn.php');

                                        // query for selecting / retrieving every row from the table
                                        $query = "SELECT * FROM users_udw WHERE access='1'";
                                        $result = $mysqli->query($query);
                                        $row=$result->fetch_array(MYSQLI_ASSOC);
                                        
                                        // query() <-function to execute the query in the database
                                        $result = $mysqli->query($query);

                                        if (!$result) {
                                            echo("Error description: " . $mysqli -> error);
                                            }  
                                            while ($row = $result->fetch_assoc()) {
                                                $staff_id = $row["ID"];
                                                $name = $row["name"];
                                                // $password = $row["password"];
                                                // $qualification = $row["qualification"]; 
                                                $expertise = $row["expertise"]; 
                                        
                                                echo '<tr> 
                                                        <td>'.$staff_id.'</td> 
                                                        <td>'.$name.'</td> 
                                                        <td>'.$expertise.'</td>  
                                                        <td><a id="'.$staff_id.'"href="#" class="btn btn-info banner_button select_button">Select</a>
                                                        </td>
                                                    </tr>';
                                            }
                                        $mysqli->close();
                                    ?>
                                </tbody>
                            </table>

                            <button id="allocate_submit" type="submit" class="btn btn-success">Allocate</button>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button id="close_" type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
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

                // New Class
                $("#new_class_submit").click(function(){

                    if($("#unit_code").val()==""){
                        alert("Please enter unit_code");  
                    }else if($("#class_day").val()==""){
                        alert("Please enter class_day."); 
                    }else if($("#class_time").val()==""){
                        alert("Please enter class_time."); 
                    }else if($("#class_location").val()==""){
                        alert("Please enter class_location.");    
                    }else if(($("#class_capacity").val()=="") && ($("#class_type").val()=="Tutorial")){
                        alert("Please enter class_capacity.");
                    }else if($("#class_type").val()==""){
                        alert("Please enter class_type.");  
                    }else{
                        alert("????!!."); 
                        // get the value of username field and assign as username.
                        var unit_code = $("#unit_code").val();
                        var class_day = $("#class_day").val();
                        var class_time = $("#class_time").val();
                        var class_location = $("#class_location").val();
                        var class_type = $("#class_type").val();
                        var class_capacity = $("#class_capacity").val();
                        var action = "create";
                        
                        // to create class
                        $.post( "create_delete_class.php", { action: action, unit_code: unit_code, class_day: class_day, class_time: class_time, class_location: class_location, class_type: class_type, class_capacity: class_capacity} )
                        .done(function( data ) {
                                // print the data (output of checker.php) as a label for 'username' id='output'
                                // $("#output").html(data);
                                alert (data);
                                location.reload();
                        });
                        
                    }
                    alert("end."); 

                });

                // delete class 
                $('.delete_button').click(function(){
                    delete_id = $(this).attr('id');
                    action = "delete";

                    $.post( "create_delete_class.php", { id: delete_id, action: action} )
                    .done(function( data ) {
                        alert (data);
                        location.reload();
                    });
                });

                 // Allocate teaching staff 
                
                    // 1) Open the Allocate Dialog (and pass the selected class ID)
                    $(document).on("click", ".open-AllocateDialog", function () {
                        var classId = $(this).data('id');
                        $(".modal-body #selectedClassId").val( classId );

                    });
            
                    // 2) Select the staff to be allocate to class
                    $('.select_button').click(function(){
                        var selected_staff_id = $(this).attr('id');
                        $(".modal-body #selected_staff_id").val( selected_staff_id );
                    });

                    // 3) Submit and allocate to class
                    $("#allocate_submit").click(function(){

                        if($("#selectedClassId").val()==""){
                            alert("Please select ClassId");  
                        }else if($("#selected_staff_id").val()==""){
                            alert("Please select staff_id."); 
                        }else{

                            // get the value of username field and assign as username.
                            var selected_class_id = $("#selectedClassId").val();
                            var selected_staff_id = $("#selected_staff_id").val();
                            action = "allocate";
                            // alert(selected_class_id);
                            // to create class
                            $.post( "create_delete_class.php", { action: action, selected_staff_id: selected_staff_id, selected_class_id: selected_class_id } )
                            .done(function( data ) {
                                    // print the data (output of checker.php) as a label for 'username' id='output'
                                    // $("#output").html(data);
                                    alert (data);
                                    location.reload();
                            });
                        }
                    });


                    // Stop user from choosing campus if the role is Unit Coordinator
                    $('#class_type').on('change', function() {
                        if(this.value == "Tutorial") {
                            // alert("Tutorial");
                            $('#class_capacity').val("");
                            $('#class_capacity').prop("disabled", false);
                        } else {
                            // alert("Not Tutorial");
                            $('#class_capacity').prop("disabled", true);
                        }
                    });
            
            });

        </script>

    </body>  



</html>  
