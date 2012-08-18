<?php
	session_start();

	require_once('../includes/database.php');
	require_once('../includes/functions.php');
	require_once('../includes/listboxes.php');

	if(empty($_SESSION['URNumber'])){
		redirect_to('searchPatient.php');
		die;
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

	<form id="patient" action="../edit/redirect.php" method="post" class="well">
	<?php
	
		$sql = mysql_query("SELECT `Identifier`, `URNumber`, `Surname`, `FirstName`, `DOB`
							FROM `patient`	
							WHERE `URNumber` = {$_SESSION['URNumber']}
							");
		if(mysql_num_rows($sql) == 1){
			while($row = mysql_fetch_assoc($sql)){
				echo "UR #: <span class='badge badge-info'>".$row['URNumber']."</span> 
					Age: <span class='badge badge-info'>".age($row['DOB'])."</span><br>
					Name: <span class='badge badge-info'>".$row['Surname']." ".$row['FirstName']."</span><br>";
	?>
			add patient UR, age yrs, surname, firstname, last name, side, site, procedure
			<label>Registrar</label>
				<?php echo primReg(); ?><br>
			<label>Role</label>
				<?php echo registrar_role(); ?><br>
				<input type="submit" value="save +<?php echo "\r"; ?>return to procedure" class="btn btn-success" name="saveReturnToProc">
		</form>
	<?php
			}
		}
	?>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script>
	
</script>
</body>
</html>
<?php //session_destroy(); ?>