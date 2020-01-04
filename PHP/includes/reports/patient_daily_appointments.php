<?php

	include_once("../database/database_connect.php");
    include_once("Reports.php");
	
 if(isset($_POST["Patient"])){
        $Patient = $_POST["Patient"];
        $DailyAppointments = Reports::patient_current_appointment($Patient);
		
	
?>
        <div class="row"> 
           <div class="col-md-6">
                <h2>Patient Appointments</h2>
                <table class="table well">
                    <thead>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Appointment Date</th>
                    </tr>
					</thead>
                    <tbody>
                    <?php 
                        foreach($DailyAppointments as $DailyAppointments) { ?>
                        <tr>
                            <td><?= $DailyAppointments["AppointmentID"]; ?></td>
                            <td><?= $DailyAppointments["Appointment_Date"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
        </div>
<?php
		if($DailyAppointments==null)
		{
			echo "No appointments today!";
		}
	
	}
    else
	{
        echo "Missing fields";
    }
?>