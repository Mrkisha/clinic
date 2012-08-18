<?php

	session_start();
	require_once('../includes/database.php');

	// get the patient id
	$sql = mysql_query(
				"SELECT `URNumber` FROM `patient` WHERE `URNumber` = {$_POST['URNumber']}"
	);
	
	if(mysql_num_rows($sql) == 1){
		$patient_urNo = '';
		while($row = mysql_fetch_assoc($sql)){
			$patient_urNo = $row['URNumber'];
		}
		$_SESSION['URNumber'] = $patient_urNo;
		echo $patient_urNo;
	} else {
		return false;
	}

?>