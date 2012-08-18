<?php

	mysql_query("INSERT INTO `registrarrole` (
								`Procedure_OperationID`, 
								`RegistrarID`, 
								`RegistrarRole`
								)
							VALUES (
								'{$_SESSION['OperationID']}',
								'{$_POST['RegistrarName']}',
								'{$_POST['role']}'
								)
		");

?>