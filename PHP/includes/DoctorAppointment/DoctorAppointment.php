<?php

    //Class to add doctor appointment
    class DoctorAppointment{
		
		//Create Prescription
		public static function create_prescription($DoctorNote,$Diagnosis)
		{
			global $connection;
			$stmt = $connection->prepare("INSERT INTO Prescription VALUES(0, :DoctorNote, :Diagnosis)");
			$stmt->bindParam(':DoctorNote', $DoctorNote);
			$stmt->bindParam(':Diagnosis', $Diagnosis);
			$stmt->execute();
			return $connection->lastInsertId();
		}
		
		//Create Doctor Appointment
		public static function create_doctor_appointment($AppointmentID,$PrescriptionID)
		{
			global $connection;
			$stmt = $connection->prepare("UPDATE DoctorAppointment SET DoctorAppointment.PrescriptionID = :PrescriptionID WHERE DoctorAppointment.DoctorAppointmentID = :AppointmentID");
			$stmt->bindParam(':AppointmentID', $AppointmentID);
			$stmt->bindParam(':PrescriptionID', $PrescriptionID);
			$stmt->execute();
			return $connection->lastInsertId();
		}
		
		public static function retrieve_doctor_appointmentID($AppointmentID){
            global $connection;
			$stmt = $connection->prepare("SELECT DoctorAppointmentID FROM DoctorAppointment WHERE DoctorAppointment.AppointmentID = :AppointmentID"); 
            $stmt->bindParam(':AppointmentID', $AppointmentID);
            $stmt->execute();
            $row = $stmt->fetch();
			return $row["DoctorAppointmentID"];
        }	
		
		//Create Doctor Appointment
		public static function retrive_doctor_appointment($AppointmentID)
		{
			global $connection;
			$stmt = $connection->prepare("SELECT Prescription.DoctorsNote, Prescription.Diagnosis
										  FROM DoctorAppointment, Prescription
										  WHERE DoctorAppointment.DoctorAppointmentID = :AppointmentID AND
												DoctorAppointment.PrescriptionID=Prescription.PrescriptionID");
			$stmt->bindParam(':AppointmentID', $AppointmentID);
			$stmt->execute();
			return $stmt->fetchAll();
		}
    }
?>