SET GLOBAL event_scheduler = ON;

CREATE  
	EVENT `Daily_Payment_Verification`
	ON SCHEDULE EVERY 1 DAY STARTS '2017-08-08 17:00:00' ON COMPLETION NOT PRESERVE ENABLE 
	DO 
		INSERT INTO Payment (PaymentTypeID, AppointmentID, Amount, AccountNumber)
		SELECT PaymentTypeID, AppointmentID, Amount, AccountNumber
		FROM DailyPayment;
		
		
CREATE 
	EVENT `Delete_Daily_Payment` 
	ON SCHEDULE EVERY 1 DAY STARTS '2017-08-08 17:05:00' ON COMPLETION NOT PRESERVE ENABLE 
	DO 
		TRUNCATE DailyPayment;
