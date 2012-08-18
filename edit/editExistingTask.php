<?php

	require_once('../includes/database.php');
	//require_once('../includes/functions.php');
	require_once('../includes/listboxes.php');
	
	///////////////////////////////////////////////////////////////////////
	// fetch data for editing existing task
	
	$task_ID = mysql_real_escape_string($_GET['taskID']);

	// TODO find a way to pass taskID to this query
	
	$sql = mysql_query("SELECT
							    `tasks`.`Task`
							    , `tasks`.`TaskCreate`
							    , `staff`.`staffName`
							    , `tasks`.`TaskComplete`
							    , `tasks`.`TaskArchive`
							    , `patient`.`Identifier`
							    , `patient`.`URNumber`
							    , `patient`.`Surname`
							    , `patient`.`FirstName`
							    , `patient`.`DOB`
							    , `patient`.`Comments`
							FROM
							    `tasks`
							    INNER JOIN `patient` 
							        ON (`tasks`.`Patient_Identifier` = `patient`.`Identifier`)
							    INNER JOIN `staff` 
							        ON (`staff`.`staffID` = `tasks`.`TaskAssign_RegistrarID`)
							    INNER JOIN `genderlist` 
							        ON (`genderlist`.`GendID` = `patient`.`GendID`)
							WHERE (`tasks`.`TaskID` = {$task_ID})");

	if(mysql_num_rows($sql) == 1){
		foreach(mysql_fetch_assoc($sql) as $key => $value){
			$$key = $value;
		}
	} else {
		header("Location: ../patientViewRecord.php");
	}
	///////////////////////////////////////////////////////////////////////

	//require_once('../includes/header.php');
	function age($dob){
		$age = date("Y", time()) - date("Y", strtotime($dob));
		return $age;
	}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Edit Patient</title>
<link rel="stylesheet" href="../css/main2.css">
<link rel="stylesheet" href="../css/ui-lightness/jquery-ui-1.8.20.custom.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<style type="text/css">
	
</style>
</head>

<body>

<br>
<div class="centerPage">
<nav>
	<a href="../patientViewRecord.php" class="btn btn-info btn-large">View Patient Record</a>
	<a href="../outstandingCases.php" class="btn btn-large">Outstanding Cases</a>
	<a href="../taskList.php" class="btn btn-large btn-inverse">Tasks</a>
	<a href="../wardList.php" class="btn btn-large btn-warning">Ward List</a>
</nav><br>
<div>
	<form action="redirect.php" method="post" class="well">
	<?php
		
			echo "UR #: <span class='badge badge-info'>".$URNumber."</span> 
							Age: <span class='badge badge-info'>".age($DOB)."</span><br>
							Name: <span class='badge badge-info'>".$Surname." ".$FirstName."</span>";
			
			//echo $patient_data['URNumber']." ".age($patient_data['DOB'])." Yrs<br>".$patient_data['Surname'].", ".$patient_data['FirstName'];
		
		
?>
		<br>
		<label>Date</label><input id="taskDate" type="text" name="dateTask" class="span4" value="<?php echo date("Y-m-d", strtotime($TaskCreate)); ?>"><br>
		<div>
			<label>Task</label>
			<textarea name="task" rows="4" cols="30" class="span6"><?php echo $Task; ?></textarea>
		</div>
		<label>Assigned</label><!-- select from table from Reg List -->
			<?php echo primReg(); ?><br>
		<label>Completed</label><!-- default false -->
			<select name="taskComplete" id="taskComplete">
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select><br>
		<label>Archive</label><!-- default false -->
			<select name="taskArchive" id="taskArchive">
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select><br>
		<div id="buttonsBar">
			<input type="submit" value="Save changes +<?php echo "\r"; ?>go to record" name="updateTaskGoToRec" class="btn btn-success span2">
			<input type="hidden" value="<?php echo $task_ID; ?>" name="task_ID">
<!--			<input type="submit" value="Save changes + go to tasklist"name="saveTaskGoToTaslkList">
			<input type="submit" value="Save changes + add new task" name="saveAddNewTask">
-->
		</div>
	</form>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script src="../js/jquery-ui-timepicker-addon.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script>
	$(document).ready(function(e) {
		$("#taskDate").datepicker({
			dateFormat: 'yy-mm-dd' 
		});
		
		$('form').validate({
			rules: {
				dateTask: {
					required: true
				},
				task: {
					required: true
				},
				RegistrarName: {
					required: true
				},
				taskComplete: {
					required: true
				},
				taskArchive: {
					required: true
				}
			}
		});

		$('#RegistrarName option[value="<?php echo $TaskAssign_RegistrarID; ?>"]').attr('selected', true);
		$('#taskComplete option[value="<?php echo $TaskComplete; ?>"]').attr('selected', true);
		$('#taskArchive option[value="<?php echo $TaskArchive; ?>"]').attr('selected', true);

	});
</script>
</body>
</html>