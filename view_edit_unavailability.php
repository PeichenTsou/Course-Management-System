<?php 
    include ('db_conn.php');

    $staff_id=$_GET["staff_id"];
    $action=$_GET["action"];

    $id=$_GET["id"];
    $day=$_GET["day"];
    $time=$_GET["time"];

    // $id=$_POST["id"];
    // $day=$_POST["day"];
    // $time=$_POST["time"];
    // $action=$_GET["action"];
    // echo ( $id );
    // echo ( $time);
    // echo ( $day );
    
    
    if ($action == 'view') {
        $query = "SELECT * FROM staff_unavailability WHERE staff_id='$staff_id'";
        $result = $mysqli->query($query);

        if (!$result) {
            echo("Error description: " . $mysqli -> error);
        }  
        $result_num = $result->num_rows;

        if ($result_num != 0) {
            // echo ("We found ".$result->num_rows." unavailable time(s)" );

            $table_toprint = '<table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>';

            while ($row = $result->fetch_assoc()) {

                $id = $row["ID"];
                $staff_id = $row["staff_id"];
                $day = $row["day"];
                $time = $row["time"];
                
                $table_toprint = $table_toprint .  '
                        <tr> 
                            <td>'.$day.'</td> 
                            <td>'.$time.'</td> 
                        </tr>
                    ';
            }

            $table_toprint = $table_toprint . '</tbody>
                                            </table>';
            echo $table_toprint;

        } else {
            echo 'No result.';
        }
    } else if ($action == 'add') {

        /////

        // check if the unavalibility already existed
        $query = "SELECT * FROM staff_unavailability WHERE staff_id='$staff_id' AND day='$day' AND time='$time'";
        $result = $mysqli->query($query);

        if (!$result) {
            echo("Error description: " . $mysqli -> error);
        }

        $result_num = $result->num_rows;

        if ($result_num != 0) { 
            echo ( "Unavalibility already existed" );

        } else if($result_num == 0) {
            
            if (!$mysqli -> query("INSERT INTO staff_unavailability (ID, staff_id, day, time) 
                VALUES ('', '$staff_id', '$day', '$time')")) 
            {
                echo("Error description: " . $mysqli -> error);
            } else {
                echo ( "Unavalibility added!" );
            }
        }

    } else if ($action == 'edit') {

        $query = "UPDATE staff_unavailability
                SET time = '$time',
                    day = '$day'
                WHERE ID = '$id'";

        $result = $mysqli->query($query);

        if (!$result) {

                echo("Error description: " . $mysqli -> error);
            }  else {
                echo ( "Edited!" );
            } 

    }else if ($action == 'delete') {

        $query = "DELETE FROM staff_unavailability WHERE id = '$id'";
        $result = $mysqli->query($query);

        if (!$result) {
                echo("Error description: " . $mysqli -> error);
            }  else {
                echo ( "deleted!" );
            } 
    }


    
?>