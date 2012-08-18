<?php
	session_start();
	require_once('../includes/database.php');
	require_once('../includes/functions.php');
	require_once('../includes/listboxes.php');
	require_once('../includes/header.php');
	require_once('../includes/getFromDB.php');
	
	if(empty($_SESSION['URNumber'])){
		redirect_to('searchPatient.php');
		die;
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
		$sql = mysql_query("SELECT
								`patient`.`URNumber`,
								`patient`.`DOB`,
								`patient`.`Surname`,
								`patient`.`FirstName`,
								`diagnoslist`.`Diagnos`,
								`sitelist`.`Sit`,
								`sidelist`.`Sid` 
							FROM `condition`
						    INNER JOIN `patient` 
						        ON (`condition`.`Patient_Identifier` = `patient`.`Identifier`)
						    INNER JOIN `diagnoslist` 
						        ON (`diagnoslist`.`DiagnListID` = `condition`.`DiagnListID`)
						    INNER JOIN `sidelist` 
						        ON (`sidelist`.`SidID` = `condition`.`SideID`)
						    INNER JOIN `sitelist` 
						        ON (`sitelist`.`SitListID` = `condition`.`SitID`)
							WHERE  URNumber = {$_SESSION['URNumber']}
							ORDER BY `ConditionID` DESC
							LIMIT 0, 1;
							");
		if(mysql_num_rows($sql) == 1){
			while($row = mysql_fetch_assoc($sql)){
				echo "UR #: ".$row['URNumber']." Age: ".age($row['DOB'])."<br>Name: ".$row['Surname']." ".$row['FirstName']."<br>Diagnosis: " . 
					$row['Diagnos'] . " Site: " . $row['Sit'] . " Side: ".$row['Sid']
					;
		?><br>
		<label>Operation</label><?php echo procList(); ?><br>
		<label>Surgeon</label><?php echo primConsult(); ?><br>
		<label>Assistant</label><?php echo assistant(); ?><br>
		<label>Date</label><input type="text" name="date"><br>
		<label>Time</label><input type="text" name="time"><br>
		<label>Equip</label><input type="text" name="equipment"><br>
		<div>
			<label>Comments</label>
			<textarea name="comments" rows="7" cols="30"></textarea>
		</div>
		<div id="buttonsBar">
			<input type="submit" value="Save + add registrar role" name="saveAddRegRole">
			<input type="submit" value="Save changes + return to record" name="saveGotoViewRec">
			<input type="submit" value="Add another procedure for this condtition" name="addAnotherProc">
	<?php
			}
		}
	
	?>
		</div>
	</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script src="../js/jquery-ui-timepicker-addon.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function(){
		$("input[name='date']").datepicker({
			dateFormat: 'yy-mm-dd'
		});
		
		$("input[name='time']").timepicker({
			timeFormat: 'hh:mm',
			separator: ':',
			hourMin: 0,
			hourMax: 23,
			minuteMin: 0,
			minuteMax: 59
		});
		
		$('input[type="submit"]').click(function(){
			$.post("../API/editCompletedProcedure.php", $('form').serialize(), function(data){
				console.log(data);	
			});
			//return false;
		});
		
		$('nav a').button();
		
		$('#myModal').modal('hide');
		
	});
</script>

</body>
</html>