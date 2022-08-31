<?php
//include the file session.php
include("session.php");
//db connection
include('db_conn.php'); 

//check if login
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
        <link rel="stylesheet" type="text/css" href="./css/05_IndividualTimetablePage.css">
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
                    <a href="IndividualTimetablePage.php" class="nav-item nav-link active">Individual Timetable</a>
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
                <h1>Individual Timetable</h1>
            </div>
        </div>

        <div class ="container">
        <br>
            <table id="table_id" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Unit Code</th>
                        <th>Class Type</th>
                        <th>Day</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        include ('db_conn.php');

                        $query_tutorial = "SELECT unit_allocation.unit_code, unit_allocation.class_type, 
                                            unit_allocation.class_day, unit_allocation.class_time FROM unit_allocation 
                                            INNER JOIN tut_allocation ON unit_allocation.ID = tut_allocation.tut_class_id 
                                            AND student_id = '$session_id' ORDER BY unit_code, FIELD(class_day,'Monday','Tuesday','Wednesday', 'Thursday', 'Friday'), class_time";
                        $result_tutorial = $mysqli->query($query_tutorial);

                        if (!$result_tutorial) {
                            echo("Error description: " . $mysqli -> error);
                            }  

                            while ($row_tutorial = $result_tutorial->fetch_assoc()) {
                                $unit_code = $row_tutorial["unit_code"];
                                $class_type = $row_tutorial["class_type"];
                                $class_day = $row_tutorial["class_day"];
                                $class_time = $row_tutorial["class_time"];
                        
                                echo '<tr> 
                                        <td>'.$unit_code.'</td> 
                                        <td>'.$class_type.'</td> 
                                        <td>'.$class_day.'</td> 
                                        <td>'.$class_time.'</td> 
                                     </tr>';
                            }

                            $query_lecture = "SELECT unit_allocation.unit_code, unit_allocation.class_type, 
                            unit_allocation.class_day, unit_allocation.class_time FROM unit_allocation 
                            INNER JOIN unit_enroll ON unit_allocation.unit_code = unit_enroll.unit_code 
                            AND student_id = '$session_id' AND unit_allocation.class_type = 'Lecture' ORDER BY unit_code, 
                            FIELD(class_day,'Monday','Tuesday','Wednesday', 'Thursday', 'Friday'), class_time
                            ";
                            $result_lecture = $mysqli->query($query_lecture);
    
                            if (!$result_lecture) {
                                echo("Error description: " . $mysqli -> error);
                                }  
    
                                while ($row_lecture = $result_lecture->fetch_assoc()) {
                                    $unit_code = $row_lecture["unit_code"];
                                    $class_type = $row_lecture["class_type"];
                                    $class_day = $row_lecture["class_day"];
                                    $class_time = $row_lecture["class_time"];
                            
                                    echo '<tr> 
                                            <td>'.$unit_code.'</td> 
                                            <td>'.$class_type.'</td> 
                                            <td>'.$class_day.'</td> 
                                            <td>'.$class_time.'</td> 
                                        </tr>';
                                }
    
                        $mysqli->close();
                    ?>
                </tbody>
            </table>
            <div id="button_div">
                <a href="UnitEnrolmentPage.php" class="btn btn-info buttons">Unit Enrollment</a>
                <a href="TutorialAllocationPage.php" class="btn btn-info buttons">Tutorial Allocation</a>
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

            
        </script>

    </body>  



</html>  
