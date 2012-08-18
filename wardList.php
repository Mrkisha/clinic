<?php
	include 'includes/database.php';
	include 'includes/functions.php';
		
	$sql = mysql_query("SELECT
								`admission`.`AdmissionID`
							    , `wards`.`Ward`
							    , `admission`.`Bed`
								, `patient`.`Identifier`
							    , `patient`.`Surname`
							    , `patient`.`FirstName`
							    , `patient`.`URNumber`
								, `admission`.`comments`
								, `staff`.`staffName`
								, `admission`.`AdmitDate`
							FROM `wards`
							    INNER JOIN `admission` ON (`wards`.`WardID` = `admission`.`Ward`)
							    INNER JOIN `patient` ON (`admission`.`Patient_Identifier` = `patient`.`Identifier`)
								INNER JOIN `staff` ON (`staff`.`staffID` = `admission`.`consultant`)
							WHERE `admission`.`DischargeDate` = ''
							ORDER BY AdmissionID ASC
					");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Edit Patient</title>
<link rel="stylesheet" href="css/main2.css">
<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.20.custom.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
<script src="bootstrap/js/bootstrap.min.js"></script>
<style type="text/css">
	
</style>
</head>

<body>

<br>
<div class="centerPage" style="width: 960px!important">
<nav>
	<a href="patientViewRecord.php" class="btn btn-info btn-large">View Patient Record</a>
	<a href="outstandingCases.php" class="btn btn-large">Outstanding Cases</a>
	<a href="taskList.php" class="btn btn-large btn-inverse">Tasks</a>
	<a href="edit/addPatient.php" class="btn btn-primary btn-large">Add New Patient</a>
</nav><br>

<?php 
	if(mysql_num_rows($sql) > 0){
		while($row = mysql_fetch_assoc($sql)){
			
			// create column for conditions and procedures
			$sql_condition = mysql_query("SELECT
												`condition`.`conditionID`
												,`sidelist`.`Sid`
												, `sitelist`.`Sit`
												, `diagnoslist`.`Diagnos`
											FROM
												`diagnoslist`
												INNER JOIN `condition` 
													ON (`diagnoslist`.`DiagnListID` = `condition`.`DiagnListID`)
												INNER JOIN `sidelist` 
													ON (`sidelist`.`SidID` = `condition`.`SideID`)
												INNER JOIN `sitelist` 
													ON (`sitelist`.`SitListID` = `condition`.`SitID`)
												INNER JOIN `admission_condition` 
													ON (`condition`.`ConditionID` = `admission_condition`.`conditionID`)
											WHERE (`admission_condition`.`admissionID` = {$row['AdmissionID']})
											");
?>
	<table class="table table-condensed table-bordered span12">
		<tr>
			<th class="span1"><?php echo $row['Ward'] ?></th>
			<th class="span1"><?php echo $row['Bed'] ?></th>
			<th class="span3"><?php echo $row['Surname'].", ".$row['FirstName'] ?></th>
			<th rowspan="6" valign="top" class="span4" >
<?php

	
	if(mysql_num_rows($sql_condition)){
		while($row_admission = mysql_fetch_array($sql_condition)){
			$sql_procedure = mysql_query("SELECT `procedure`.`Date`, `proclist`.`Proc` FROM `condition`
										    	INNER JOIN `procedure` ON (`condition`.`ConditionID` = `procedure`.`Condition_ConditionID`)
										    	INNER JOIN `proclist` ON (`proclist`.`ProclistID` = `procedure`.`ProclistID`)
											WHERE `procedure`.`Condition_ConditionID` = {$row_admission['conditionID']}");
?>
				<?php echo $row_admission['Sid'];  ?> 
				<?php echo $row_admission['Sit'];  ?>  
				<?php echo $row_admission['Diagnos'];  ?> 

<?php
			//echo $row_admission['conditionID'];
//			print_r(mysql_fetch_assoc($sql_procedure));
			while($row_procedure = mysql_fetch_assoc($sql_procedure)){
				?>
				<div style='padding: 3px;'>
				<?php
				echo "<span style='font-weight: 400!important;'>".date("d/m/Y", strtotime($row_procedure['Date']))." ".$row_procedure['Proc']."</span>";
?>
					<span class="badge badge-info pull-right">
				<?php 
					// dayes after operation
					$today = date('Y-m-d', time());
					echo $row_admission['Date'];
					$operationDate = $row_procedure['Date'];
					$days = (strtotime($today) - strtotime($operationDate))/ (60 * 60 * 24); 
					
					echo $days;
				?>
					</span>
				</div>

<?php
			}
		echo "<br>";
?>
					
<?php
		}
	}
?>
			</th>
			<!--<th class="span1">Days</th>-->
			<th class="span4" rowspan="4" valign="top"><?php echo $row['comments'] ?></th>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td><?php echo $row['URNumber']; ?></td>
			<!--<td></td>-->
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td><?php echo $row['staffName'] ?></td>
			<!--<td></td>-->
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td><?php echo date("d/m/Y", strtotime($row['AdmitDate'])); ?></td>
			<!--<td></td>-->
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<!--<td></td>-->
			<td>
<?php
			$sql_comorbidities = mysql_query("SELECT
												    `comorblist`.`Comorbid`
												    , `patient`.`Identifier`
												    , `patient`.`URNumber`
												    , `comorbidities`.`Patient_Identifier`
												FROM `comorblist`
												    INNER JOIN `comorbidities` ON (`comorblist`.`ComorbListID` = `comorbidities`.`Comorbidity`)
												    INNER JOIN `patient` ON (`comorbidities`.`Patient_Identifier` = `patient`.`Identifier`)
												WHERE `patient`.`Identifier` = {$row['Identifier']}");	
			if(mysql_num_rows($sql_comorbidities) > 0){
				$comorbidities = '';
				while($row_comorbidities = mysql_fetch_assoc($sql_comorbidities)){
					$comorbidities .= $row_comorbidities['Comorbid'] . ", ";
				}
				echo substr_replace($comorbidities ,"",-2);
			}
?>
			 </td>
		</tr>
	</table>
<?php
		}
	} else {
		echo "No";
	}
?>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
</body>
</html>