<?php 
    include ('db_conn.php');
    $id = $_POST["id"];
    $student_id = $_POST["student_id"];
    $action = $_POST["action"];
    $unit_code = $_POST["unit_code"];
    // $semester = $_POST["semester"]; 


    // to check if already enrolled or not
    $query = "SELECT * FROM unit_enroll WHERE student_id='$student_id' AND unit_code='$unit_code'";
    $result = $mysqli->query($query);
    $row = $result->fetch_array(MYSQLI_ASSOC);


    if ($action == 'enroll') {
        // Unit already enrolled by this student
        if($row['unit_code']!=$unit_code){
            if (!$mysqli -> query("INSERT INTO unit_enroll (id, student_id, unit_code) VALUES ('', '$student_id', '$unit_code')")) {
                // if (!$mysqli -> query("INSERT INTO unit_enroll (id, student_id, unit_code, semester) VALUES ('', '$student_id', '$unit_code', '$semester')")) {
                        echo("Error description: " . $mysqli -> error);
                    } else {
                        echo ( "Enrolled!" );
                    } 
        } else {
            echo ( "Unit already enrolled!" );
        }
       

    } else if ($action == 'delete') {

        $query = "DELETE FROM unit_enroll WHERE ID = '$id'";
        $result = $mysqli->query($query);

        if (!$result) {
                echo("Error description: " . $mysqli -> error);
            }  else {
                echo ( "Enrollment cancelled! id=". $id);
            } 
    } else {
        echo "elseeeeee";
    }
?>