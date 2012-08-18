<?php

	mysql_query("UPDATE `condition`
							SET
							  `DiagnListID` = {$_POST['Diagnos']},
							  `SitID` = {$_POST['Sit']},
							  `SideID` = {$_POST['Sid']},
							  `InjuryDate` = '{$_POST['injuryDate']}',
							  `ConsultantID` = '{$_POST['ConsultName']}',
							  `RegistrarID` = '{$_POST['RegistrarName']}',
							  `CondComments` = '{$_POST['comments']}'
							WHERE `ConditionID` = " . mysql_real_escape_string($_POST['condition_ID']));

?>