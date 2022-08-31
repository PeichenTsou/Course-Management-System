<?php
//include the file session.php
include("session.php");
//db connection
include('db_conn.php'); 

//check if login
//if the session for username has been set, automatically go to "signin_main.php"
// if ($session_id==""){
// 	header('Location: UDW_homePage.php');
// }

//check if have access right - Degree Coordinator (DC)
//if the session for access is not 2 (DC), automatically go to "signin_main.php"
// if($session_access!=2) {
//     header('Location: ./UDW_homePage.php?error=You don not have access right');
// }

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
                    <a id="unitlist_button" href="MasterList_Unit.php" class="nav-item nav-link active">Unit List</a>
               </div>
                <div class="navbar-nav ml-auto">
                    <!-- <a id="register_button" href="02_RegistrationPage.html" class="nav-item nav-link">Register</a> -->
                    <!-- <a id="login_button" href="#" class="nav-item nav-link">Login</a> -->
                    <a id="logout_button" href="signout.php" class="nav-item nav-link">Logout</a>
                </div>
            </div>
        </nav>

        <div class ="container show_staff">
        <br>
        <h2 align ="center">Unavalibility List</h2>

            <table id="table_id" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Day</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
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
                        $mysqli->close();
                    ?>
                </tbody>
            </table>
            <span style="color: red;"> * Time must start on the hour or half-hour</span>
            <div class="" align ="right">
                <button type="button" class="btn btn-primary create_button" data-toggle="modal" data-target="#modalId2" onclick="showModalAddUnit()"> Add Unavalibility</button>
            </div>
        </div>
        
        <div id="modalId2" class="modal" tabindex="-1" role="dialog">
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
                                    <option value="09:00">09:00</option>
                                    <?php 
                                        for ($hour = 10; $hour <= 18; $hour++) {
                                            echo '<option value="'.$hour.':00">'.$hour.':00</option>';
                                            echo '<option value="'.$hour.':30">'.$hour.':30</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <button id="new_unavalibility_submit" type="submit" class="btn btn-success">Add</button>
                            <button id="close_new_unit" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        <script>

            $(document).ready(function(){

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
            });

        </script>
    </body>  



</html>  
