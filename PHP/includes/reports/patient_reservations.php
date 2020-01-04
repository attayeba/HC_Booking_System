<?php
    session_start();
    set_include_path("/COMP353-Project/PHP/includes");
    if(!isset($connection)){
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/COMP353-Project/PHP/includes/database/database_connect.php");
    }
    
    include_once($_SERVER["DOCUMENT_ROOT"] . '/COMP353-Project/PHP/includes/authentication/AccessRights.php');

    include_once ('Reports.php');
    if(isset($_POST["Patient"])){
        $PatientID = $_POST["Patient"];
        $DoctorReservations = Reports::patient_doctor_reservations($PatientID);
        $TherapistReservations = Reports::patient_therapist_reservations($PatientID);
?>
        <div class="row">
            <div class="col-md-6">
                <h2>Doctor Appointments</h2>
                <table class="table well">
                    <thead>
                        <tr>
                            <th>Doctor ID</th>
                            <th>Doctor Name</th>
                            <th>Appointment Date</th>
                            <?php if(AccessRights::require_admin_receptionist_access()): ?>
                            <th>Make Payment</th>
                            <th>Update</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($DoctorReservations as $DoctorReservation) { ?>
                            <tr>
                                <td><?= $DoctorReservation["DoctorID"]; ?></td>
                                <td><?= $DoctorReservation["Doctor_Name"]; ?></td>
                                <td><?= $DoctorReservation["Appointment_Date"]; ?></td>
                                <?php if(AccessRights::require_admin_receptionist_access()): ?>
                                <td><a class="btn btn-primary" href="Payment.php?AppointmentID=<?= $DoctorReservation["AppointmentID"];?>">Make Payment</a></td>
                                <td><a class="btn btn-info" href="update_appointment.php?AppointmentID=<?= $DoctorReservation["AppointmentID"];?>&Type=Doctor&PatientID=<?= $PatientID; ?>">Update</a></td>
                                <?php endif; ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <h2>Therapist Appointments</h2>
                <table class="table well">
                    <thead>
                        <tr>
                            <th>Therapist ID</th>
                            <th>Therapist Name</th>
                            <th>Appointment Date</th>
                            <?php if(AccessRights::require_admin_receptionist_access()): ?>
                            <th>Make Payment</th>
                            <th>Update</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($TherapistReservations as $TherapistReservation) { ?>
                            <tr>
                                <td><?= $TherapistReservation["TherapistID"]; ?></td>
                                <td><?= $TherapistReservation["Therapist_Name"]; ?></td>
                                <td><?= $TherapistReservation["Appointment_Date"]; ?></td>
                                <?php if(AccessRights::require_admin_receptionist_access()): ?>
                                <td><a class="btn btn-primary" href="Payment.php?AppointmentID=<?= $TherapistReservation["AppointmentID"];?>">Make Payment</a></td>
                                <td><a class="btn btn-info" href="update_appointment.php?AppointmentID=<?= $TherapistReservation["AppointmentID"];?>&Type=Therapist&PatientID=<?= $PatientID; ?>">Update</a></td>
                                <?php endif; ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

<?php
    }
    else{
        echo "Missing fields";
    }
?>