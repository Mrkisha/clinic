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
<head>
<meta charset="utf-8">
<title>Edit Patient</title>
<link rel="stylesheet" href="../css/main2.css">
<link rel="stylesheet" href="../css/ui-lightness/jquery-ui-1.8.20.custom.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
<style type="text/css">
	
</style>
</head>

<body>

<br>
<div class="centerPage">
<?php echo $_SESSION['condition_ID'] ?>
<nav>
	<a href="../patientViewRecord.php" class="btn btn-info btn-large">View Patient Record</a>
	<a href="../outstandingCases.php" class="btn btn-large">Outstanding Cases</a>
	<a href="../taskList.php" class="btn btn-large btn-inverse">Tasks</a>
	<a href="../wardList.php" class="btn btn-large btn-warning">Ward List</a>
</nav><br>

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
		<label>Operation</label><?php echo procList(); ?><br>
		<label>Surgeon</label><?php echo surg_and_assist_comProc('ConsultName', 'Surgeon'); ?><br>
		<label>Assistant</label><?php echo surg_and_assist_comProc('assistant', 'Assistant'); ?><br>
		<label>Date</label><input type="text" name="date"><br>
		<label>Time</label>
			<select name="time">
				<option value="">- time - </option>
				<option value="am">am</option>
				<option value="pm">pm</option>
				<option value="evening">evening</option>
			</select>
		<label>Equip</label><input type="text" name="equipment" class="span4"><br>
		<div>
			<label>Comments</label>
			<textarea name="comments" rows="4" cols="30" class="span6"></textarea>
		</div>
		<div id="buttonsBar">
			<input type="submit" value="Save + add<?php echo "\r"; ?>registrar role" name="saveAddRegRole" class="btn btn-warning span2">
			<input type="submit" value="Save changes +<?php echo "\r"; ?>return to record" name="saveGotoViewRec" class="btn btn-success span2">
			<input type="submit" value="Add another<?php echo "\r"; ?>procedure<?php echo "\r"; ?>for this condtition" name="addAnotherProc" class="btn btn-danger span2">
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
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script>
	$(document).ready(function(){
		$("input[name='date']").datepicker({
			dateFormat: 'yy-mm-dd'
		});
		
		$('input[type="submit"]').click(function(){
			$.post("../API/editCompletedProcedure.php", $('form').serialize(), function(data){
				console.log(data);	
			});
			//return false;
		});
				
		$('#myModal').modal('hide');
		
		$('form').validate({
			rules: {
				procList: {
					required: true
				},
				ConsultName: {
					required: true
				},
				assistant: {
					required: true
				},
				date: {
					required: true
				},
				time: {
					required: true
				}
			}
		});

		
	});

</script>

</body>
</html>