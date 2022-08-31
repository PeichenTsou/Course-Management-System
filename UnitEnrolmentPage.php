<?php
//include the file session.php
include("session.php");
//db connection
include('db_conn.php'); 


if ($session_id==""){
    // check if logged in
    header('Location: ./UDW_homePage.php?error=Please login');
} else if($session_access != 0) {
    // check if user is student
    header('Location: ./UDW_homePage.php?error=You are not a student');
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
                    <a href="UnitEnrolmentPage.php" class="nav-item nav-link active">Unit Enrollment</a>
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
                <h1>Unit Enrollment</h1>
            </div>
        </div>

        <div class ="container ">
            <h2 align ="center">Available Unit</h2>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Unit Code</th>
                        <th>Unit Name</th>
                        <th>Semester</th>
                        <th>Campus</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        include ('db_conn.php');

                        // query for selecting / retrieving every row from the table customer
                        $query = "SELECT * FROM `units` ORDER BY `ID` ASC";

                        // $mysqli is to help you to connect to mysql
                        // query() <-function to execute the query in the database
                        $result = $mysqli->query($query);

                        if (!$result) {
                            echo("Error description: " . $mysqli -> error);
                            }  

                            while ($row = $result->fetch_assoc()) {
                                $field2name = $row["unit_code"];
                                $field3name = $row["unit_name"];
                                $field5name = $row["semester"]; 
                                $field6name = $row["campus"]; 
                        
                                echo '<tr> 
                                        <td class="unit_code_value">'.$field2name.'</td> 
                                        <td>'.$field3name.'</td> 
                                        <td>'.$field5name.'</td>  
                                        <td>'.$field6name.'<input type="hidden" value="'.$field2name.'"></td>  
                                        <td> <button type="button" class="btn btn-info banner_button enroll_button">Enroll</button></td>
                                     </tr>';
                                    //  <td> <a type="button" href="#" class="btn btn-info banner_button enroll_button">Enroll</a></td>
                            }
    
                        $mysqli->close();
                    ?>
                </tbody>
            </table>

            <h1>Enrolled units</h1>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <!-- <th>Student ID</th> -->
                        <th>Unit Code</th>
                        <th>Unit Name</th>
                        <th>Semester</th>
                        <th>Campus</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        include ('db_conn.php');
                        
                        // query for selecting / retrieving every row from the table customer
                        // $query = "SELECT * FROM `unit_enroll` WHERE student_id = $session_id ORDER BY `ID` ASC";
                        $query = "SELECT unit_enroll.ID, units.unit_code, units.unit_name, units.semester, units.campus, unit_enroll.student_id
                        FROM units INNER JOIN unit_enroll ON units.unit_code = unit_enroll.unit_code AND student_id = $session_id";
                        
                        // $mysqli is to help you to connect to mysql
                        // query() <-function to execute the query in the database
                        $result = $mysqli->query($query);

                        if (!$result) {
                            echo("Error description: " . $mysqli -> error);
                            }  

                            while ($row = $result->fetch_assoc()) {
                                $id = $row["ID"];
                                // $field2name = $row["student_id"];
                                $unit_code = $row["unit_code"];
                                $unit_name = $row["unit_name"];
                                $unit_code = $row["unit_code"];
                                $campus = $row["campus"];
                                // $field5name = $row["semester"]; 
                        
                                echo '<tr> 
                                        <td>'.$id.'</td> 
                                        <td>'.$unit_code.'</td>
                                        <td>'.$unit_name.'</td>
                                        <td>'.$unit_code.'</td>
                                        <td>'.$campus.'</td>
                                        <td> <a id="'.$id.'"href="#" class="btn btn-info banner_button cancel_enroll_button">Cancel</a>
                                        </td> 
                                    </tr>';

                            }
                    
                        $mysqli->close();
                    ?>
                </tbody>
            </table>
            
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
                // manage enrolled unit
                // add enrolled 
                $('.enroll_button').click(function(){
                    // id = $(this).closest('tr').attr('id');
                    action = "enroll";
                    var student_id = session_id;
                    var unit_code;
                    // var unit_name;
                    // var lecturer;
                    // var semester = "Spring";

                    var x = 0;
                    $(this).closest('tr').find('input').each(function() {
                        if (x == 0){
                            unit_code = this.value;
                        }
                        x = x+1;
                    });

                    // $.post( "enroll_engine.php", { student_id: student_id, action: action, unit_code: unit_code, semester: semester} )
                    $.post( "enroll_engine.php", { student_id: student_id, action: action, unit_code: unit_code} )
                    .done(function( data ) {
                                alert (data);                        
                                location.reload();
                    });

                });

                // delete enrolled unit
                $('.cancel_enroll_button').click(function(){
                    id = $(this).attr('id');
                    action = "delete";

                    $.post( "enroll_engine.php", { id: id, action: action} )
                    .done(function( data ) {
                        alert (data);
                        location.reload();
                    });
                });

            });

        </script>

    </body>  



</html>  
