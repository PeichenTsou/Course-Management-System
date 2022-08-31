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
if($session_access!=2) {
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

        <div class ="container">
        <br>
        <h2 align ="center">Master Unit List</h2>

            <div class="row">
                <div class="col align-self-end" align ="right">
                    <button type="button" class="btn btn-light active" data-toggle="modal" data-target="#modalId" onclick="showModal()"> Search </button>
                </div>
            </div>
            <table id="table_id" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Unit Code</th>
                        <th>Unit Name</th>
                        <!-- <th>Lecturer</th> -->
                        <th>Semester</th>
                        <th>Campus</th>
                        <th>Unit Description</th>
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
                                $field1name = $row["id"];
                                $field2name = $row["unit_code"];
                                $field3name = $row["unit_name"];
                                // $field4name = $row["lecturer"];
                                $field5name = $row["semester"]; 
                                $field6name = $row["campus"]; 
                                $field7name = $row["description"]; 
                        
                                echo '<tr> 
                                        <td class="id">'.$field1name.'</td> 
                                        <td>'.$field2name.'</td> 
                                        <td>'.$field3name.'</td> 
                                        <td>'.$field5name.'</td>  
                                        <td>'.$field6name.'</td>  
                                        <td>'.$field7name.'</td>  
                                     </tr>';

                            }
    
                        $mysqli->close();
                    ?>
                </tbody>
            </table>

            <div class="" align ="right">
                <button type="button" class="btn btn-primary create_button" data-toggle="modal" data-target="#modalId2" onclick="showModalAddUnit()"> Add New Unit </button>
            </div>
        </div>


        <div id="modalId" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document"> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Search</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button> 
                    </div>
                    <div class="modal-body">
                        <div id="search_form_div">
                            <div class="form-group">
                                    <label for="inputEmail">Search</label>
                                    <input type="text" class="form-control" id="search_input" required>
                                </div>
                                <button id="search_submit" type="button" class="btn btn-warning">Search</button>
                            </div>
                        </div>

                        <div id="search_result_div" style="padding: 0px 20px; display: none;">
                            <label id="output" for="keyword"></label>
                        </div>
                    <div class="modal-footer">
                        <button id="close" type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="modalId2" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document"> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Unit</h5>
                    </div>
                    <div class="modal-body">
                        <form action="" method="">
                            <div class="form-group">
                                <label for="unit_code">Unit Code</label>
                                <input type="text" class="form-control" id="unit_code" required>
                            </div>
                            <div class="form-group">
                                <label for="unit_name">Unit Name</label>
                                <input type="text" class="form-control" id="unit_name" required >
                            </div>
                            <!-- <div class="form-group">
                                <label for="lecturer">Lecturer</label>
                                <input type="text" class="form-control" id="lecturer" required >
                            </div> -->
                            <div class="form-group">
                                <label for="semester">Semester</label>
                                <input type="text" class="form-control" id="semester" required >
                            </div>
                            <div class="form-group">
                                <label for="campus">Campus</label>
                                <input type="text" class="form-control" id="campus" required >
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" required >
                            </div>

                            <button id="new_unit_submit" type="submit" class="btn btn-success">Add</button>
                            <button id="close_new_unit" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
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
                // Get value on button click and show alert
                $("#search_submit").click(function(){
                    // get the value of username field and assign as username.
                    var keyword = $("#search_input").val();
                    // send the data 'username' as username to checker.php and execute the following function (if the data sending is successful)
                    $.get( "search.php", { keyword: keyword} )
                    .done(function( data ) {
                            // print the data (output of checker.php) as a label for 'username' id='output'
                            if (data == '0') {
                                alert ("Don't have a record");
                            } else {
                                $("#output").html(data);
                                $( "#search_form_div" ).css("display","none");
                                $( "#search_result_div" ).css("display","block");
                            }
                    });
                });

                $("#close").click(function(){
                    $( "#search_form_div" ).css("display","block");
                    $( "#search_form" ).css("display","none");
                    $("search_result_div").empty();
                    $("#output").empty();
                    $('#search_input').val('');
                });

                ///// New Unit
                $("#new_unit_submit").click(function(){

                    if($("#unit_code").val()==""){
                        alert("Please enter unit_code");  
                    }else if($("#unit_name").val()==""){
                        alert("Please enter unit_name."); 
                    // }else if($("#lecture").val()==""){
                    //     alert("Please enter the lecture.");    
                    }else if($("#semester").val()==""){
                        alert("Please enter semester.");    
                    }else if($("#campus").val()==""){
                        alert("Please enter campus.");  
                    }else if($("#description").val()==""){
                        alert("Please enter description.");
                    }else{

                    
                        alert("You have added a unit successfully!");   
                        // get the value of username field and assign as username.
                        var unit_code = $("#unit_code").val();
                        var unit_name = $("#unit_name").val();
                        var lecturer = "";
                        // var lecturer = $("#lecturer").val();
                        var semester = $("#semester").val();
                        var campus = $("#campus").val();
                        var description = $("#description").val();
                    
                        // send the data 'username' as username to checker.php and execute the following function (if the data sending is successful)
                        $.post( "new_unit.php", { unit_code: unit_code, unit_name: unit_name, lecturer: lecturer, semester: semester, campus: campus, description: description} )
                        // $.post( "new_unit.php", { unit_code: unit_code, unit_name: unit_name, lecturer: lecturer, semester: semester, campus: campus, description: description} )
                       // $.get( "new_unit.php", { unit_code: unit_code} )
                        .done(function( data ) {
                                // print the data (output of checker.php) as a label for 'username' id='output'
                                location.reload();
                        });
                    }
                });

                $('#table_id').Tabledit({
                    url: 'tabledit.php',
                    columns: {
                        identifier: [0, 'ID'],
                        editable: [[1, 'Unit Code'], [2, 'Unit Name'], [3, 'LectSemesterurer'], [4, 'Campus'], [5, 'Description']]
                        // editable: [[1, 'Unit Code'], [2, 'Unit Name'], [3, 'Lecturer'], [4, 'Semester'], [5, 'Campus'], [6, 'Unit Description']]
                    },
                    restoreButton: false
                });

                $('.tabledit-save-button').click(function(){
                    id = $(this).closest('tr').attr('id');
                    action = "edit";
                    var unit_code;
                    var unit_name;
                    var lecturer = "";
                    var semester;
                    var campus;
                    var description;

                    var x = 0;
                    $(this).closest('tr').find("input").each(function() {
                        // alert("x="+x+", this.value="+this.value);
                        
                        if (x == 1){
                            unit_code = this.value;
                        } else if (x == 2) {
                            unit_name = this.value;
                        } else if (x == 3) {
                            semester = this.value;
                        } else if (x == 4) {
                            campus = this.value;
                        } else if (x == 5) {
                            description = this.value;
                        } 

                        x = x+1;
                    });

                    $.post( "unit_edit_delete.php", { id: id, action: action, unit_code: unit_code, unit_name: unit_name, lecturer: lecturer, semester: semester, campus: campus, description: description} )
                    .done(function( data ) {
                                alert (data);                        
                                location.reload();
                    });
                });

                $('.tabledit-confirm-button').click(function(){
                    id = $(this).closest('tr').attr('id');
                    action = "delete";

                    $.post( "unit_edit_delete.php", { id: id, action: action} )
                    .done(function( data ) {
                        alert (data);
                        location.reload();
                    });
                });
            });

        </script>
    </body>  



</html>  
