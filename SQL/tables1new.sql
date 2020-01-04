CREATE TABLE User(
    UserID INT(8) UNSIGNED AUTO_INCREMENT,
	AccessRightsID INT(8) UNSIGNED,
	Username VARCHAR(30) UNIQUE,
	Password VARCHAR(95),
    PRIMARY KEY(UserID)
);

CREATE TABLE AccessRights(
    AccessRightsID INT(8) UNSIGNED AUTO_INCREMENT,
	Name VARCHAR(30),
    AccessLevel INT(2),
    PRIMARY KEY(AccessRightsID)
);

INSERT INTO AccessRights VALUES(0, "Patient", 1);
INSERT INTO AccessRights VALUES(0, "Nurse", 2);
INSERT INTO AccessRights VALUES(0, "Therapist", 2);
INSERT INTO AccessRights VALUES(0, "Doctor", 2);
INSERT INTO AccessRights VALUES(0, "Receptionist", 3);

ALTER TABLE User 
    ADD CONSTRAINT FK_User_AccessRights
    FOREIGN KEY(AccessRightsID)
    REFERENCES AccessRights(AccessRightsID);

CREATE TABLE UserInformation(
    UserInformationID INT(8) UNSIGNED AUTO_INCREMENT,
	UserID INT(8) UNSIGNED ,
	First_Name VARCHAR(30),
	Last_Name VARCHAR(30),
	Phone_Number VARCHAR(10),
    Age INT(3) UNSIGNED,
    PRIMARY KEY(UserInformationID),
	CHECK (Age>=18)
);

ALTER TABLE UserInformation 
    ADD CONSTRAINT FK_UserInformation_User
    FOREIGN KEY(UserID)
    REFERENCES User(UserID)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
	
CREATE TABLE Doctor(
    DoctorID INT(8) UNSIGNED AUTO_INCREMENT,
	UserID INT(8) UNSIGNED ,
	Experience INT(2),
    PRIMARY KEY(DoctorID),
	CHECK (Experience>=6)
);

ALTER TABLE Doctor 
    ADD CONSTRAINT FK_Doctor_User
    FOREIGN KEY(UserID)
    REFERENCES User(UserID)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
	
CREATE TABLE Therapist(
    TherapistID INT(8) UNSIGNED AUTO_INCREMENT,
	UserID INT(8) UNSIGNED ,
	Experience INT(2),
    PRIMARY KEY(TherapistID),
	CHECK (Experience>=2)
);

ALTER TABLE Therapist 
    ADD CONSTRAINT FK_Therapist_User
    FOREIGN KEY(UserID)
    REFERENCES User(UserID)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
	
CREATE TABLE Patient(
    PatientID INT(8) UNSIGNED AUTO_INCREMENT,
	UserID INT(8) UNSIGNED ,
	PRIMARY KEY(PatientID)
);

ALTER TABLE Patient 
    ADD CONSTRAINT FK_Patient_User
    FOREIGN KEY(UserID)
    REFERENCES User(UserID)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

CREATE TABLE Receptionist(
    ReceptionistID INT(8) UNSIGNED AUTO_INCREMENT,
	UserID INT(8) UNSIGNED ,
	PRIMARY KEY(ReceptionistID)
);

ALTER TABLE Receptionist 
    ADD CONSTRAINT FK_Receptionist_User
    FOREIGN KEY(UserID)
    REFERENCES User(UserID)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
 	
CREATE TABLE Nurse(
    NurseID INT(8) UNSIGNED AUTO_INCREMENT,
	UserID INT(8) UNSIGNED ,
	PRIMARY KEY(NurseID)
);

ALTER TABLE Nurse 
    ADD CONSTRAINT FK_Nurse_User
    FOREIGN KEY(UserID)
    REFERENCES User(UserID)
    ON DELETE CASCADE
    ON UPDATE CASCADE;	

CREATE TABLE Treatment(
    TreatmentID INT(8) UNSIGNED AUTO_INCREMENT,
	EquipmentID INT(8) UNSIGNED,
    Description VARCHAR(50),
	Cost DOUBLE(10,2),
    PRIMARY KEY(TreatmentID)
);

CREATE TABLE Equipment(
    EquipmentID INT(8) UNSIGNED AUTO_INCREMENT,
    Name VARCHAR(30),
    PRIMARY KEY(EquipmentID)
);

ALTER TABLE Treatment
    ADD CONSTRAINT FK_Treatment_Equipment
    FOREIGN KEY(EquipmentID)
    REFERENCES Equipment(EquipmentID);

CREATE TABLE Prescription(
    PrescriptionID INT(8) UNSIGNED AUTO_INCREMENT,
	DoctorsNote VARCHAR(1000),
	Diagnosis VARCHAR(50),
    PRIMARY KEY(PrescriptionID)
);


