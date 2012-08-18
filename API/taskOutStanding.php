<?php

	session_start();
	require_once('../includes/database.php');
	
	$sql = mysql_query("SELECT `Identifier`, `URNumber` FROM patient WHERE URNumber = {$_POST['URNumber']}");
	if($sql){
		while($row = mysql_fetch_assoc($sql)){
			$_SESSION['URNumber'] = $row['URNumber'];
			echo $row['URNumber'];
		}
	} else {
		return false;
	}

?>