<?php
    include_once ("../database/database_connect.php");
    include_once ('Reports.php');
    if(isset($_POST["Start_Date"], $_POST["End_Date"]) && !empty($_POST["Start_Date"]) && !empty($_POST["End_Date"])){
        $StartDate = $_POST["Start_Date"];
        $EndDate = $_POST["End_Date"];
        if(isset($_POST["Doctor"])){
            $DoctorID = $_POST["Doctor"];
            $Availabilities = Reports::doctor_availabilities($DoctorID, $StartDate, $EndDate);
?>
            <h2>Availabilities for selected Doctor</h2>
            <table class="table well">
                <thead>
                    <tr>
                        <th>Available Dates</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($Availabilities as $Availabilitie) { ?>
                        <tr>
                            <td><?= $Availabilitie ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

<?php
        }
        elseif(isset($_POST["Therapist"])){
            $TherapistID = $_POST["Therapist"];
            $Availabilities = Reports::therapist_availabilities($TherapistID, $StartDate, $EndDate);
?>
            <h2>Availabilities for selected Therapist</h2>
            <table class="table well">
                <thead>
                    <tr>
                        <th>Available Dates</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($Availabilities as $Availabilitie) { ?>
                        <tr>
                            <td><?= $Availabilitie ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>


<?php
        }
        else{
            echo "Missing fields";
        }
    }
    else{
        echo "Date fields reqired";
    }
?>