CREATE TABLE Appointment(
    AppointmentID INT(8) UNSIGNED AUTO_INCREMENT,
	PatientID INT(8) UNSIGNED,
	Appointment_Date Date,
    PRIMARY KEY(AppointmentID)
);


ALTER TABLE Appointment
    ADD CONSTRAINT FK_Appoitment_Patient
    FOREIGN KEY(PatientID)
    REFERENCES Patient(PatientID)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

	
	
CREATE TABLE TherapistAppointment(
    TherapistAppointmentID INT(8) UNSIGNED AUTO_INCREMENT,
	AppointmentID INT(8) UNSIGNED,
	TherapistID INT(8) UNSIGNED,
	PrescriptionID INT(8) UNSIGNED,
	TreatmentID INT(8) UNSIGNED,
    PRIMARY KEY(TherapistAppointmentID)
);

ALTER TABLE TherapistAppointment
    ADD CONSTRAINT FK_Therapist_Appointment
    FOREIGN KEY(AppointmentID)
    REFERENCES Appointment(AppointmentID)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE TherapistAppointment
    ADD CONSTRAINT FK_Appointment_Therapist
    FOREIGN KEY(TherapistID)
    REFERENCES Therapist(TherapistID)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
	
ALTER TABLE TherapistAppointment
    ADD CONSTRAINT FK_Therapist_Appointment_Prescription
    FOREIGN KEY(PrescriptionID)
    REFERENCES Prescription(PrescriptionID);

ALTER TABLE TherapistAppointment
    ADD CONSTRAINT FK_Therapist_Appointment_Treatment
    FOREIGN KEY(TreatmentID)
    REFERENCES Treatment(TreatmentID);
	
	
	
	
	
CREATE TABLE DoctorAppointment(
    DoctorAppointmentID INT(8) UNSIGNED AUTO_INCREMENT,
    AppointmentID INT(8) UNSIGNED,
	DoctorID INT(8) UNSIGNED,
	PrescriptionID INT(8) UNSIGNED,
    PRIMARY KEY(DoctorAppointmentID)
);

ALTER TABLE DoctorAppointment
    ADD CONSTRAINT FK_Doctor_Appointment
    FOREIGN KEY(AppointmentID)
    REFERENCES Appointment(AppointmentID)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE DoctorAppointment
    ADD CONSTRAINT FK_Appointment_Doctor
    FOREIGN KEY(DoctorID)
    REFERENCES Doctor(DoctorID)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE DoctorAppointment	
    ADD CONSTRAINT FK_Doctor_Appointment_Prescription
    FOREIGN KEY(PrescriptionID)
    REFERENCES Prescription(PrescriptionID);

	
	
	
	
CREATE TABLE DailyPayment(
    DailyPaymentID INT(8) UNSIGNED AUTO_INCREMENT,
	PaymentTypeID INT(8) UNSIGNED,
	AppointmentID INT(8) UNSIGNED,
	Amount DOUBLE(10,2),
	AccountNumber VARCHAR(16),
    PRIMARY KEY(DailyPaymentID)
);

CREATE TABLE Payment(
    PaymentID INT(8) UNSIGNED AUTO_INCREMENT,
	PaymentTypeID INT(8) UNSIGNED,
	AppointmentID INT(8) UNSIGNED,
	Amount DOUBLE(10,2),
	AccountNumber VARCHAR(16),
    PRIMARY KEY(PaymentID)
);

CREATE TABLE PaymentType(
    PaymentTypeID INT(8) UNSIGNED AUTO_INCREMENT,
	Type ENUM('Cash','Cheque','Debit','Credit'),
    PRIMARY KEY(PaymentTypeID)
);

insert into PaymentType values(0,"Cash");
insert into PaymentType values(0,"Cheque");
insert into PaymentType values(0,"Debit");
insert into PaymentType values(0,"Credit");

ALTER TABLE Payment
    ADD CONSTRAINT FK_PaymentType_Payment
    FOREIGN KEY(PaymentTypeID)
    REFERENCES PaymentType(PaymentTypeID);
 
ALTER TABLE Payment 
    ADD CONSTRAINT FK_Appointment_Payment
    FOREIGN KEY(AppointmentID)
    REFERENCES Appointment(AppointmentID)
    ON UPDATE CASCADE;

ALTER TABLE DailyPayment
    ADD CONSTRAINT FK_PaymentType_DailyPayment
    FOREIGN KEY(PaymentTypeID)
    REFERENCES PaymentType(PaymentTypeID);
 

ALTER TABLE DailyPayment
    ADD CONSTRAINT FK_Appointment_DailyPayment
    FOREIGN KEY(AppointmentID)
    REFERENCES Appointment(AppointmentID)
    ON UPDATE CASCADE;