<?php
	session_start();
	
	session_destroy();
	
	require_once('../includes/database.php');
	include_once('../includes/functions.php');
	require_once('../includes/listboxes.php');

	
		
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
	<!--<a href="../taskList.php" class="btn btn-large btn-inverse">Tasks</a>-->
	<a href="../wardList.php" class="btn btn-large btn-warning">Ward List</a>
</nav><br>

<form id="patient" action="redirect.php" method="post" class="well">

			<label>UR No.</label>
				<input id="urn" type="text" name="urNoPatient" value="<?php //echo $row['URNumber']; ?>" class="span4"/><br>
			<label>Surname</label>
				<input id="surname" type="text" name="surname" value="<?php //echo $row['Surname']; ?>" class="span4"><br>
			<label>First Name</label>
				<input id="name" type="text" name="fistname" value="<?php //echo $row['FirstName']; ?>" class="span4"><br>
			<label>D.O.B (yyyy-mm-dd)</label>
				<input id="dob" type="text" name="dob" value="<?php //echo $row['DOB']; ?>" class="span4"><br>
			<label>Sex</label><?php echo gender(); ?><br>
			<label>Admission Status</label><?php echo patient_status() ?><br>
			<div><label>Comments</label>
				<textarea name="comments" rows="7" cols="30" class="span6"><?php //echo $row['Comments']; ?></textarea></div>
			<div id="buttonsBar">
				<input type="submit" value="Save changes + <?php echo "\r"; ?>retrieve records" class="btn btn-success span2" name="addAndRetrieve">
				<input type="submit" value="Save changes + <?php echo "\r"; ?>add new condition" class="btn btn-warning span2" name="addAndNewCond">
				<input id="genderID" type="hidden" value="<?php echo $row['GendID']; ?>" >
			</div>
		</form>

	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script>
	$(document).ready(function(){
		
		$("#dob").datepicker({
			dateFormat: 'yy-mm-dd' 
		});
		
		$('form').validate({
			rules: {
				urNoPatient: {
					required: true
				},
				surname: {
					required: true
				},
				fistname: {
					required: true
				},
				dob: {
					required: true
				},
				gender: {
					required: true
				},
				patientStatus: {
					required: true
				}
			}
		});
	
	});	
</script>

</body>
</html>