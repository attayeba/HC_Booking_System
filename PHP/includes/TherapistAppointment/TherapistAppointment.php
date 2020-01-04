<?php

    //Class to add Therapist appointment
    class TherapistAppointment{
				
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
		
		//Create Equipment
		public static function create_equipment($Name)
		{
			global $connection;
			$stmt = $connection->prepare("INSERT INTO Equipment VALUES(0, :Name)");
			$stmt->bindParam(':Name', $Name);
			$stmt->execute();
			return $connection->lastInsertId();
		}
		
		//Create Treatment
		public static function create_treatment($EquipmentID,$Description,$Cost)
		{
			global $connection;
			$stmt = $connection->prepare("INSERT INTO Treatment VALUES(0, :EquipmentID, :Description, :Cost)");
			$stmt->bindParam(':EquipmentID', $EquipmentID);
			$stmt->bindParam(':Description', $Description);
			$stmt->bindParam(':Cost', $Cost);
			$stmt->execute();
			return $connection->lastInsertId();
		}
		
		//Create Therapist Appointment
		public static function create_therapist_appointment($TherapistAppointmentID,$PrescriptionID,$TreatmentID)
		{
			global $connection;
			$stmt = $connection->prepare("UPDATE TherapistAppointment SET TherapistAppointment.PrescriptionID=:PrescriptionID, TherapistAppointment.TreatmentID=:TreatmentID WHERE TherapistAppointment.TherapistAppointmentID=:TherapistAppointmentID");
			$stmt->bindParam(':TherapistAppointmentID', $TherapistAppointmentID);
			$stmt->bindParam(':PrescriptionID', $PrescriptionID);
			$stmt->bindParam(':TreatmentID', $TreatmentID);
			$stmt->execute();
			return $connection->lastInsertId();
		}
		
		public static function add_treatment($AppointmentID,$TherapistID,$PrescriptionID,$TreatmentID)
		{
			global $connection;
			$stmt = $connection->prepare("INSERT INTO TherapistAppointment VALUES(0,:AppointmentID,:TherapistID,:PrescriptionID,:TreatmentID)");
			$stmt->bindParam(':AppointmentID', $AppointmentID);
			$stmt->bindParam(':TherapistID', $TherapistID);
			$stmt->bindParam(':PrescriptionID', $PrescriptionID);
			$stmt->bindParam(':TreatmentID', $TreatmentID);
			$stmt->execute();
			return $connection->lastInsertId();
		}
		
		// Check  if equipment already exists
        public static function equipment_exists($Name)
		{
            global $connection;
			$stmt = $connection->prepare("SELECT Name FROM Equipment WHERE Name = :Name"); 
            $stmt->bindParam(':Name', $Name);
            $stmt->execute();
            $row = $stmt->fetch();
            return $stmt->rowCount() > 0;
        }
		
		// Check  if treatment already exists
        public static function treatment_exists($Description)
		{
            global $connection;
			$stmt = $connection->prepare("SELECT Description FROM Treatment WHERE Description = :Description"); 
            $stmt->bindParam(':Description', $Description);
            $stmt->execute();
            $row = $stmt->fetch();
            return $stmt->rowCount() > 0;
        }

		
        public static function retrieve_equipmentID($Name){
            global $connection;
			$stmt = $connection->prepare("SELECT EquipmentID FROM Equipment WHERE Name = :Name"); 
            $stmt->bindParam(':Name', $Name);
            $stmt->execute();
            $row = $stmt->fetch();
			return $row["EquipmentID"];

        }
		
		public static function retrieve_treatmentID($Description){
            global $connection;
			$stmt = $connection->prepare("SELECT TreatmentID FROM Treatment WHERE Description = :Description"); 
            $stmt->bindParam(':Description', $Description);
            $stmt->execute();
            $row = $stmt->fetch();
			return $row["TreatmentID"];
        }	
		
		public static function retrieve_appointmentID($AppointmentID){
            global $connection;
			$stmt = $connection->prepare("SELECT AppointmentID FROM TherapistAppointment WHERE TherapistAppointment.TherapistAppointmentID = :AppointmentID"); 
            $stmt->bindParam(':AppointmentID', $AppointmentID);
            $stmt->execute();
            $row = $stmt->fetch();
			return $row["AppointmentID"];
        }	
		
		public static function retrieve_therapistID($TherapistAppointmentID){
            global $connection;
			$stmt = $connection->prepare("SELECT TherapistID FROM TherapistAppointment WHERE TherapistAppointment.TherapistAppointmentID = :TherapistAppointmentID"); 
            $stmt->bindParam(':TherapistAppointmentID', $TherapistAppointmentID);
            $stmt->execute();
            $row = $stmt->fetch();
			return $row["TherapistID"];
        }
		
		public static function retrieve_therapist_appointmentID($AppointmentID){
            global $connection;
			$stmt = $connection->prepare("SELECT TherapistAppointmentID FROM TherapistAppointment WHERE TherapistAppointment.AppointmentID = :AppointmentID"); 
            $stmt->bindParam(':AppointmentID', $AppointmentID);
            $stmt->execute();
            $row = $stmt->fetch();
			return $row["TherapistAppointmentID"];
        }	
		
		public static function retrieve_therapist_appointment($TherapistAppointmentID){
            global $connection;
			$stmt = $connection->prepare("SELECT Prescription.DoctorsNote, Prescription.Diagnosis, Treatment.Description, Treatment.Cost, Equipment.Name
										  FROM TherapistAppointment, Prescription, Treatment, Equipment
										  WHERE TherapistAppointment.TherapistAppointmentID = :TherapistAppointmentID AND
											    TherapistAppointment.PrescriptionID = Prescription.PrescriptionID AND
												TherapistAppointment.TreatmentID = Treatment.TreatmentID AND
												Treatment.EquipmentID = Equipment.EquipmentID");
            $stmt->bindParam(':TherapistAppointmentID', $TherapistAppointmentID);
            $stmt->execute();
			return $stmt->fetchAll();
        }
		
    }
?>