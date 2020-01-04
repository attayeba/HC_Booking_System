<?php 
    $pageTitle = 'Patient Appointments';
    include('../includes/header.php'); 
    include_once('../includes/authentication/AccessRights.php');
    include_once('../includes/authentication/User.php');
    AccessRights::verify_admin_hcp();
    if(isset($_GET["PatientID"]) && !empty($_GET["PatientID"])){
        $PatientID = $_GET["PatientID"];
        $_POST["Patient"] = $PatientID;
        $Patient = User::retrieve_patient($PatientID);
?>
        <div id="content">
            <h1 class="text-center">Appointments for <?= $Patient["First_Name"] . " " . $Patient["Last_Name"] ?> (<?= $PatientID; ?>) </h1>
            <?php
                include ("../includes/reports/patient_reservations.php");
            ?>
        </div>
<?php 
    }
    else{
        echo "Invalid Patient";
    }
    include('../includes/footer.php'); 
?>