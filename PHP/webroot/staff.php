<?php 
    $pageTitle = 'Staff';
    include('../includes/header.php'); 
    include_once('../includes/authentication/AccessRights.php');
    include_once('../includes/authentication/User.php');
    AccessRights::verify_admin_receptionist();
    $Doctors = User::retrieve_doctors();
    $Therapists = User::retrieve_therapists();
?>
    <div id="content">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#Doctor-List">Doctor List</a></li>
            <li><a data-toggle="tab" href="#Therapist-List">Therapist List</a></li>
        </ul>
        <div class="tab-content">
            <div id="Doctor-List" class="tab-pane fade in active well">
                <table class="table well">
                    <thead>
                        <tr>
                            <th>Doctor ID</th>
                            <th>Doctor Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($Doctors as $Doctor){ ?>
                                <tr>
                                    <td><?= $Doctor["DoctorID"] ?></td>
                                    <td><?= $Doctor["First_Name"] . " " .  $Doctor["Last_Name"]; ?></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div id="Therapist-List" class="tab-pane fade well">
                <table class="table well">
                    <thead>
                        <tr>
                            <th>Therapist ID</th>
                            <th>Therapist Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($Therapists as $Therapist){ ?>
                                <tr>
                                    <td><?= $Therapist["TherapistID"] ?></td>
                                    <td><?= $Therapist["First_Name"] . " " .  $Therapist["Last_Name"]; ?></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php include('../includes/footer.php'); ?>