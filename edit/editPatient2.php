<?php
	session_start();
	require_once('../includes/database.php');
	include_once('../includes/functions.php');
	require_once('../includes/listboxes.php');

	if(empty($_SESSION['URNumber'])){
		redirect_to('searchPatient.php');
		die;
	}
?>
<!DOCTYPE HTML>
<html>
<meta charset="utf-8">
<link href="../css/buttons.css" rel="stylesheet" type="text/css">
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="js/jquery.alerts.css" rel="stylesheet" type="text/css" >
<link href="../css/main.css" rel="stylesheet" type="text/css">
<link href="../bootstrap/css/bootstrap.min.css">
<title>Edit Patient</title>
<body>
<nav>
	<a href="../patientViewRecord.php" class="btn btn-primary">View Patient Record</a>
	<a href="../outstandingCases.php" class="btn btn-primary">Outstanding Cases</a>
</nav>
<br>
<div>
<form id="patient" action="redirect.php" method="post">
	<?php
	
		$sql = mysql_query("SELECT `Identifier`, `URNumber`, `Surname`, `FirstName`, `DOB`, `GendID`, `Comments`
								FROM `patient`
								WHERE `URNumber` = {$_SESSION['URNumber']}");
		if(mysql_num_rows($sql)){
			while($row = mysql_fetch_assoc($sql)){
	?>
			<label>UR No.</label>
				<input id="urn" type="text" name="urNoPatient" value="<?php echo $row['URNumber']; ?>"/><br>
			<label>Surname</label>
				<input id="surname" type="text" name="surname" value="<?php echo $row['Surname']; ?>"><br>
			<label>First Name</label>
				<input id="name" type="text" name="fistname" value="<?php echo $row['FirstName']; ?>"><br>
			<label>D.O.B (yyyy-mm-dd)</label>
				<input id="dob" type="text" name="dob" value="<?php echo $row['DOB']; ?>"><br>
			<label>Sex</label><?php echo gender(); ?><br>
			<label>Admission Status</label><?php echo patient_status() ?><br>
			<div><label>Comments</label>
				<textarea name="comments" rows="7" cols="30"><?php echo $row['Comments']; ?></textarea></div>
			<div id="buttonsBar">
				<input type="submit" value="Save changes + retrieve records" class="buttons" name="saveAndRetrieve">
				<input type="submit" value="Save changes + add new condition" class="buttons" name="saveAndNewCond">
				<input id="genderID" type="hidden" value="<?php echo $row['GendID']; ?>" >
			</div>
		</form>
	<?php
				$gender = $row['GendID'];
			}
		}
	?>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function(){
		$("#gender option[value='<?php echo $gender; ?>']").attr('selected', true);
		$("#dob").datepicker({
			dateFormat: 'yy-mm-dd' 
		});
		$('nav a').button();
	});	
</script>
</body>
</html>