<?php
	session_start();
	// unset these 2, we dont need them in here
	unset($_SESSION['OperationID']);
	unset($_SESSION['ConditionID']);

	require_once('includes/database.php');
	require_once('includes/functions.php');
	require_once('includes/listboxes.php');
	
	// if $_SESSION['add_planned_procedure'] exists that means some1 did not fill the data
	// after pressing add anouther procedure
	// we need to delete last inserted row in procedures
	// and to unset this session variable
	if(isset($_SESSION['add_planned_procedure'])){
		mysql_query('DELETE FROM `procedure` WHERE `OperationID` = ' . $_SESSION['add_planned_procedure']);
		unset($_SESSION['add_planned_procedure']);
	}

	if(!isset($_POST) && !isset($_SESSION) && !isset($_POST['saveAndRetrieve'])){
		redirect_to('searchPatient.php');
	}

	$urNo 		= '';
	$surname 	= '';
	$admStatus 	= '';
	$firstName 	= '';
	$comments 	= '';
	$sex 		= '';
	$dob 		= '';
	$age 		= '';

	$data = array();
	$sql;
	if(isset($_POST['find'])){
		$sql = mysql_query("SELECT * FROM patient WHERE URNumber = '{$_POST['urNo']}'");
	} elseif(isset($_POST['saveAndRetrieve'])){
		$sql = mysql_query("SELECT * FROM patient WHERE URNumber = '{$_POST['urNoPatient']}'");
	} else {
		$sql = mysql_query("SELECT * FROM patient WHERE URNumber = '{$_SESSION['URNumber']}'");
	}
	
	if(mysql_num_rows($sql) == 1){
		
		$row = mysql_fetch_assoc($sql);
		foreach($row as $key => $value){
			$data[$key] = $value;
		}
		
		$id 		= $data['Identifier'];
		$urNo 		= $data['URNumber'];
		$surname 	= $data['Surname'];
		//$admStatus 	= $data['admStatus'];
		$firstName 	= $data['FirstName'];
		$comments 	= $data['Comments'];
		$sex 		= $data['GendID'];
		$dob 		= $data['DOB'];
		$age 		= age($data['DOB']);
		$_SESSION['URNumber'] = $urNo;
	} else {
		session_destroy();
		redirect_to('searchPatient.php');
	}
	
?>
<!DOCTYPE HTML>
<html>
	<meta charset="utf-8">
	<link href="css/buttons.css" rel="stylesheet" type="text/css">
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css">
	<link href="js/jquery.alerts.css" rel="stylesheet" type="text/css" >
	<link href="css/main.css" rel="stylesheet" type="text/css">
	<title>Edit Patient</title>
<body>
<nav>
	<a href="outstandingCases.php" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
		<span class="ui-button-text">Outstanding Cases</span>
	</a>
</nav>
<br>

<form action="" method="post">
	<fieldset>
		<label>UR No. </label>
		<input type="text" name="urNo" value="<?php echo $urNo; ?>"/>
		<input type="submit" name="find" value="Find" />
	</fieldset>
</form>
<form id="updatePatient" action="edit/redirect.php" method="post">
	<fieldset>
		<label>UR No.</label><input id="urn" type="text" name="urNoPatient" value="<?php echo $urNo; ?>"/><br>
		<label>Surname </label><input type="text" name="surname" value="<?php echo $surname; ?>" />
		<label>First Name</label><input type="text" name="fistname" value="<?php echo $firstName; ?>"/>
		<label>D.O.B</label><input type="text" name="dob" value="<?php echo $dob; ?>"/>
		<label>Age</label><input type="text" name="age" value="<?php echo $age; ?>" disabled="disabled"/><br>
		<label>Sex</label><?php echo gender(); ?><br>
		<label>Admission Status</label><?php echo patient_status() ?><br>
		<label>Comments </label><textarea name="comments"><?php echo $comments; ?></textarea><br>
		<input type="submit" name="saveAndRetrieve" value="Save">
	</fieldset>
</form>
<fieldset>
	<form action="edit/redirect.php" method="post">
		<input name="addTask" type="submit" value="Add Task"><label>Tasks</label>
	</form><br>
		<?php include('contents/tasks.php') ?>
	
</fieldset>
<form action="edit/redirect.php" method="post">
	<fieldset>
		<input type="submit" name="addCondition" value="add condition"><label>Conditions</label>
		<?php include('contents/conditions.php'); ?>
	</fieldset>
</form>
	<div id="procedure">
		<?php //include('contents/procedures.php'); ?>
	</div>
<form action="edit/redirect.php" method="post">
	<fieldset>
		Admission Details: &nbsp;&nbsp;&nbsp;<input type="submit" name="addNewAdmission" value="Add admission">
		<?php include('contents/admission.php'); ?>
	</fieldset>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script>
	$(document).ready(function(e) {
		$("input[name='dob']").datepicker({
			dateFormat: 'yy-mm-dd' 
		});

		$("#gender option[value='<?php echo $sex; ?>']").attr('selected', true);
		
		$('input[name="saveAndRetrieve"]').click(function(){
			$.post("API/editPatient.php", $('#updatePatient').serialize(), function(data){
				console.log(data);
			});
//return false;
		});
		
		$('nav a').button();
		
		// condition activation (shows procedures related to this condition)
		$("#procedure").hide();
		
		$('input[name="activate"]').click(function(){
			// set session for conditionID			
			// get procedures for ceratain conditions
			$.post("contents/procedures.php", {conditionID: $(this).next().val()}, function(data){
				$('#procedure').slideUp().empty().html(data).slideDown('fast').scroll().offset().top;
				$('html, body').stop().animate({scrollTop: $("#procedure").offset().top}, 1500,'easeInOutExpo');
			});
			
		});
		
		// set all buttons in condition table to color blue
		$(".prcBtn").each(function (i) {
			this.style.color = "blue";
		});
		
		$("input[type='button']").click(function(){
			$(".prcBtn").each(function (i) {
				this.style.color = "blue";
			});
			// if its clicked button color is red
			this.style.color = "red";
	
		//$(this).addClass("activ");	
	
		});

	});

</script>
</body>
</html>