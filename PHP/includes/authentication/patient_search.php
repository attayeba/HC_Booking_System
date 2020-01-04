<?php
    include_once ("../database/database_connect.php");
    include_once ("User.php");
    $PHN = "";
    //$Type = null;
    //$Data = null;
    if(isset($_POST["PHN"]) && !empty($_POST["PHN"])){
        $UserID = $_POST["PHN"];
        $Patient = User::retrieve_patient($UserID);
        if($Patient){ 
?>
            <table class="table">
                <thead>
                    <tr>
                        <th>PHN</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Age</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= sprintf("%08d", $Patient["UserID"]); ?></td>
                        <td><?= $Patient["First_Name"]; ?></td>
                        <td><?= $Patient["Last_Name"]; ?></td>
                        <td><?= $Patient["Phone_Number"]; ?></td>
                        <td><?= $Patient["Age"]; ?></td>
                    </tr>
                </tbody>
            </table>
<?php           
        }
        else{
            echo "Patient does not exist.\n <a href='registration.php'>Register a new patient.</a>";
        }
    }
    else{
        echo "PHN is required.";
    }
?>