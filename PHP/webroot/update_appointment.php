<?php 
    $pageTitle = 'Update Appointment';
    include ('../includes/header.php'); 
    include_once ('../includes/authentication/AccessRights.php');
    include_once ('../includes/authentication/User.php');
    include_once ('../includes/appointment/Appointment.php');
    include_once ('../includes/form/FormGenerator.php');
    AccessRights::verify_admin_receptionist();
    if(isset($_GET["AppointmentID"], $_GET["Type"], $_GET["PatientID"]) && !empty($_GET["AppointmentID"]) && !empty($_GET["Type"]) && !empty( $_GET["PatientID"])){
        $AppointmentID = $_GET["AppointmentID"];
        $Type = $_GET["Type"];
        $PatientID =  $_GET["PatientID"];
        
        if($Type == "Doctor"){
            $Appointment = Appointment::get_patient_doctor_appointment($AppointmentID);
            $DoctorID = $Appointment[0]["DoctorID"];
            $Doctors = User::retrieve_doctors();
            $Doctors_Select = array();
            foreach($Doctors as $Doctor){
                $temp = [$Doctor["DoctorID"], $Doctor["First_Name"] . " " . $Doctor["Last_Name"]];
                if($Doctor["DoctorID"] == $DoctorID){
                    array_push($temp, $Doctor["DoctorID"]);
                }
                array_push($Doctors_Select, $temp);
            }
            FormGenerator::generate_form("Update Doctor Appointment", "../includes/appointment/update_doctor_appointment.php","",
            [
                FormGenerator::generate_element("Appointment_Date", "date", [$Appointment[0]["Appointment_Date"]]),
                FormGenerator::generate_element("DoctorID", "select", $Doctors_Select),
                FormGenerator::generate_element("AppointmentID", "hidden", [$AppointmentID]),
                FormGenerator::generate_element("PatientID", "hidden", [$PatientID])
            ]);
        }
        else{ //Therapist
            $Appointment = Appointment::get_patient_therapist_appointment($AppointmentID);
            $TherapistID = $Appointment[0]["TherapistID"];
            $Therapists = User::retrieve_therapists();
            $Therapists_Select = array();
            foreach($Therapists as $Therapist){
                $temp = [$Therapist["TherapistID"], $Therapist["First_Name"] . " " . $Therapist["Last_Name"]];
                if($Therapist["TherapistID"] == $TherapistID){
                    array_push($temp, $Therapist["TherapistID"]);
                }
                array_push($Therapists_Select, $temp);
            }
            FormGenerator::generate_form("Update Therapist Appointment", "../includes/appointment/update_therapist_appointment.php","",
            [
                FormGenerator::generate_element("Appointment_Date", "date", [$Appointment[0]["Appointment_Date"]]),
                FormGenerator::generate_element("TherapistID", "select", $Therapists_Select),
                FormGenerator::generate_element("AppointmentID", "hidden", [$AppointmentID]),
                FormGenerator::generate_element("PatientID", "hidden", [$PatientID])
            ]);
        }
?>

        <div id="content">
            
        </div>

<?php 
    }
    include('../includes/footer.php'); 
?>