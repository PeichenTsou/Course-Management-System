<?php 
    include ('db_conn.php');
    $id = $_POST["id"];
    $student_id = $_POST["student_id"];
    $action = $_POST["action"];
    $class_id = $_POST["class_id"];

    // echo ( $student_id );
    // echo ( $action );
    // echo ( $class_id );
    if ($action == 'allocate') {

        // check if already allocated tutorial for the unit

        // // $query = "SELECT unit_allocation.unit_code AS unit_code FROM unit_allocation 
        // // INNER JOIN tut_allocation ON unit_allocation.ID = tut_allocation.tut_class_id 
        // // AND tut_allocation.student_id = '$student_id' AND tut_allocation.tut_class_id = '$class_id'";
        
        // $query = "SELECT tut_allocation.ID, unit_allocation.unit_code, unit_allocation.class_day, unit_allocation.class_time
        //         FROM unit_allocation INNER JOIN tut_allocation 
        //         ON unit_allocation.ID = tut_allocation.tut_class_id AND student_id = '$session_id'
        //         ORDER BY unit_code, FIELD(class_day,'Monday','Tuesday','Wednesday', 'Thursday', 'Friday'), class_time";
                        

        // $result = $mysqli->query($query);
        // if (!$result) {
        //     echo("Error description: " . $mysqli -> error);
        // }  
        // // $row = $result->fetch_assoc();
        // $row=$result->fetch_array(MYSQLI_ASSOC);
        // $unit_code = $row["unit_code"];

        // echo('unit_code="'.$unit_code.'"');

        // // if ($unit_code == ""){
        // //     echo("unit_code=".$unit_code);

        // //     if (!$mysqli -> query("INSERT INTO tut_allocation (id, student_id, tut_class_id) VALUES ('', '$student_id', '$class_id')")) {
        // //         echo("Error description: " . $mysqli -> error);
        // //     } else {
        // //         echo ( "Allocated!" );
        // //     } 

        // // } else {
        // //     echo("Already allocated tutorial for the unit.");
        // // }
        

//


        // check if the tute allocation already existed
        $query = "SELECT * FROM tut_allocation WHERE student_id='$student_id' AND tut_class_id='$class_id'";

        $result = $mysqli->query($query);

        if (!$result) {
            echo("Error description: " . $mysqli -> error);
        }
        $result_num = $result->num_rows;

        if ($result_num != 0) { 
            echo ( "Already allocated same tutorial!" );

        } else if($result_num == 0) {
            
            if (!$mysqli -> query("INSERT INTO tut_allocation (id, student_id, tut_class_id) VALUES ('', '$student_id', '$class_id')")) {
                echo("Error description: " . $mysqli -> error);
            } else {
                echo ( "Allocated!" );
            } 
        }

    } else if ($action == 'delete') {
        
        $query = "DELETE FROM tut_allocation WHERE ID = '$id'";
        $result = $mysqli->query($query);

        if (!$result) {
                echo("Error description: " . $mysqli -> error);
            }  else {
                echo ( "Deleted! id=". $id);
            } 
    } else {
        echo "???!!!!";
    }

//////



    // // to check if already allocated or not
    // $query = "SELECT * FROM tut_allocation WHERE student_id='$student_id' AND tut_class_id='$class_id'";
    // $result = $mysqli->query($query);
    // $row = $result->fetch_array(MYSQLI_ASSOC);

    // if ($action == 'allocate') {
    //     // Unit already enrolled by this student
    //     if($row['tut_class_id']!=$class_id){
    //         if (!$mysqli -> query("INSERT INTO unit_enroll (id, student_id, tut_class_id) VALUES ('', '$student_id', '$class_id')")) {
    //                     echo("Error description: " . $mysqli -> error);
    //                 } else {
    //                     echo ( "Allocated!" );
    //                 } 
    //     } else {
    //         echo ( "Already allocated same tutorial!" );
    //     }
       

    // } else if ($action == 'delete') {

    //     $query = "DELETE FROM unit_enroll WHERE ID = '$id'";
    //     $result = $mysqli->query($query);

    //     if (!$result) {
    //             echo("Error description: " . $mysqli -> error);
    //         }  else {
    //             echo ( "Enrollment cancelled! id=". $id);
    //         } 
    // } else {
    //     echo "elseeeeee";
    // }
?>