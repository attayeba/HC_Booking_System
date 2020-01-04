<?php

	include_once("../database/database_connect.php");
    include_once("Reports.php");
	
 if(isset($_POST["Therapist"])){
        $Therapist = $_POST["Therapist"];
        $DailyAppointments = Reports::therapist_current_appointment($Therapist);
?>
        <div class="row"> 
           <div class="col-md-6">
                <h2>Therapist Appointments</h2>
                <table class="table well">
                    <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Appointment Date</th>
                    </tr>
					</thead>
                    <tbody>
                    <?php 
                        foreach($DailyAppointments as $DailyAppointments) { ?>
                        <tr>
                            <td><?= $DailyAppointments["PatientID"]; ?></td>
                            <td><?= $DailyAppointments["First_Name"]; ?></td>
                            <td><?= $DailyAppointments["Last_Name"]; ?></td>
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