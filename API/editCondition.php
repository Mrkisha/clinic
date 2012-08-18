<?php
	session_start();

	require_once('../includes/database.php');

	// get the patient id
	$sql_id = mysql_query(
				"SELECT `Identifier` FROM `patient` WHERE `URNumber` = {$_SESSION['URNumber']}"
	);
	
	$patient_identifier = '';
	while($row = mysql_fetch_assoc($sql_id)){
		$patient_identifier = $row['Identifier'];
	}

	// insert details in to condition table	
	mysql_query("INSERT INTO `condition` (
						`DiagnListID`,
						`SitID`,
						`SideID`,
						`RegistrarID`,
						`ConsultantID`,
						`InjuryDate`,
						`CondComments`,
						`Patient_Identifier`)
					VALUES (
						{$_POST['Diagnos']},
						{$_POST['Sit']},
						{$_POST['Sid']},
						{$_POST['RegistrarName']},
						{$_POST['ConsultName']},
						'{$_POST['injuryDate']}',
						'{$_POST['comments']}',
						$patient_identifier
						)
				");
	
	$_SESSION['ConditionID'] = mysql_insert_id();
?>