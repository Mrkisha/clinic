<?php

	session_start();
		
	// get the patient id
	$sql_id = mysql_query(
		"SELECT `Identifier` FROM `patient` WHERE `URNumber` = {$_SESSION['URNumber']}"
	);
	
	$patient_identifier = '';
	while($row = mysql_fetch_assoc($sql_id)){
		$patient_identifier = $row['Identifier'];
	}
	
	foreach($_POST as $key => $value){
		$$key = $value;
	}

	mysql_query("UPDATE `admission` SET 
						  `AdmitDate` = '$admit',
						  `DischargeDate` = '$dc',
						  `AdmitTypeID` = '$admitType',
						  `consultant` = '$ConsultName',
						  `ReferralSource` = '$referral',
						  `Ward` = '$wardList',
						  `Bed` = '$bed',
						  `PatientStatusID` = '$patientStatus',
						  `DishargeDest` = '$dischTo',
						  `AdmitFrom` = '$admitFrom',
						  `comments` = '$comments'
					WHERE `Patient_Identifier` = '$patient_identifier'
			");
				
	/*$admissionID = mysql_insert_id();
	$conditionID = $_SESSION['conditionID'];*/

	// delete all admission_condition where `admission_id` = $_POST['admission_id']
	mysql_query("DELETE FROM `admission_condition` WHERE `admissionID` = {$_POST['admission_id']}");
		

	foreach($_POST['conditionID'] as $key => $value){
		mysql_query("INSERT INTO `admission_condition`
					            (
					             `admissionID`,
					             `conditionID`
								 )
					VALUES (
					        '{$_POST['admission_id']}',
					        '$value'
							)
				");
	}

?>