<?php 
    include('db_conn.php');
    $action = $_POST["action"];

    $selected_staff_id = $_POST["selected_staff_id"];
    $unit_code = $_POST["unit_code"];
    $role = $_POST["role"];
    $campus = $_POST["campus"];

    $record_id = $_POST["record_id"];

    if ($action == 'assign') {

        // Only one unit coordinator
        if ($role == 'Unit Coordinator') {

            $query = "SELECT * FROM staff_role WHERE unit_code='$unit_code' AND staff_id='$selected_staff_id'";
            $result = $mysqli->query($query);

            if (!$result) {
                echo("Error description: " . $mysqli -> error);
            }  

            $result_num = $result->num_rows;

            if ($result_num != 0) { 
                // echo("Error description: " . $mysqli -> error);
                echo ( "Unit Coordinator already existed!" );

            } else if($result_num == 0) {
                // assign role
                if (!$mysqli -> query("INSERT INTO staff_role (ID, unit_code, staff_id, role, campus) 
                        VALUES ('', '$unit_code', '$selected_staff_id', '$role', '$campus')")) {
                echo("Error description: " . $mysqli -> error);

                }  else {
                    echo ( "Unit Coordinator　Role assigned!" );
                }
            }

        } else if ($role == 'Lecturer') {
            
            // check is lecturer already exisited for the unit
            $query = "SELECT * FROM staff_role WHERE unit_code='$unit_code' AND campus='$campus' AND role='$role'";
            $result = $mysqli->query($query);

            if (!$result) {
                echo("Error description: " . $mysqli -> error);
            }

            $result_num = $result->num_rows;

            if ($result_num != 0) { 
                // echo("Error description: " . $mysqli -> error);
                echo $result_num;
                echo ( "Lecturer already existed for this campus!" );
                echo ( "unit_code=".$unit_code );
                echo ( "campus=".$campus );
                echo ( "role=".$role );

            } else if($result_num == 0) {
                // assign role
                if (!$mysqli -> query("INSERT INTO staff_role (ID, unit_code, staff_id, role, campus) 
                        VALUES ('', '$unit_code', '$selected_staff_id', '$role', '$campus')")) {
                echo("Error description: " . $mysqli -> error);
                }  else {
                    echo ( "Lecturer Role assigned!" );
                }
            }

        } else if ($role == 'Tutor') {

            // check if this staff is already the tutor for the unit at the campus
            $query = "SELECT * FROM staff_role WHERE unit_code='$unit_code' AND staff_id='$selected_staff_id' AND campus='$campus'";
            $result = $mysqli->query($query);

            if (!$result) {
                echo("Error description: " . $mysqli -> error);
            }

            $result_num = $result->num_rows;

            if ($result_num != 0) { 
                echo ( "The staff is already assigned as Tutor" );

            } else if($result_num == 0) {
                // assign role
                if (!$mysqli -> query("INSERT INTO staff_role (ID, unit_code, staff_id, role, campus) 
                        VALUES ('', '$unit_code', '$selected_staff_id', '$role', '$campus')")) {
                echo("Error description: " . $mysqli -> error);
                }  else {
                    echo ( "Tutor Role assigned!" );
                }
            }
        }

    } else if ($action == 'delete') {
    
        $query = "DELETE FROM staff_role WHERE ID = '$record_id'";
        $result = $mysqli->query($query);

        if (!$result) {
                echo("Error description: " . $mysqli -> error);
            }  else {
                echo ( "Deleted!" );
            } 

    } else if ($action == 'remove_staff_data') {

        echo("selected_staff_id: " . $selected_staff_id);
        $query_users = "DELETE FROM users_udw WHERE ID = '$selected_staff_id'";
        $result_users = $mysqli->query($query_users);

        if (!$result_users) {
                echo("3 Error description: " . $mysqli -> error);
            }  else {
                echo ( "User account deleted!" );
            } 
        
        $query_roles = "DELETE FROM staff_role WHERE staff_id = '$selected_staff_id'";
        $result_roles = $mysqli->query($query_roles);

        if (!$result_roles) {
                echo("2 Error description: " . $mysqli -> error);
            }  else {
                echo ( "Staff role data deleted! " );
            } 
        
        // $query_allocation = "DELETE FROM unit_allocation WHERE staff_id = '$selected_staff_id'";
        $query_allocation = "UPDATE unit_allocation
        SET staff_id = ''
        WHERE staff_id = '$selected_staff_id'";

        $result_allocation = $mysqli->query($query_allocation);

        if (!$result_allocation) {
                echo("1 Error description: " . $mysqli -> error);
            }  else {
                echo ( "Unit allocation data deleted!" );
            } 


    } else {
        echo ("???");
    }
    

    $mysqli -> close();
?>


