<?php
	session_start();
	//require_once('includes/header.php');
	require_once('includes/database.php');
	require_once('includes/functions.php');
	require_once('includes/listboxes.php');
	
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
		background-color: white;
	}
	
	.noMargin {
		margin: 0!important;
	}
	
</style>
</head>

<body>

<br>
<div class="centerPageOutstanding">
<nav>
	<a href="patientViewRecord.php" class="btn btn-info btn-large">View Patient Record</a>
	<a href="outstandingCases.php" class="btn btn-large">Outstanding Cases</a>
	<a href="wardList.php" class="btn btn-large btn-warning">Ward List</a>
	<a href="#" class="btn btn-primary btn-large">Add New Patient</a>
</nav><br>
<div>
			<!--<form action="patientViewRecord.php" method="post" id="searchURNumber" class="well">
				<label class="btn disabled span3 noMargin">Search for patient's UR Number: </label><br><br>
				<input type="text" name="URNumber" class="noMargin" >&nbsp;&nbsp;&nbsp;<input type="submit" name="searchPatient" value="Search" class="btn btn-primary">
			</form>-->
	
	
			<!--<form action="edit/redirect.php" method="post" class="well">
				<label class="btn disabled span3 noMargin">Outstanding Cases</label><br><br>
				<input type="submit" name="addOutstanding" value="Add Outstanding" class="span2 btn btn-success"><br><br>
				<div class="tableBackground">
					<?php require('contents/outstandingCases.php'); ?>
				</div>
			</form>-->
			
	
	
			<form class="well">
				<input id="addTask2" name="addTask2" type="submit" value="Add Task" class="span2 btn btn-success">&nbsp;&nbsp;&nbsp;
				<label class="btn disabled span3 noMargin">Tasks</label><br><br>
				<div class="tableBackground">
					<?php require('contents/taskOutStanding.php'); ?>
				</div>
			</form>
			
			<form id="serachURNo" title="Find patient by UR Number:" class="well">
				<label>Search UR Number:</label><input type="text" name="tasksearchURN" /><input type="submit" name="taskFindURN" value="Find" />
				
			</form>
			

	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script src="js/jquery-ui-timepicker-addon.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function(e) {
	
		$("#serachURNo").dialog("destroy");
		$("#serachURNo").dialog({
			autoOpen: false	
		});
		
		// when add task, search for UR Number first
		$('#addTask2').click(function(){
			$("#serachURNo").dialog("open");
			
			$("input[name='tasksearchURN']").val('');
			
			$("input[name='taskFindURN']").click(function(){
				$.post("API/taskOutStanding.php", {URNumber: $("input[name='tasksearchURN']").val()}, function(data){				
					var search_val = $("input[name='tasksearchURN']").val();
					if(data == false){
						alert("There is no patient with UR Number: " + search_val + " in our database! Please search again!");
					} else {
						window.location.replace("edit/editTask.php")
					}
					console.log(data);
				});
				return false;
			});
			return false;
		});
		
		// style nav buttons
		$('nav a').button();
		
		

		$("input[name='searchPatient']").click(function(){
			// disable search button if input field is empty
			if($("input[name='URNumber']").val().length == 0){
				alert("Please enter patient's UR Number.");
				return false;	
			} else {
				$.post("API/searchURNo.php", {URNumber: $("input[name='URNumber']").val()}, function(data){				
					var search_val = $("input[name='URNumber']").val();
					if(data == false){
						alert("There is no patient with UR Number: " + search_val + " in our database! Please search again!");
					} else {
						window.location.replace("patientViewRecord.php")
					}
					console.log(data);
				});
			}
			return false;
		});

		// set table class
		$("table").addClass("table table-bordered");
	});
</script>
</body>
</html>
