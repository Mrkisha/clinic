<?php
	session_start();
	require_once('../includes/database.php');
	require_once '../includes/functions.php';
	require_once('../includes/listboxes.php');
	
	
	if(empty($_SESSION['URNumber'])){
		redirect_to('searchPatient.php');
	}
	
	///////////////////////////////////////////////////////////////////////
	// fetch data for editing existing task
	
	$operation_id = mysql_real_escape_string($_GET['procedure_id']);
	
	// fetch data to populate input fields
	$sql_proc = mysql_query("SELECT * FROM `procedure` WHERE `OperationID` = {$operation_id}");

	$row_proc = mysql_fetch_assoc($sql_proc);
	if(mysql_num_rows($sql_proc)){
		foreach($row_proc as $key => $value){
			$$key = $value;
		}
	} else {
		header("Location: ../patientViewRecord.php");
	}
	
	// require_once('../includes/header.php');
	///////////////////////////////////////////////////////////////////////
/*	
	function age($dob){
		$age = date("Y", time()) - date("Y", strtotime($dob));
		return $age;
	}*/
	
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
	<form id="patient" action="redirect.php" method="post" class="well">
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
				echo "UR #: <span class='badge badge-info'>".$row['URNumber']."</span> 
							Age: <span class='badge badge-info'>".age($row['DOB'])."</span><br>
							Name: <span class='badge badge-info'>".$row['Surname']." ".$row['FirstName']."</span><br>
							Diagnosis: <span class='badge badge-info'>" . $row['Diagnos'] . "</span> 
							Site: <span class='badge badge-info'>" . $row['Sit'] . "</span> 
							Side: <span class='badge badge-info'>".$row['Sid'] . "</span>";
		?><br>
		<label>Plan Op</label><?php echo procList(); ?><br>
		<label>Plan Surgeon</label><?php echo primConsult(); ?><br>
		<label>Date</label><input type="text" name="planDate" value="<?php echo $planDate; ?>"><br>
		<label>Time</label>
			<select name="planTime" id="planTime">
				<option value="">- time - </option>
				<option value="am">am</option>
				<option value="pm">pm</option>
				<option value="evening">evening</option>
			</select><br>
		<label>Equip</label><input type="text" name="equipment" value="<?php echo $Equipment; ?>"><br>
		<div>
			<label>Comments</label>
			<textarea name="comments" rows="4" cols="30" class="span6"><?php echo $ProcComments; ?></textarea>
		</div>
		<div id="buttonsBar">
			<input type="submit" value="Save changes + <?php echo "\r"; ?>return to record" name="updatePlanProcAndReturn" class="btn btn-success span2">
			<input type="submit" value="Save changes + <?php echo "\r"; ?>go to tasklist" name="updatePlanGoToTask" class="btn btn-warning span2">
			<input type="submit" value="Convert to<?php echo "\r"; ?>completed<?php echo "\r"; ?>procedure" name="updateConvToComplProc" class="btn btn-danger span2">
			<input type="hidden" value="<?php echo $OperationID; ?>" name="procedure_id" class="btn btn-danger span2">
	<?php
			}
			$_SESSION['OperationID'] = $OperationID;
		}
	
	?>
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
	$(document).ready(function(){
		$("input[name='planDate']").datepicker({
			dateFormat: 'yy-mm-dd'
		});
		
						
		$('#procList option[value="<?php echo $PlanOperation; ?>"]').attr('selected', true);
		$('#ConsultName option[value="<?php echo $planSugeon; ?>"]').attr('selected', true);
		$('#planTime option[value="<?php echo $planTime; ?>"]').attr('selected', true);
		
		$('form').validate({
			rules: {
				procList: {
					required: true
				},
				ConsultName: {
					required: true
				},
				planDate: {
					required: true
				},
				planTime: {
					required: true
				}
			}
		});

	});
</script>

</body>
</html>