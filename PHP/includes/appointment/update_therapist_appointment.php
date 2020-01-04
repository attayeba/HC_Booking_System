<?php
    include_once ("../database/database_connect.php");
    include_once ("Appointment.php");
    if(isset($_POST["AppointmentID"], $_POST["Appointment_Date"], $_POST["TherapistID"], $_POST["PatientID"])){
        $AppointmentID = $_POST["AppointmentID"];
        $AppointmentDate = $_POST["Appointment_Date"];
        $TherapistID = $_POST["TherapistID"];
        $PatientID = $_POST["PatientID"];
        
        Appointment::update_therapist_appointment($AppointmentID, $AppointmentDate, $TherapistID);
?>
    <script>
        window.location.replace("patient_appointments.php?PatientID=<?= $PatientID; ?>");
    </script>
<?php
    }   
    else{
        echo "Therapist and Appointment Date are required";
    }
?>