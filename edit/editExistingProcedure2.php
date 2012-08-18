<?php
	session_start();
	require_once('../includes/database.php');
	require_once('../includes/listboxes.php');
	
	
	if(empty($_SESSION['URNumber'])){
		redirect_to('searchPatient.php');
	}
	
	///////////////////////////////////////////////////////////////////////
	// fetch data for editing existing task
	
	$operation_id = mysql_real_escape_string($_GET['procedure_id']);
	
	// fetch data to populate input fields
	$sql_proc = mysql_query("SELECT * FROM `procedure` WHERE `OperationID` = {$operation_id}");
	if(mysql_num_rows($sql_proc)){
		foreach(mysql_fetch_assoc($sql_proc) as $key => $value){
			$$key = $value;
		}
	} else {
		header("Location: ../patientViewRecord.php");
	}
	
	require_once('../includes/header.php');
	///////////////////////////////////////////////////////////////////////
	
	function age($dob){
		$age = date("Y", time()) - date("Y", strtotime($dob));
		return $age;
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
		<label>Date</label><input type="text" name="date" value="<?php echo $Date; ?>"><br>
		<label>Time</label><input type="text" name="time" value="<?php echo $Time; ?>"><br>
		<label>Equip</label><input type="text" name="equipment" value="<?php echo $Equipment; ?>"><br>
		<div>
			<label>Comments</label>
			<textarea name="comments" rows="7" cols="30"><?php echo $ProcComments; ?></textarea>
		</div>
		<div id="buttonsBar">
			<input type="submit" value="Save + add registrar role" name="updateAddRegRole">
			<input type="submit" value="Save changes + return to record" name="editGotoViewRec">
			<input type="hidden" value="<?php echo $OperationID; ?>" name="procedure_id">
	<?php
			}
			$_SESSION['OperationID'] = $OperationID;
		}
	
	?>
		</div>
	</form>
</div>
<div>
<?php
	$sql_reg = mysql_query("SELECT `staff`.`staffName`, `registrarrole`.`RegistrarRole`
							FROM `procedure`
							    INNER JOIN `registrarrole` ON (`procedure`.`OperationID` = `registrarrole`.`Procedure_OperationID`)
							    INNER JOIN `staff` ON (`staff`.`staffID` = `registrarrole`.`RegistrarID`)
							WHERE `staff`.`staffTypeID` = 2 AND `registrarrole`.`Procedure_OperationID` = $OperationID");

	if(mysql_num_rows($sql_reg) > 0){
?>
		<table>
			<tr>
				<th>Registrar</th><th>Role</th>
			</tr>
<?php
		while($row_reg = mysql_fetch_assoc($sql_reg)){
?>		
			<tr>
				<td><?php echo $row_reg['staffName'] ?></td><td><?php echo $row_reg['RegistrarRole'] ?></td>
			</tr>
<?php
		}
?>
		</table>
<?php
	}
?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script src="../js/jquery-ui-timepicker-addon.js"></script>
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
				
		$('nav a').button();
		
		$('#procList option[value="<?php echo $ProclistID; ?>"]').attr('selected', true);
		$('#ConsultName option[value="<?php echo $SurgeonID; ?>"]').attr('selected', true);
		$('#assistant option[value="<?php echo $AssistantID; ?>"]').attr('selected', true);
	
	});
</script>

</body>
</html>