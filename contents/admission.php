<?php

	// get the patient id
	$sql_id = mysql_query(
		"SELECT `Identifier` FROM `patient` WHERE `URNumber` = {$_SESSION['URNumber']}"
	);
	
	$patient_identifier = '';
	while($row = mysql_fetch_assoc($sql_id)){
		$patient_identifier = $row['Identifier'];
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////
	$sql = mysql_query("SELECT admission.AdmissionID, admission.AdmitDate, admission.DischargeDate, wards.Ward, admission.Bed, origdestin.OriginDestin
						FROM wards RIGHT JOIN (origdestin RIGHT JOIN admission ON origdestin.OrgDestID = admission.DishargeDest) ON wards.WardID = admission.Ward
						WHERE (`admission`.`Patient_Identifier` = '$patient_identifier')
						ORDER BY `admission`.`AdmitDate` DESC
						");
	
	
	if(mysql_num_rows($sql) > 0){
?>
	<table>
		<tr>
			<th>Admission Date</th><th>Discharge Date</th><th>Ward</th><th>Bed</th><th>Discharge destination</th><th></th>
		</tr>
<?php
		while($row = mysql_fetch_assoc($sql)){
			if($row['DischargeDate'] == ''){
				$row['DischargeDate'] = '';
			} else {
				$row['DischargeDate'] = date("d/m/Y", strtotime($row['DischargeDate']));
			}
			
			echo "<tr>
					<td>".date("d/m/Y", strtotime($row['AdmitDate']))."</td>
					<td>".$row['DischargeDate']."</td>
					<td>".$row['Ward']."</td><td>".$row['Bed']."</td>
					<td>".$row['OriginDestin']."</td>
					<td class='centerElem'><a href='edit/editExistingAdmission.php?admission_id={$row['AdmissionID']}'>Edit</a></td>
				</tr>";
		}
?>
	</table>
<?php
		
	}

?>