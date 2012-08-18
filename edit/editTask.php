<?php
	session_start();
	require_once('../includes/database.php');
	require_once('../includes/functions.php');
	require_once('../includes/listboxes.php');
	
	if(empty($_SESSION['URNumber'])){
		redirect_to('searchPatient.php');
	}
	
	//require_once('../includes/header.php');

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
	
		$sql = mysql_query("SELECT *
								FROM `patient`
								WHERE `URNumber` = {$_SESSION['URNumber']}
								LIMIT 0, 1
							");
		$patient_data = array();
		if(mysql_num_rows($sql) == 1){
			$row = mysql_fetch_assoc($sql);
			foreach($row as $key => $value){
				$patient_data[$key] = $value;
			}
			echo $patient_data['URNumber']." ".age($patient_data['DOB'])." Yrs<br>".$patient_data['Surname'].", ".$patient_data['FirstName'];
?>
		<br>
		<label>Date</label><input id="taskDate" type="text" name="dateTask" class="span4"><br>
		<div>
			<label>Task</label>
			<textarea name="task" rows="4" cols="30" class="span6"></textarea>
		</div>
		<label>Assigned</label><!-- select from table from Reg List -->
			<?php echo primReg(); ?><br>
		<label>Completed</label><!-- default false -->
			<select name="taskComplete">
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select><br>
		<label>Archive</label><!-- default false -->
			<select name="taskArchive"> 
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select><br>
		<div id="buttonsBar">
			<input type="submit" value="Save changes +<?php echo "\r"; ?>go to record" name="saveTaskGoToRec" class="btn btn-success span2">
			<input type="submit" value="Save changes +<?php echo "\r"; ?>go to tasklist"name="saveTaskGoToTaslkList" class="btn btn-warning span2">
			<input type="submit" value="Save changes +<?php echo "\r"; ?>add new task" name="saveAddNewTask" class="btn btn-danger span2">

		</div>
	</form>
<?php 

	} // end if statment

?>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script src="../js/jquery-ui-timepicker-addon.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function(e) {
		$("#taskDate").datepicker({
			dateFormat: 'yy-mm-dd' 
		});
		
		$('nav a').button();
	});
</script>
</body>
</html>