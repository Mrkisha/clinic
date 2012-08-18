<?php

	session_start();
	require_once('../includes/database.php');
	require_once('../includes/listboxes.php');
	
	
	if(empty($_SESSION['URNumber'])){
		redirect_to('searchPatient.php');
	}
	
	///////////////////////////////////////////////////////////////////////
	$condition_ID = mysql_real_escape_string($_GET['condition_id']);
	
	$sql = mysql_query("SELECT * FROM `condition` WHERE `ConditionID` = $condition_ID");
	
	if(mysql_num_rows($sql) == 1){
		foreach(mysql_fetch_assoc($sql) as $key => $value){
			$$key = $value;
		}
		// set condition session if we need to add procedures
		$_SESSION['ConditionID'] = $condition_ID;
		
	} else {
		header("Location: ../patientViewRecord.php");
	}
	
	//require_once('../includes/header.php');
	///////////////////////////////////////////////////////////////////////
	
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
</nav><br>

<form id="patient" action="redirect.php" method="post" class="well">
	<?php
	
		$sql = mysql_query("SELECT `Identifier`, `URNumber`, `Surname`, `FirstName`, `DOB`
							FROM `patient`	
							WHERE `URNumber` = {$_SESSION['URNumber']}
							");
		if(mysql_num_rows($sql) == 1){
			while($row = mysql_fetch_assoc($sql)){
				echo "UR #: <span class='badge badge-info'>".$row['URNumber']."</span>&nbsp;&nbsp; 
						Age: <span class='badge badge-info'>".age($row['DOB'])."</span>&nbsp;&nbsp;
						Name: <span class='badge badge-info'>".$row['Surname']." ".$row['FirstName']."</span><br><br>";
	?>

		<label>Diagnosis</label><?php echo diagnosis(); ?>
		<label>Site</label><?php echo sit(); ?><br>
		<label>Side</label><?php echo sid(); ?><br>
		<label>Primary reg</label><?php echo primReg(); ?><br>
		<label>Primary Consultant</label><?php echo primConsult(); ?><br>
		<label>Injury Date</label><input type="text" name="injuryDate" id="injuryDate" class="span4" value="<?php echo $InjuryDate; ?>"><br>
		<div><label>Comments</label><textarea name="comments" rows="4" cols="30" class="span6"></textarea></div>
		<div id="buttonsBar">
			<input type="submit" value="Save changes, go<?php echo "\r"; ?>to patient record" class="btn btn-success span2" name="updateCondition">
			<input type="submit" value="Save changes +<?php echo "\r"; ?>add planned<?php echo "\r"; ?>procedure" class="btn btn-warning span2" name="updateChangesAddProcedure">
			<input type="submit" value="Save changes +<?php echo "\r"; ?>add completed<?php echo "\r"; ?>procedure" class="btn btn-danger span2" name="updateChangesCompletedProcedure">
			<input type="hidden" value="<?php echo $condition_ID; ?>" name="condition_ID">

		<?php
				}
			}
		?>
		</div>
	</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function(){
		$("#injuryDate").datepicker({
			dateFormat: 'yy-mm-dd' 
		});
		
		$('nav a').button();
		
		$('#diagnos option[value="<?php echo $DiagnListID; ?>"]').attr('selected', true);
		$('#sit option[value="<?php echo $SitID; ?>"]').attr('selected', true);
		$('#sid option[value="<?php echo $SideID; ?>"]').attr('selected', true);
		$('#RegistrarName option[value="<?php echo $RegistrarID; ?>"]').attr('selected', true);
		$('#ConsultName option[value="<?php echo $ConsultantID; ?>"]').attr('selected', true);
	});	
</script>

</body>
</html>