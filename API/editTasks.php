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

	mysql_query("INSERT INTO `tasks` (
								`Task`,
								`TaskCreate`,
								`TaskAssign_RegistrarID`,
								`TaskComplete`,
								`TaskArchive`,
					             `Patient_Identifier`
							)
							VALUES ('".
								$_POST['task']. "', '" . $_POST['dateTask']. "',"
								.$_POST['RegistrarName'] .", "
								.$_POST['taskComplete'] .", "
								.$_POST['taskArchive'] .", "
								.$patient_identifier ."
							)
				");
						
?>