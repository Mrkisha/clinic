<?php 
	session_start();
	
	require_once('includes/database.php');
?>
<!DOCTYPE HTML>
<html>
<meta charset="utf-8">
<link rel="stylesheet" href="css/main2.css">
<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.20.custom.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
<script src="bootstrap/js/bootstrap.min.js"></script>
<title>Search for patient</title>
<style type="text/css">
	td, tr {
		padding: 0!important;
		margin: 0!important;
	}
</style>
<body>
	<div style="margin: 0 auto; width: 640px;">
		<form class="well form-inline" action="searchPatient.php" method="post">
			<label>Search UR Number: </label><input type="text" name="search" /><input class="btn btn-small btn-primary" type="submit" name="submit" value="Find" />
			<a href="edit/addPatient.php" class=" offset1 btn btn-primary btn-small pull-right">Add New Patient</a>
		</form>
		
<?php
	
	if(isset($_POST['search'])){
		if(strlen($_POST['search']) < 2){
			echo "Length of a search term needs to be 2 or more characters!";
			die;
		}

		$search_term = "'%".mysql_real_escape_string($_POST['search'])."%'";
		$sql = mysql_query("SELECT

								    `patient`.`Identifier`
								    , `patient`.`URNumber`
								    , `patient`.`Surname`
								    , `patient`.`FirstName`
								    , `patient`.`DOB`
								    , `patient`.`Comments`
								    , `genderlist`.`Gend`
								FROM
								    `patient`
								    INNER JOIN `genderlist` 
								        ON (`patient`.`GendID` = `genderlist`.`GendID`)
							WHERE patient.URNumber LIKE ".$search_term);
?>
		<table class="table table-condensed">
			<tr>
				<th>URNumber</th>
				<th>Name</th>
				<th>DOB</th>
				<th>Gender</th>
				<th>Edit</th>
			</tr>
<?php
		while($row = mysql_fetch_assoc($sql)){
			echo "<tr>";
			echo "	<td>{$row['URNumber']}</td>
					<td>".$row['Surname']." ".$row['FirstName']."</td>
					<td>{$row['DOB']}</td>
					<td>{$row['Gend']}</td>
					<td>
						<form id='editPatient{$i}' action='API/setSession.php' method='post'>
							<input type='submit' name='edit' value='View record' title='{$row['URNumber']}' class='btn btn-info btn-mini'>
							<input type='hidden' name='URNumber' value='{$row['URNumber']}' >
						</form>
					</td>";
			echo "</tr>";
		}
	}
?>
		</table>
		<div id="results"></div>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function(){
		$("input[name='edit']").click(function(){
			// Get the src of the image
			var urno = $(this).parent().attr('id');
			
			// Send Ajax request to backend.php, with src set as "img" in the POST data
			$.post("../API/setSession.php", {URNumber: $(this).attr('title')}, function(data){
				console.log(data);
			});
		});
	});
</script>
</body>
</html>