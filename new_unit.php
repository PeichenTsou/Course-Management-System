<?php 
    include('db_conn.php');

    $field2name = $_POST["unit_code"];
    $field3name = $_POST["unit_name"];
    $field4name = $_POST["lecturer"];
    $field5name = $_POST["semester"];
    $field6name = $_POST["campus"]; 
    $field7name = $_POST["description"]; 

    if (!$mysqli -> query("INSERT INTO units (id, unit_code, unit_name, lecturer, semester, campus, description) VALUES ('', '$field2name', '$field3name', '$field4name', '$field5name', '$field6name', '$field7name')")) {
    echo("Error description: " . $mysqli -> error);
    header('Location: ./UDW_homePage.php'); 
    }  else {
        echo ( "unit_code : ".$field2name."<br>" );
        echo ( "unit_name : ".$field3name."<br>" );
        echo ( "lecturer : ".$field4name."<br>" );
        echo ( "semester : ".$field5name."<br>" );
        echo ( "campus : ".$field6name."<br>" );
        echo ( "description : ".$field7name."<br>" );
    }

    $mysqli -> close();
?>


