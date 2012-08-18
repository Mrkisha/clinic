<?php

	foreach($_POST as $key => $value){
		$$key = $value;
	}
	mysql_query("INSERT INTO `stewartm_clinic`.`patient`
					            (
					             `URNumber`,
					             `Surname`,
					             `FirstName`,
					             `DOB`,
					             `GendID`,
					             `Comments`)
					VALUES (
					        '".mysql_real_escape_string($urNoPatient)."',
					        '".mysql_real_escape_string($surname)."',
					        '".mysql_real_escape_string($fistname)."',
					        '".mysql_real_escape_string($dob)."',
					        '".mysql_real_escape_string($gender)."',
					        '".mysql_real_escape_string($comments)."');");
	$_SESSION['URNumber'] = mysql_real_escape_string($urNoPatient);
?>
