<?php 
    $pageTitle = 'Treatment';
    include('../includes/header.php'); 
	include_once('../includes/authentication/AccessRights.php'); 
    include_once('../includes/form/FormGenerator.php');
	include_once('../includes/database/database_connect.php');
?>

<div id="content">
    <?php
        FormGenerator::generate_form("Add Treatment", "../includes/TherapistAppointment/TreatmentRegistration.php", "Registration Succeeded",
            [
				FormGenerator::generate_element("Treatment", "text", []),
				FormGenerator::generate_element("Cost", "text", []),
				FormGenerator::generate_element("Equipment", "text", []),
            ]
        );
    ?>
</div>

<?php include('../includes/footer.php'); ?>