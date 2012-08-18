<?php
	session_start();
	require_once('../includes/database.php');
	require_once('../includes/functions.php');
	require_once('../includes/listboxes.php');
	if(empty($_SESSION['URNumber'])){
		redirect_to('searchPatient.php');
	}
?>
<nav>
	<a href="../patientViewRecord.php" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
		<span class="ui-button-text">View Patient Record</span>
	</a>
	<a href="../outstandingCases.php" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
		<span class="ui-button-text">Outstanding Cases</span>
	</a>
</nav>
<br>
<div>

	<form id="patient" action="redirect.php" method="post">
	<?php
	
		$sql = mysql_query("SELECT `Identifier`, `URNumber`, `Surname`, `FirstName`, `DOB`
							FROM `patient`	
							WHERE `URNumber` = {$_SESSION['URNumber']}
							");
		if(mysql_num_rows($sql) == 1){
			while($row = mysql_fetch_assoc($sql)){
				echo "UR #: ".$row['URNumber']." Age: ".age($row['DOB'])."<br>Name: ".$row['Surname']." ".$row['FirstName']."<br>";
	?>

		<label>Diagnosis</label><?php echo diagnosis(); ?><br>
		<label>Site</label><?php echo sit(); ?><br>
		<label>Side</label><?php echo sid(); ?><br>
		<label>Primary reg</label><?php echo primReg(); ?><br>
		<label>Primary Consultant</label><?php echo primConsult(); ?><br>
		<label>Injury Date</label><input type="text" name="injuryDate" id="injuryDate"><br>
		<div><label>Comments</label><textarea name="comments" rows="7" cols="30"></textarea></div>
		<div id="buttonsBar">
			<input type="submit" value="Save changes, go to patient record" class="button" name="saveChangesGoPatientRec">
			<input type="submit" value="Save changes + add planned procedure" class="button" name="saveChangesAddProcedure">
			<input type="submit" value="Save changes + add completed procedure" class="button" name="saveChangesCompletedProcedure">
		<?php
				}
			}
		?>
		</div>
	</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script>
	$(document).ready(function(e) {
		$("#injuryDate").datepicker({
			dateFormat: 'yy-mm-dd' 
		});
		
		$('nav a').button();
		
	});

</script>
</body>
</html>