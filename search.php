<?php 
    include ('db_conn.php');

    $keyword=$_GET["keyword"];

    $query = "SELECT * FROM units 
        WHERE id LIKE '%{$keyword}%'
        OR unit_code LIKE '%{$keyword}%'
        OR unit_name LIKE '%{$keyword}%'
        -- OR lecturer LIKE '%{$keyword}%'
        OR semester LIKE '%{$keyword}%'
        OR campus LIKE '%{$keyword}%'
        OR description LIKE '%{$keyword}%'";

    // $mysqli is to help you to connect to mysql
    // query() <-function to execute the query in the database
    $result = $mysqli->query($query);

    if (!$result) {
        echo("Error description: " . $mysqli -> error);
        }  

        $result_num = $result->num_rows;

        if ($result_num != 0) {
            echo ("We found ".$result->num_rows." result(s)" );

            while ($row = $result->fetch_assoc()) {
                $field1name = $row["id"];
                $field2name = $row["unit_code"];
                $field3name = $row["unit_name"];
                // $field4name = $row["lecturer"];
                $field5name = $row["semester"]; 
                $field6name = $row["campus"]; 
                $field7name = $row["description"]; 

                echo '
                <table class="table table-bordered">
                    <tbody>
                        <tr> 
                            <td>ID</td> 
                            <td>'.$field1name.'</td> 
                        </tr>
                        <tr> 
                            <td>Unit Code</td> 
                            <td>'.$field2name.'</td> 
                        </tr>
                        <tr> 
                            <td>Unit Name</td> 
                            <td>'.$field3name.'</td> 
                        </tr>
                        <tr> 
                            <td>Semester</td> 
                            <td>'.$field5name.'</td> 
                        </tr>
                        <tr> 
                            <td>Campus</td> 
                            <td>'.$field6name.'</td> 
                        </tr>
                        <tr> 
                            <td>Description</td> 
                            <td>'.$field7name.'</td> 
                        </tr>
                    </tbody>
                </table>';


                // echo '
                // <table class="table table-bordered">
                //     <tbody>
                //         <tr> 
                //             <td>ID</td> 
                //             <td>'.$field1name.'</td> 
                //         </tr>
                //         <tr> 
                //             <td>Unit Code</td> 
                //             <td>'.$field2name.'</td> 
                //         </tr>
                //         <tr> 
                //             <td>Unit Name</td> 
                //             <td>'.$field3name.'</td> 
                //         </tr>
                //         <tr> 
                //             <td>Lecturer</td> 
                //             <td>'.$field4name.'</td> 
                //         </tr>
                //         <tr> 
                //             <td>Semester</td> 
                //             <td>'.$field5name.'</td> 
                //         </tr>
                //         <tr> 
                //             <td>Campus</td> 
                //             <td>'.$field6name.'</td> 
                //         </tr>
                //         <tr> 
                //             <td>Description</td> 
                //             <td>'.$field7name.'</td> 
                //         </tr>
                //     </tbody>
                // </table>';
            }
        } else {
            echo '0';
        }
?>