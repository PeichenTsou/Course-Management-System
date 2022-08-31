<?php 
    include('db_conn.php');
    $id = $_POST["id"];
    $action = $_POST["action"];

    $unit_code = $_POST["unit_code"];
    $class_day = $_POST["class_day"];
    $class_time = $_POST["class_time"];
    $class_location = $_POST["class_location"];
    $class_type = $_POST["class_type"];
    $class_capacity = $_POST["class_capacity"];
    
    $selected_class_id = $_POST["selected_class_id"];
    $selected_staff_id = $_POST["selected_staff_id"];
 
    if ($action == 'create') {

        // check if there is duplicate type and time (e.g. same lecture at same time)
        $query = "SELECT * FROM unit_allocation WHERE unit_code='$unit_code' AND class_day='$class_day' AND class_time='$class_time' AND class_type='$class_type'";
        $result = $mysqli->query($query);

        if (!$result) {
            echo("Error description: " . $mysqli -> error);
        }  

        $result_num = $result->num_rows;

        if ($result_num != 0) { 
            echo ( "Duplicated! Class is not added." );
            // echo ("Time Clash!");

        } else if($result_num == 0) {
            // create new class time
            if (!$mysqli -> query("INSERT INTO unit_allocation (ID, unit_code, class_day, class_time, class_location, class_type, capacity) 
                    VALUES ('', '$unit_code', '$class_day', '$class_time', '$class_location', '$class_type', '$class_capacity')")) {
                echo("Error description: " . $mysqli -> error);
            }  else {
                echo ( "You have added a class!" );
            }
        }

    } else if ($action == 'delete') {
    
        $query = "DELETE FROM unit_allocation WHERE ID = '$id'";
        $result = $mysqli->query($query);

        if (!$result) {
                echo("Error description: " . $mysqli -> error);
            }  else {
                echo ( "You have DELETE the class!" );
            } 

    } else if ($action == 'allocate') {

        // // Get the time for selected unit
        $query_getDayTime = "SELECT * FROM unit_allocation WHERE id='$selected_class_id'";
        $result_getDayTime = $mysqli->query($query_getDayTime);
        $row=$result_getDayTime->fetch_array(MYSQLI_ASSOC);

        if (!$result_getDayTime) {
            echo("Error description: " . $mysqli -> error);
        }  else {
            $selected_class_day = $row["class_day"];
            $selected_class_time = $row["class_time"];
            $selected_unit_code = $row["unit_code"];
            $selected_class_type = $row["class_type"];

            // $role_type = "";
            // switch ($selected_class_type) {
            //     case "Tutorial":
            //         $role_type = "Tutor";
            //         break;
            //     case "Lecture":
            //         $role_type = "Lecturer";
            //         break;
            //     case "Consultation":
            //         $role_type = "Consulting Staff";
            //         break;
            //     default:
            //       echo "default???";
            //   }
            
            // // check if time clashed for same staff
            $query = "SELECT * FROM unit_allocation WHERE staff_id='$selected_staff_id' AND class_day='$selected_class_day' AND class_time='$selected_class_time'";
            $result = $mysqli->query($query);
            if (!$result) {
                echo("Error description: " . $mysqli -> error);
            }  
            $result_num = $result->num_rows;

            if ($result_num != 0) { 
                echo ("Time Clash! The staff is not assigned");

            } else if($result_num == 0) {

                // // !!!!!! check if the selected staff is correct role! !!!!!!
                // if ($selected_class_type == "Consultation") { // Consaltation can be tutor or lecturer or unit coordinator (role)

                // } else if ($selected_class_type == "Lecture") { // Lecture can be Lecturer or unit coordinator (role)

                // } else if ($selected_class_type == "Tutorial") { // Tutorial can be tutor (role)
                //     $query = "SELECT * FROM staff_role WHERE unit_code='$selected_unit_code' AND staff_id='$selected_staff_id' AND role='Tutor'";
                //     $result = $mysqli->query($query);
                //     if (!$result) {
                //         echo("Error description: " . $mysqli -> error);
                //     }
                //     $result_num = $result->num_rows;

                //     if ($result_num != 0) { //Correct Role!
                //     //     echo ( "Duplicated! Class is not added." );
                //     //     // echo ("Time Clash!");

                //     } else if($result_num == 0) {
                //         echo ( "The staff is not a tutor for the unit (Please assign him  have added a class!" );
                //     //     // create new class time
                //     //     if (!$mysqli -> query("INSERT INTO unit_allocation (ID, unit_code, class_day, class_time, class_location, class_type) 
                //     //             VALUES ('', '$unit_code', '$class_day', '$class_time', '$class_location', '$class_type')")) {
                //     //         echo("Error description: " . $mysqli -> error);
                //     //     }  else {
                //     //         echo ( "You have added a class!" );
                //     //     }
                //     }
                // }

                // !!!!!! Add a role to the staff !!!!!!
                // $query = "SELECT * FROM staff_role WHERE unit_code='$selected_unit_code' AND staff_id='$selected_staff_id' AND role='Tutor'";
                // $result = $mysqli->query($query);
                // // $row=$result_getDayTime->fetch_array(MYSQLI_ASSOC);
                // // $selected_class_day = $row["class_day"];
                // // $selected_class_time = $row["class_time"];

                // // $query = "SELECT * FROM unit_allocation WHERE unit_code='$unit_code' AND class_day='$class_day' AND class_time='$class_time' AND class_type='$class_type'";
                // // $result = $mysqli->query($query);

                // if (!$result) {
                //     echo("Error description: " . $mysqli -> error);
                // }  

                // $result_num = $result->num_rows;

                // if ($result_num != 0) { 
                // //     echo ( "Duplicated! Class is not added." );
                // //     // echo ("Time Clash!");

                // } else if($result_num == 0) {
                // //     // create new class time
                // //     if (!$mysqli -> query("INSERT INTO unit_allocation (ID, unit_code, class_day, class_time, class_location, class_type) 
                // //             VALUES ('', '$unit_code', '$class_day', '$class_time', '$class_location', '$class_type')")) {
                // //         echo("Error description: " . $mysqli -> error);
                // //     }  else {
                // //         echo ( "You have added a class!" );
                // //     }
                // }


                // Allocate the staff to class
                if (!$mysqli -> query("UPDATE unit_allocation SET staff_id = '$selected_staff_id'        
                                        WHERE ID = '$selected_class_id'")) {
                    echo("Error description: " . $mysqli -> error);
                }  else {
                    echo ( "You have Allocate the staff to the class!" );
                    echo $role_type;
                }
            }
        }
    } else {
        echo ("elseeeeee");
    }
    

    $mysqli -> close();
?>


