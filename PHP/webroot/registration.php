<?php 
    $pageTitle = 'Registration';
    include ('../includes/header.php'); 
    include_once ('../includes/authentication/AccessRights.php'); 
    AccessRights::verify_admin_receptionist();
?>

<div id="content">
    <?php
        include ('../includes/authentication/registration_form.php'); 
    ?>
</div>

<?php include ('../includes/footer.php'); ?>