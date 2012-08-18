<?php
	require('../includes/database.php');
	$sql = mysql_query("SELECT
							    `diagnoslist`.`Diagnos`
							    , `sitelist`.`Sit`
							    , `sidelist`.`Sid`
							    , `patient`.`URNumber`
							    , `genderlist`.`Gend`
							    , `condition`.`InjuryDate`
							    , `condition`.`CondComments`
							    , `procstatus`.`ProcStat`
							FROM
							    `condition`
							    INNER JOIN `patient` 
							        ON (`condition`.`Patient_Identifier` = `patient`.`Identifier`)
							    INNER JOIN `diagnoslist` 
							        ON (`diagnoslist`.`DiagnListID` = `condition`.`DiagnListID`)
							    INNER JOIN `genderlist` 
							        ON (`genderlist`.`GendID` = `patient`.`GendID`)
							    INNER JOIN `sidelist` 
							        ON (`sidelist`.`SidID` = `condition`.`SideID`)
							    INNER JOIN `sitelist` 
							        ON (`sitelist`.`SitListID` = `condition`.`SitID`)
							    INNER JOIN `procedure` 
							        ON (`procedure`.`Condition_ConditionID` = `condition`.`ConditionID`)
							    INNER JOIN `procstatus` 
							        ON (`procstatus`.`ProcStatID` = `procedure`.`ProcStatID`)") or die(mysql_error());
?>
<!DOCTYPE HTML>
<html>
<meta charset="utf-8">
<link href="../css/buttons.css" rel="stylesheet" type="text/css">
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="../js/jquery.alerts.css" rel="stylesheet" type="text/css" >
<link href="../css/main.css" rel="stylesheet" type="text/css">
<title>Edit Patient</title>
<body>
<nav>
	<a href="../patientViewRecord.php" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
		<span class="ui-button-text">View Patient Record</span>
	</a>
	<a href="../outstandingCases.php" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
		<span class="ui-button-text">Outstanding Cases</span>
	</a>
	<a href="../taskList.php" class="btn btn-large btn-inverse">Tasks</a>
	<a href="../wardList.php" class="btn btn-large btn-warning">Ward List</a>
</nav>
<br>

<?php
	if(mysql_num_rows($sql) != 0){
		
		$table_tasks = '<table>
						<tr>
							<th>Dignosis</th><th>Site</th><th>Side</th><th>UR Number</th><th>Gender</th><th>Injury Date</th><th>Condition comments</th><th>Process Status</th>
						</tr>';
						
		while($row = mysql_fetch_assoc($sql)){
			$table_tasks .= "<tr>
								<td>{$row['Diagnos']}</td>
								<td>{$row['Sit']}</td>
								<td>{$row['Sid']}</td>
								<td>{$row['URNumber']}</td>
								<td>{$row['Gend']}</td>
								<td>{$row['InjuryDate']}</td>
								<td>{$row['CondComments']}</td>
								<td>{$row['ProcStat']}</td>
							</tr>";
				
		}
		$table_tasks .= '</table>';
		echo $table_tasks;
	}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

</body>
</html>