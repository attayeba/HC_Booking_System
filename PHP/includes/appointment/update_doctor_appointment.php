<?php
    include_once ("../database/database_connect.php");
    include_once ("Appointment.php");
    if(isset($_POST["AppointmentID"], $_POST["Appointment_Date"], $_POST["DoctorID"], $_POST["PatientID"])){
        $AppointmentID = $_POST["AppointmentID"];
        $AppointmentDate = $_POST["Appointment_Date"];
        $DoctorID = $_POST["DoctorID"];
        $PatientID = $_POST["PatientID"];
        
        Appointment::update_doctor_appointment($AppointmentID, $AppointmentDate, $DoctorID);
?>
    <script>
        window.location.replace("patient_appointments.php?PatientID=<?= $PatientID; ?>");
    </script>
<?php
    }   
    else{
        echo "Doctor and Appointment Date are required";
    }
?>