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
	
	// get conditionID from condition table
	$sql_cond = mysql_query("SELECT `ConditionID`
								FROM `condition`
								WHERE `Patient_Identifier` = $patient_identifier
								ORDER BY `ConditionID` DESC
								LIMIT 0, 1;
								");
								
	$condition_id = '';
	while($row = mysql_fetch_assoc($sql_cond)){
		$condition_id = $row['ConditionID'];
	}


	// insert data into procedure table for planned operation									
	mysql_query("
		INSERT INTO `procedure` (
				`Equipment`,
				`ProcComments`,
				`PlanOperation`,
				`planTime`,
				`planDate`,
				`planSugeon`,
				`Condition_ConditionID`,
				`ProcStatID`
				)
			VALUES (
			    '{$_POST['equipment']}',
				'{$_POST['comments']}',
				'{$_POST['procList']}',
				'{$_POST['planTime']}',
				'{$_POST['planDate']}',
				'{$_POST['ConsultName']}',
				'{$_SESSION['ConditionID']}',
				'1'
			)
					
	") or die(mysql_error());
	
	$_SESSION['OperationID'] = mysql_insert_id();

?>