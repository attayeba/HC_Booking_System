<?php
	//create function doctor,therapist function
	//get,update insert appointment
	class Appointment
	{
		public static function update_doctor_appointment($AppointmentID, $AppointmentDate, $DoctorID){
			global $connection;
			
			$sql = $connection->prepare(
			'UPDATE DoctorAppointment 
				SET DoctorID = :DoctorID
				WHERE AppointmentID = :AppointmentID'
			);
			$sql->bindParam(':DoctorID', intval($DoctorID));
			$sql->bindParam(':AppointmentID', intval($AppointmentID));
			$sql->execute();
			Appointment::update_appointment($AppointmentID, $AppointmentDate);
		}

		public static function update_therapist_appointment($AppointmentID, $AppointmentDate, $TherapistID){
			global $connection;
			
			$sql = $connection->prepare(
			'UPDATE TherapistAppointment 
				SET TherapistID = :TherapistID
				WHERE AppointmentID = :AppointmentID'
			);
			$sql->bindParam(':TherapistID', intval($TherapistID));
			$sql->bindParam(':AppointmentID', intval($AppointmentID));
			$sql->execute();
			Appointment::update_appointment($AppointmentID, $AppointmentDate);
		}

		private static function update_appointment($AppointmentID, $AppointmentDate){
			global $connection;

			$sql = $connection->prepare(
			'UPDATE Appointment 
				SET Appointment_Date = :Appointment_Date
				WHERE AppointmentID = :AppointmentID'
			);
			$sql->bindParam(':Appointment_Date', $AppointmentDate);
			$sql->bindParam(':AppointmentID', intval($AppointmentID));
			$sql->execute();
		}

		public static function get_patient_appointment_doctor($PatientID)
		{
			global $connection;
			
			$sql = $connection->prepare(
			'SELECT Appointment.AppointmentID,Appointment.Appointment_Date,UserInformation.First_Name,UserInformation.Last_Name
				FROM Appointment 
				INNER JOIN DoctorAppointment ON Appointment.AppointmentID = DoctorAppointment.AppointmentID 
				INNER JOIN Doctor ON DoctorAppointment.DoctorID = Doctor.DoctorID 
				INNER JOIN UserInformation ON Doctor.UserID = UserInformation.UserID
				WHERE Appointment.PatientID = :PatientID
				ORDER BY Appointment.Appointment_Date ASC'
			);
			$sql->bindParam(':PatientID', $PatientID);
			$sql->execute();
			return $sql->fetchAll();
		}

		public static function get_patient_doctor_appointment($AppointmentID)
		{
			global $connection;
			
			$sql = $connection->prepare(
			'SELECT Doctor.DoctorID, Appointment.AppointmentID,Appointment.Appointment_Date,UserInformation.First_Name,UserInformation.Last_Name
				FROM Appointment 
				INNER JOIN DoctorAppointment ON Appointment.AppointmentID = DoctorAppointment.AppointmentID 
				INNER JOIN Doctor ON DoctorAppointment.DoctorID = Doctor.DoctorID 
				INNER JOIN UserInformation ON Doctor.UserID = UserInformation.UserID
				WHERE Appointment.AppointmentID = :AppointmentID'
			);
			$sql->bindParam(':AppointmentID', intval($AppointmentID));
			$sql->execute();
			return $sql->fetchAll();
		}

		public static function get_doctor_patient_appointment($AppointmentID)
		{
			global $connection;
			
			$sql = $connection->prepare(
			'SELECT Appointment.AppointmentID,Appointment.Appointment_Date,UserInformation.First_Name,UserInformation.Last_Name
				FROM DoctorAppointment 
				INNER JOIN Appointment ON DoctorAppointment.AppointmentID = Appointment.AppointmentID 
				INNER JOIN Patient ON Appointment.PatientID = Patient.PatientID 
				INNER JOIN UserInformation ON Patient.UserID = UserInformation.UserID
				WHERE Appointment.AppointmentID = :AppointmentID'
			);
			$sql->bindParam(':AppointmentID', intval($AppointmentID));
			$sql->execute();
			return $sql->fetchAll();
		}

		public static function get_doctor_prescription($AppointmentID){
			global $connection;
			
			$sql = $connection->prepare(
			'SELECT DoctorsNote, Diagnosis 
				FROM DoctorAppointment 
				INNER JOIN Prescription ON DoctorAppointment.PrescriptionID = Prescription.PrescriptionID
				WHERE AppointmentID = :AppointmentID'
			);
			$sql->bindParam(':AppointmentID', intval($AppointmentID));
			$sql->execute();
			return $sql->fetchAll();
		}

		public static function get_patient_therapist_appointment($AppointmentID)
		{
			global $connection;
			
			$sql = $connection->prepare(
			'SELECT Therapist.TherapistID, Appointment.AppointmentID,Appointment.Appointment_Date,UserInformation.First_Name,UserInformation.Last_Name
				FROM Appointment 
				INNER JOIN TherapistAppointment ON Appointment.AppointmentID = TherapistAppointment.AppointmentID 
				INNER JOIN Therapist ON TherapistAppointment.TherapistID = Therapist.TherapistID 
				INNER JOIN UserInformation ON Therapist.UserID = UserInformation.UserID
				WHERE Appointment.AppointmentID = :AppointmentID'
			);
			$sql->bindParam(':AppointmentID', intval($AppointmentID));
			$sql->execute();
			return $sql->fetchAll();
		}

		public static function get_therapist_patient_appointment($AppointmentID)
		{
			global $connection;
			
			$sql = $connection->prepare(
			'SELECT Appointment.AppointmentID,Appointment.Appointment_Date,UserInformation.First_Name,UserInformation.Last_Name
				FROM TherapistAppointment 
				INNER JOIN Appointment ON TherapistAppointment.AppointmentID = Appointment.AppointmentID 
				INNER JOIN Patient ON Appointment.PatientID = Patient.PatientID 
				INNER JOIN UserInformation ON Patient.UserID = UserInformation.UserID
				WHERE Appointment.AppointmentID = :AppointmentID'
			);
			$sql->bindParam(':AppointmentID', intval($AppointmentID));
			$sql->execute();
			return $sql->fetchAll();
		}

		public static function get_doctor_appointments($DoctorID){
			global $connection;
			
			$sql = $connection->prepare(
			'SELECT Appointment.AppointmentID,Appointment.Appointment_Date,UserInformation.First_Name,UserInformation.Last_Name
				FROM Appointment 
				INNER JOIN DoctorAppointment ON Appointment.AppointmentID = DoctorAppointment.AppointmentID 
				INNER JOIN Doctor ON DoctorAppointment.DoctorID = Doctor.DoctorID 
				INNER JOIN Patient ON Appointment.PatientID = Patient.PatientID
				INNER JOIN UserInformation ON Patient.UserID = UserInformation.UserID
				WHERE DoctorAppointment.DoctorID = :DoctorID
				ORDER BY Appointment.Appointment_Date ASC'
			);
			$sql->bindParam(':DoctorID', intval($DoctorID));
			$sql->execute();
			return $sql->fetchAll();
		}

		public static function get_therapist_appointments($TherapistID){
			global $connection;
			
			$sql = $connection->prepare(
			'SELECT Appointment.AppointmentID,Appointment.Appointment_Date,UserInformation.First_Name,UserInformation.Last_Name
				FROM Appointment 
				INNER JOIN TherapistAppointment ON Appointment.AppointmentID = TherapistAppointment.AppointmentID 
				INNER JOIN Therapist ON TherapistAppointment.TherapistID = Therapist.TherapistID 
				INNER JOIN Patient ON Appointment.PatientID = Patient.PatientID
				INNER JOIN UserInformation ON Patient.UserID = UserInformation.UserID
				WHERE TherapistAppointment.TherapistID = :TherapistID
				ORDER BY Appointment.Appointment_Date ASC'
			);
			$sql->bindParam(':TherapistID', intval($TherapistID));
			$sql->execute();
			return $sql->fetchAll();
		}

		public static function get_therapist_prescription($AppointmentID){
			global $connection;
			
			$sql = $connection->prepare(
			'SELECT DoctorsNote, Diagnosis, Description, Cost, Name 
				FROM TherapistAppointment 
				INNER JOIN Prescription ON TherapistAppointment.PrescriptionID = Prescription.PrescriptionID
				INNER JOIN Treatment ON TherapistAppointment.TreatmentID = Treatment.TreatmentID
				INNER JOIN Equipment ON Treatment.EquipmentID = Equipment.EquipmentID
				WHERE AppointmentID = :AppointmentID'
			);
			$sql->bindParam(':AppointmentID', intval($AppointmentID));
			$sql->execute();
			return $sql->fetchAll();
		}
		
		public static function get_patient_appointment_therapist($PatientID){
			global $connection;
			
			$sql = $connection->prepare(
			'SELECT Appointment.AppointmentID,Appointment.Appointment_Date,UserInformation.First_Name,UserInformation.Last_Name 
				FROM Appointment 
				INNER JOIN TherapistAppointment ON Appointment.AppointmentID = TherapistAppointment.AppointmentID 
				INNER JOIN Therapist ON TherapistAppointment.TherapistID = Therapist.TherapistID 
				INNER JOIN UserInformation ON Therapist.UserID = UserInformation.UserID
				WHERE Appointment.PatientID = :PatientID
				ORDER BY Appointment.Appointment_Date ASC');
			$sql->bindParam(':PatientID',$PatientID);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		
		public static function retrieve_doctor_notes()
		{
			global $connection;
			
			$sql = $connection->prepare(
			'SELECT DoctorsNote,Description 
			FROM Appointment 
			INNER JOIN DoctorAppointment ON Appointment.AppointmentID = DoctorAppointment.AppointmentID 
			INNER JOIN Prescription ON Prescription.PrescriptionID = DoctorAppointment.PrescriptionID 
			INNER JOIN Prescription_Diagnosis ON Prescription.PrescriptionID = Prescription_Diagnosis.PrescriptionID 
			INNER JOIN Diagnosis ON Diagnosis.DiagnosisID = Prescription_Diagnosis.DiagnosisID');

			return $sql->fetchAll();
		}
		
		public static function book_appointment($PatientID,$Appointment_Date)
		{
			global $connection;
			$sql = $connection->prepare('INSERT INTO Appointment(PatientID,Appointment_Date)
											VALUES(:PatientID,:Appointment_Date)');
			
			$sql->bindParam(':Appointment_Date', $Appointment_Date);
			$sql->bindParam(':PatientID',$PatientID);
			$sql->execute();	
			return $connection->lastInsertId();
		}
		
		public static function book_doctor_appointment($AppointmentID,$DoctorID,$PrescriptionID)
		{	
			global $connection;
			$sql = $connection->prepare( 'INSERT INTO DoctorAppointment(AppointmentID, DoctorID, PrescriptionID)
												VALUES(:AppointmentID,:DoctorID,:PrescriptionID)');
			
			$sql->bindParam(':AppointmentID',$AppointmentID);			
			$sql->bindParam(':DoctorID',$DoctorID);			
			$sql->bindParam(':PrescriptionID',$PrescriptionID);			
			$sql->execute();	

			return $connection->lastInsertId();
		}
		
		public static function book_therapist_appointment($AppointmentID,$TherapistID,$PrescriptionID,$TreatmentID)
		{
			global $connection;
			$sql = $connection->prepare( 'INSERT INTO TherapistAppointment(AppointmentID, TherapistID, PrescriptionID, TreatmentID)
						VALUES(:AppointmentID,:TherapistID,:TreatmentID, :PrescriptionID)');
			
			$sql->bindParam(':AppointmentID',$AppointmentID);			
			$sql->bindParam(':TherapistID',$TherapistID);			
			$sql->bindParam(':PrescriptionID',$PrescriptionID);	
			$sql->bindParam(':TreatmentID',$TreatmentID);	
			$sql->execute();	

			return $connection->lastInsertId();
		}

		public static function validate_patient_appointment($AppointmentID, $PatientID){
			global $connection;
			$stmt = $connection->prepare("SELECT AppointmentID 
											FROM Appointment 
                                            WHERE AppointmentID = :AppointmentID
											AND PatientID = :PatientID");
			
            $stmt->bindParam(':AppointmentID', intval($AppointmentID), PDO::PARAM_INT);		
			$stmt->bindParam(':PatientID', intval($PatientID), PDO::PARAM_INT);	
			$stmt->execute();
			$row = $stmt->fetch();
            return isset($row["AppointmentID"]);
		}

		public static function validate_doctor_appointment($AppointmentID, $DoctorID){
			global $connection;
			$stmt = $connection->prepare("SELECT AppointmentID 
											FROM Appointment
											INNER JOIN DoctorAppointment USING(AppointmentID) 
                                            WHERE AppointmentID = :AppointmentID
											AND DoctorID = :DoctorID");
			
            $stmt->bindParam(':AppointmentID', intval($AppointmentID), PDO::PARAM_INT);		
			$stmt->bindParam(':DoctorID', intval($DoctorID), PDO::PARAM_INT);	
			$stmt->execute();
			$row = $stmt->fetch();
            return isset($row["AppointmentID"]);
		}

		public static function validate_therapist_appointment($AppointmentID, $TherapistID){
			global $connection;
			$stmt = $connection->prepare("SELECT AppointmentID 
											FROM Appointment
											INNER JOIN TherapistAppointment USING(AppointmentID) 
                                            WHERE AppointmentID = :AppointmentID
											AND TherapistID = :TherapistID");
			
            $stmt->bindParam(':AppointmentID', intval($AppointmentID), PDO::PARAM_INT);		
			$stmt->bindParam(':TherapistID', intval($TherapistID), PDO::PARAM_INT);	
			$stmt->execute();
			$row = $stmt->fetch();
            return isset($row["AppointmentID"]);
		}
		
		
		public static function appointment_time_constraint($AppointmentDate)
		{
			$currentDay=date("d");
			$currentMonth=date("m");
			$currentYear=date("Y");
			$currentDate=date_create($currentYear ."-". $currentMonth ."-". $currentDay);
	
			$FutureDay=substr($AppointmentDate,8,2);
			$FutureMonth=substr($AppointmentDate,5,2);
			$FutureYear=substr($AppointmentDate,0,4);
			$FutureDate=date_create($FutureYear ."-". $FutureMonth ."-". $FutureDay);

			$diff=date_diff($currentDate,$FutureDate);
			return $diff;
		}
		
		public static function multiple_appointment_patient($PatientID,$Appointment_Date)
		{
			global $connection;
			$stmt = $connection->prepare("SELECT Appointment_Date 
											FROM Appointment
                                            WHERE PatientID = :PatientID AND
												  Appointment_Date = :Appointment_Date");
			
			$stmt->bindParam(':PatientID', $PatientID);		
			$stmt->bindParam(':Appointment_Date', $Appointment_Date);
            $stmt->execute();
            $row = $stmt->fetch();
            return $stmt->rowCount() > 0;
		}
		
		public static function multiple_appointment_doctor($DoctorID,$Appointment_Date)
		{
			global $connection;
			$stmt = $connection->prepare("SELECT Appointment_Date 
											FROM DoctorAppointment, Appointment
                                            WHERE DoctorAppointment.DoctorID = :DoctorID AND
												  DoctorAppointment.AppointmentID = Appointment.AppointmentID AND
												  Appointment.Appointment_Date = :Appointment_Date");
			
			$stmt->bindParam(':DoctorID', $DoctorID);		
			$stmt->bindParam(':Appointment_Date', $Appointment_Date);
            $stmt->execute();
            $row = $stmt->fetch();
            return $stmt->rowCount() > 0;
		}
		
		public static function multiple_appointment_therapist($TherapistID,$Appointment_Date)
		{
			global $connection;
			$stmt = $connection->prepare("SELECT Appointment_Date 
											FROM TherapistAppointment, Appointment
                                            WHERE TherapistAppointment.TherapistID = :TherapistID AND
												  TherapistAppointment.AppointmentID = Appointment.AppointmentID AND
												  Appointment.Appointment_Date = :Appointment_Date");
			
			$stmt->bindParam(':TherapistID', $TherapistID);		
			$stmt->bindParam(':Appointment_Date', $Appointment_Date);
            $stmt->execute();
            $row = $stmt->fetch();
            return $stmt->rowCount() > 0;
		}
		
		public static function retrieve_patientID($UserID)
		{
			global $connection;
			$stmt = $connection->prepare("SELECT PatientID 
											FROM Patient
                                            WHERE Patient.UserID = :UserID");
			
			$stmt->bindParam(':UserID', $UserID);		
            $stmt->execute();
            $row = $stmt->fetch();
			return $row["PatientID"];
		}
		
			
	}
?>