<?php
	session_start();

	// 
	$_SESSION['URNumber'] 	= $_POST['urNoPatient'];
 	$Surname 				= $_POST['surname'];
	$FirstName 				= $_POST['fistname'];
	$DOB 					= $_POST['dob'];
	$GendID 				= $_POST['gender'];
	$Comments 				= $_POST['comments'];
	$patientStatus 			= $_POST['patientStatus'];

	// field patientStatus is related to admission table not condition
	// what to do with it?
	mysql_query("UPDATE `patient` SET 
						`URNumber` 	= {$_SESSION['URNumber']},
						`Surname` 	= '$Surname',
						`FirstName` = '$FirstName',
						`DOB` 		= '$DOB',
						`GendID` 	= $GendID,
						`Comments` 	= '$Comments' 
					WHERE `URNumber` = {$_SESSION['URNumber']}");
	
/*	echo "UPDATE `patient` SET 
						`URNumber` 	= {$_SESSION['URNumber']},
						`Surname` 	= '$Surname',
						`FirstName` = '$FirstName',
						`DOB` 		= '$DOB',
						`GendID` 	= $GendID,
						`Comments` 	= '$Comments' 
					WHERE `URNumber` = {$_SESSION['URNumber']}";*/
					
?>
