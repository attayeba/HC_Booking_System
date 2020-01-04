<?php 
    $pageTitle = 'Equipment';
    include('../includes/header.php'); 
	include_once('../includes/authentication/AccessRights.php'); 
    include_once('../includes/form/FormGenerator.php');
?>

<div id="content">
    <?php
        FormGenerator::generate_form("Equipment Registration", "../includes/Equipment/EquipmentRegistration.php", "Registration Succeeded",
            [
                FormGenerator::generate_element("Name", "text", [])
            ]
        );
    ?>
</div>

<?php include('../includes/footer.php'); ?>