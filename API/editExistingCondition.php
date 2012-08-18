<?php
	session_start();

	require_once('../includes/database.php');
	$condition_id = $_POST['condition_ID'];


	// insert details in to condition table	
	mysql_query("UPDATE `condition` SET
						`DiagnListID` = {$_POST['Diagnos']},
						`SitID` = '{$_POST['Sit']}',
						`SideID` = '{$_POST['Sid']}',
						`RegistrarID` = '{$_POST['RegistrarName']}',
						`ConsultantID` = '{$_POST['ConsultName']}',
						`InjuryDate` = '{$_POST['injuryDate']}',
						`CondComments` = '{$_POST['comments']}'
				WHERE ConditionID = $condition_id;
				");
				
	$_SESSION['condition_ID'] = $_POST['condition_ID'];
?>