<?php 
    $pageTitle = 'Home';
    include ('../includes/header.php'); 
    include_once ('../includes/authentication/AccessRights.php');
    include_once ('../includes/authentication/User.php');
?>
    <div id="content">
        <div class="container">
            <div class="jumbotron">
                <h1 class="text-center">Home</h1> 
                <p class="text-center">
                    Welcome <strong><?= User::get_name(); ?> (<?= User::get_user_info()->Role; ?>)</strong>.
                </p> 
                <p class="text-center">
                    Please make a selection from the list above.
                </p>
            </div>
        </div>
    </div>
<?php include('../includes/footer.php'); ?>