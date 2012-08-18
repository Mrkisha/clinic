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
<head>
<meta charset="utf-8">
<title>Edit Patient</title>
<link rel="stylesheet" href="css/main2.css">
<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.20.custom.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
<script src="bootstrap/js/bootstrap.min.js"></script>
<style type="text/css">
	.tableBackground {
		background-color: #FFF;
	}
	
	.label {
		padding-top: 6px!important;
		padding-bottom: 6px!important;
		text-align: center;
	}
	input[name="dob"] {
		width: 73px;
	}
	#sex, #age {
		width: 28px;
	}
	
	#dob {
		width: 43px;
	}
	
	#gender {
		width: 78px!important;
	}
</style>
</head>

<body>

<br>
<div class="centerPageOutstanding">
<nav>
	<a href="outstandingCases.php" class="btn btn-large">Outstanding Cases</a>
	<a href="taskList.php" class="btn btn-large btn-inverse">Tasks</a>
	<a href="wardList.php" class="btn btn-large btn-warning">Ward List</a>
	<a href="edit/addPatient.php" class="btn btn-primary btn-large">Add New Patient</a>
</nav><br>

<form action="" method="post" class="form-inline">
	<fieldset class="well span11">
		<div class="span5"><input type="hidden"></div>
		<div class="span5 pull-right">
			<label>UR No. </label>
			<input type="text" name="urNo" value="<?php echo $urNo; ?>"/>
			<input type="submit" name="find" value="Find" class="btn btn-info"/>
			<div class="span1"></div>
		</div>
	</fieldset>
</form>
<form id="updatePatient" action="edit/redirect.php" method="post" class="form-inline">
	<fieldset class="well span11">
		<div class="span5">
			<label class="span2">UR No.&nbsp;</label><input id="urn" type="text" name="urNoPatient" value="<?php echo $urNo; ?>" class="span3"/><br>
			<label class="span2">Surname&nbsp;</label><input type="text" name="surname" value="<?php echo $surname; ?>" class="span3"/><br>
			<label class="span2">First Name&nbsp;</label><input type="text" name="fistname" value="<?php echo $firstName; ?>"/>
			<div class="oneLine"><label class="span1 control-label" id="dob">D.O.B&nbsp;</label><input type="text" name="dob" value="<?php echo $dob; ?>" class="span2"/></div>
			<div class="oneLine"><label class="span1 control-label" id="age">Age&nbsp;</label><input type="text" name="age" value="<?php echo $age; ?>" disabled="disabled" class="span1"/></div>
			<div class="oneLine"><label class="span1 control-label" id="sex">Sex&nbsp;</label><?php echo gender(); ?></div>
			
			

		</div>
		<div class="span5">
			<label class="span2">Admission Status&nbsp;</label><?php echo patient_status() ?><br>
			<label class="span2">Comments&nbsp;</label><textarea name="comments" rows="4" class="span3"><?php echo $comments; ?></textarea><br>	
		</div>
		<div class="span10">
			<span class="pull-right">
				<br><input type="submit" name="saveAndRetrieve" value="Save" class="btn btn-primary span2">
			</span>
		</div>
	</fieldset>
</form>

<fieldset class="well span11">
	<form action="edit/redirect.php" method="post">
		<input name="addTask" type="submit" value="Add Task" class="span2 btn btn-success">
		<input class="btn disabled span2" value="Tasks">
	</form><br>
		<div class="tableBackground">
			<?php include('contents/tasks.php') ?>
		</div>
</fieldset>

<fieldset class="well span11">
	<form action="edit/redirect.php" method="post">	
		<input type="submit" name="addCondition" value="Add Condition" class="span2 btn btn-success">
		<input class="btn disabled span2" value="Conditions">
	</form><br>
		<div class="tableBackground">
			<?php include('contents/conditions.php'); ?>
		</div>
		<br>
		<div id="procedure">
			<?php //include('contents/procedures.php'); ?>
		</div>
</fieldset>

<fieldset class="well span11">
	<form action="edit/redirect.php" method="post">
		<input class="btn disabled span2" value="Admission Details: ">
		<input type="submit" name="addNewAdmission" value="Add admission" class="span2 btn btn-success">
	</form>
	<div class="tableBackground">
		<?php include('contents/admission.php'); ?>
	</div>
</fieldset>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script src="js/jquery-ui-timepicker-addon.js"></script>
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
				
		// condition activation (shows procedures related to this condition)
		$("#procedure").hide();
		
		$('input[name="activate"]').click(function(){
			// set session for conditionID			
			// get procedures for ceratain conditions
			$.post("contents/procedures.php", {conditionID: $(this).next().val()}, function(data){
				$('#procedure').slideUp().empty().html(data).slideDown('fast').scroll().offset().top;
				$("table").addClass("table table-bordered tableBackground");
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
		
		// set #gender class to span1
		$("#gender").css("width", "74px");
		$("table").addClass("table table-bordered");
	});

</script>

</body>
</html>