<?php
	session_start();
	require('../includes/functions.php');
	
	$_SESSION['URNumber'] = $_POST['URNumber'];

	redirect_to('../patientViewRecord.php');
	
?>