<?php
    class Reports{
        //1)
        public static function num_therapist_patients($StartDate, $EndDate){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT COUNT(PatientID) AS Number_Of_Patients, Therapist.TherapistID, CONCAT(First_Name, ' ', Last_Name) AS Therapist_Name
                FROM Patient
                INNER JOIN Appointment USING(PatientID)
                INNER JOIN TherapistAppointment USING(AppointmentID)
                INNER JOIN Therapist USING(TherapistID)
                INNER JOIN User ON Therapist.UserID = User.UserID
                INNER JOIN UserInformation ON User.UserID = UserInformation.UserID
                WHERE Appointment_Date between DATE(:StartDate) AND DATE(:EndDate)
                GROUP BY Therapist.TherapistID");
            
            $stmt->bindParam(':StartDate', $StartDate);
            $stmt->bindParam(':EndDate', $EndDate);

            $stmt->execute();

            return $stmt->fetchAll();
        }

        //2)
        public static function equipment_never_used(){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT EquipmentID, Name 
                FROM Equipment
                WHERE EquipmentID NOT IN (
                    SELECT EquipmentID 
                    FROM Equipment 
                    INNER JOIN Treatment USING(EquipmentID)
                )"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }

        //3)
        public static function patients_list(){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT PatientID, CONCAT(First_Name, ' ', Last_Name) AS Patient_Name, Phone_Number, Age
                FROM Patient
                INNER JOIN User ON Patient.UserID = User.UserID
                INNER JOIN UserInformation ON User.UserID = UserInformation.UserID
            "
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }

        //4)
        public static function therapist_list(){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT TherapistID, CONCAT(First_Name, ' ', Last_Name) AS Therapist_Name, Phone_Number, Age, Experience
                FROM Therapist
                INNER JOIN User ON Therapist.UserID = User.UserID
                INNER JOIN UserInformation ON User.UserID = UserInformation.UserID
            "
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }

        //5)
        public static function working_therapist_list(){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT DISTINCT Therapist.TherapistID, CONCAT(First_Name, ' ', Last_Name) AS Therapist_Name, Phone_Number, Age, Experience
                FROM Therapist
                INNER JOIN User ON Therapist.UserID = User.UserID
                INNER JOIN UserInformation ON User.UserID = UserInformation.UserID
                INNER JOIN TherapistAppointment ON Therapist.TherapistID = TherapistAppointment.TherapistID
            "
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }

        //6)
        public static function patient_doctor_reservations($PatientID){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT AppointmentID, DoctorID, CONCAT(First_Name, ' ', Last_Name) AS Doctor_Name, Appointment_Date 
                FROM Appointment
                INNER JOIN DoctorAppointment USING(AppointmentID)
                INNER JOIN Doctor USING(DoctorID)
                INNER JOIN User ON Doctor.UserID = User.UserID
                INNER JOIN UserInformation ON User.UserID = UserInformation.UserID
                WHERE PatientID = :PatientID
                ORDER BY Appointment_Date ASC
            "
            );

            $stmt->bindParam(':PatientID', $PatientID);

            $stmt->execute();

            return $stmt->fetchAll();
        }

        public static function patient_therapist_reservations($PatientID){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT AppointmentID, TherapistID, CONCAT(First_Name, ' ', Last_Name) AS Therapist_Name, Appointment_Date 
                FROM Appointment
                INNER JOIN TherapistAppointment USING(AppointmentID)
                INNER JOIN Therapist USING(TherapistID)
                INNER JOIN User ON Therapist.UserID = User.UserID
                INNER JOIN UserInformation ON User.UserID = UserInformation.UserID
                WHERE PatientID = :PatientID
                ORDER BY Appointment_Date ASC
            "
            );

            $stmt->bindParam(':PatientID', $PatientID);

            $stmt->execute();

            return $stmt->fetchAll();
        }

        //7)
        public static function doctor_availabilities($DoctorID, $StartDate, $EndDate){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT Appointment_Date 
                FROM Appointment
                INNER JOIN DoctorAppointment USING(AppointmentID)
                INNER JOIN Doctor USING(DoctorID)
                INNER JOIN User ON Doctor.UserID = User.UserID
                INNER JOIN UserInformation ON User.UserID = UserInformation.UserID
                WHERE DoctorID = :DoctorID
                ORDER BY Appointment_Date ASC
            "
            );

            $stmt->bindParam(':DoctorID', $DoctorID);

            $stmt->execute();

            $row = $stmt->fetchAll();

            return Reports::availabilities($StartDate, $EndDate, $row);
        }

        public static function therapist_availabilities($TherapistID, $StartDate, $EndDate){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT Appointment_Date 
                FROM Appointment
                INNER JOIN TherapistAppointment USING(AppointmentID)
                INNER JOIN Therapist USING(TherapistID)
                INNER JOIN User ON Therapist.UserID = User.UserID
                INNER JOIN UserInformation ON User.UserID = UserInformation.UserID
                WHERE TherapistID = :TherapistID
                ORDER BY Appointment_Date ASC
            "
            );

            $stmt->bindParam(':TherapistID', $TherapistID);

            $stmt->execute();

            $row = $stmt->fetchAll();

            return Reports::availabilities($StartDate, $EndDate, $row);
        }

        private static function availabilities($StartDate, $EndDate, $Data){
            $dt1 = new DateTime($StartDate);
            $dt2 = new DateTime($EndDate);
            $dt2->add(new DateInterval('P1D'));
            $period = new DatePeriod($dt1, new DateInterval('P1D'), $dt2);

            $availabilities = array();
            $counter = 0;
            foreach($period as $day){
                $day = $day->format('Y-m-d');
                //echo "day: $day data: " . $Data[$counter]["Appointment_Date"] . "<br / >";
                //Not available on that day
                if($counter < count($Data) && $day == $Data[$counter]["Appointment_Date"]){
                    
                    $counter = $counter + 1;
                }
                else{
                    array_push($availabilities, $day);
                }
            }
            return $availabilities;
        }

        //#8
        public static function num_patients(){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT COUNT(PatientID) AS Patient_Count
                FROM Patient
            "
            );

            $stmt->execute();

            $row = $stmt->fetch();

            return $row["Patient_Count"];
        }
		
		//#9
		public static function therapist_current_appointment($TherapistID){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT UserInformation.First_Name, UserInformation.Last_Name, Patient.PatientID, Appointment.Appointment_Date
			    FROM UserInformation, TherapistAppointment, Appointment, Patient
                WHERE TherapistAppointment.TherapistID = :TherapistID AND
                    TherapistAppointment.AppointmentID=Appointment.AppointmentID AND
                    Appointment.PatientID=Patient.PatientID AND
                    Patient.UserID=UserInformation.UserID AND
                    Appointment.Appointment_Date = curdate();
            "
            );
			$stmt->bindParam(':TherapistID', $TherapistID);
            $stmt->execute();
            return $stmt->fetchAll();
        }
		
		//#10
		public static function doctor_current_appointment($DoctorID){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT UserInformation.First_Name, UserInformation.Last_Name, Patient.PatientID, Appointment.Appointment_Date
                FROM UserInformation, DoctorAppointment, Appointment, Patient
                WHERE DoctorAppointment.DoctorID = :DoctorID AND
                    DoctorAppointment.AppointmentID=Appointment.AppointmentID AND
                    Appointment.PatientID=Patient.PatientID AND
                    Patient.UserID=UserInformation.UserID AND
                    Appointment.Appointment_Date = curdate();
            "
            );
			$stmt->bindParam(':DoctorID', $DoctorID);
            $stmt->execute();
            return $stmt->fetchAll();
        }
		
		//#11
		public static function patient_current_appointment($PatientID){
            global $connection;
            $stmt = $connection->prepare(
            "SELECT Appointment.AppointmentID, UserInformation.First_Name, UserInformation.Last_Name, Patient.PatientID, Appointment.Appointment_Date
                FROM Patient
                INNER JOIN Appointment USING(PatientID)
                INNER JOIN UserInformation ON Patient.UserID = UserInformation.UserID
                WHERE Appointment.PatientID = :PatientID 
                AND Appointment.Appointment_Date = curdate()
            "
            );
			$stmt->bindParam(':PatientID', $PatientID);
            $stmt->execute();
            return $stmt->fetchAll();
        }

    }
?>