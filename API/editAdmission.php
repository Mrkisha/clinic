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

	mysql_query("INSERT INTO `admission` (
						  `AdmitDate`,
						  `DischargeDate`,
						  `AdmitTypeID`,
						  `consultant`,
						  `ReferralSource`,
						  `Ward`,
						  `Bed`,
						  `Patient_Identifier`,
						  `PatientStatusID`,
						  `DishargeDest`,
						  `AdmitFrom`,
						  `comments`
						) 
						VALUES
						  (
						  '$admit',
						  '$dc',
						  '$admitType',
						  '$ConsultName',
						  '$referral',
						  '$wardList',
						  '$bed',
						  '$patient_identifier',
						  '$patientStatus',
						  '$dischTo',
						  '$admitFrom',
						  '$comments'					  
						  )
				");
				
	$admissionID = mysql_insert_id();
	$conditionID = $_SESSION['conditionID'];
	
	foreach($_POST['conditionID'] as $key => $value){
		$conditionID = $value;
		mysql_query("INSERT INTO `admission_condition`
					            (
					             `admissionID`,
					             `conditionID`
								 )
					VALUES (
					        '$admissionID',
					        '$conditionID'
							)
				");
	}


	unset($_SESSION['conditionID']);

?>