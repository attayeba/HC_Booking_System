<?php
    include_once ("../database/database_connect.php");
    include_once ('Reports.php');
    if(isset($_POST["Start_Date"], $_POST["End_Date"])){
        $TherapistPatients = Reports::num_therapist_patients($_POST["Start_Date"], $_POST["End_Date"]);
?>
    <table class="table">
        <thead>
            <tr>
                <th>Therapist ID</th>
                <th>Therapist Name</th>
                <th>Number Of Patients</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach($TherapistPatients as $TherapistPatient) { ?>
                <tr>
                    <td><?= $TherapistPatient["TherapistID"]; ?></td>
                    <td><?= $TherapistPatient["Therapist_Name"]; ?></td>
                    <td><?= $TherapistPatient["Number_Of_Patients"]; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
    }
    else{
        echo "Missing fields";
    }
?>