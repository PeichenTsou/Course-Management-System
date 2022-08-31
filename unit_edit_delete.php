<?php 
    include ('db_conn.php');

    $id = $_POST["id"];
    $action = $_POST["action"];

    $unit_code = $_POST["unit_code"];
    $unit_name = $_POST["unit_name"];
    $lecturer = $_POST["lecturer"];
    $semester = $_POST["semester"]; 
    $campus = $_POST["campus"]; 
    $description = $_POST["description"]; 

    if ($action == 'edit') {

        $query = "UPDATE units
        SET id = '$id',
            unit_code = '$unit_code',
            unit_name = '$unit_name',
            lecturer = '$lecturer',
            semester = '$semester',
            campus = '$campus',
            description = '$description'

        WHERE id = '$id'";
        $result = $mysqli->query($query);

        if (!$result) {
                echo("Error description: " . $mysqli -> error);
            }  else {
                echo ( "Edited!" );
            } 
    } else if ($action == 'delete') {

        $query = "DELETE FROM units WHERE id = '$id'";
        $result = $mysqli->query($query);

        if (!$result) {
                echo("Error description: " . $mysqli -> error);
            }  else {
                echo ( "deleted!" );
            } 
    } else {
        echo "elseeeeee";
    }
?>