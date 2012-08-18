<?php
	session_start();
	require_once('../includes/database.php');
	include_once('../includes/functions.php');
	require_once('../includes/listboxes.php');	
	require_once('../includes/header.php');
	

?>
	<nav>
		<a href="../searchPatient.php" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
			<span class="ui-button-text">Search for Patient</span>
		</a>
<!--		<a href="outstandingCases.php" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
			<span class="ui-button-text">Outstanding Cases</span>
		</a>
-->	</nav>
	<br>
	<div>
<!--	<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em; ">
		<p>
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: 0.3em; "/>
			<strong>Hey!</strong>
			Sample ui-state-highlight style.
		</p>
	</div>
	
	<div class="ui-widget">
		<div class="ui-state-error ui-corner-all" style="padding: 0px 0.7em; ">
			<p>
				<span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em; "/>
				<strong>Erorr:</strong>
				Please fill all the fields!
			</p>
		</div>
	</div>
-->	<?php
	// error container
	$error = 'none';
	
	if(isset($_POST['addPatient'])){
		$count = 6;
		$post_count = count(array_filter($_POST));
		if($post_count < $count){
			$error = "Please fill all the fields!";
		} else {
			
			if((int)$_POST['urNoPatient']){
				$URNumber = mysql_real_escape_string($_POST['urNoPatient']);
			} else {
				$error = 'Please type NUMBERS ONLY for UR No. field';
			}
			
			$surname 	= strlen(mysql_real_escape_string($_POST['surname'])) ? mysql_real_escape_string($_POST['surname']) : myTruncate(mysql_real_escape_string($_POST['surname']), 45, $break=".", $pad="");
			
			$firstName 	= strlen(mysql_real_escape_string($_POST['fistname'])) ? mysql_real_escape_string($_POST['fistname']) : myTruncate(mysql_real_escape_string($_POST['fistname']), 45, $break=".", $pad="");
			
			$dob 		= mysql_real_escape_string($_POST['dob']);
			
			$gendID 	= (int)$_POST['gender'] ? mysql_real_escape_string($_POST['gender']) : 1;
			
			$comments 	= strlen(mysql_real_escape_string($_POST['comments'])) < 500 ? mysql_real_escape_string($_POST['comments']) : myTruncate(mysql_real_escape_string($_POST['comments']), 500, $break=".", $pad="");

			// check if ur number already exists in db
			$check_urno = mysql_query('SELECT `URNumber` FROM `patient` WHERE `URNumber` = ' . $URNumber);

			if(mysql_num_rows($check_urno) == 1){
				$error = "This UR Number is already in use!<br>Please choose another.";
			} else {
	
				mysql_query("INSERT INTO `patient` 
												(`URNumber`, `Surname`, `FirstName`, `DOB`, `GendID`, `Comments`) 
										VALUES 	( $URNumber, '$surname', '$firstName', '$dob', $gendID, '$comments')") or die(mysql_query());
										
				// display confirmation
				echo "<div class='ui-widget alert'>
						<div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0px 0.7em;'>
							<p>
								<span class='ui-icon ui-icon-info' style='float: left; margin-right: 0.3em;'></span>
								<strong>Success:</strong>
								Patient has been added!
							</p>
						</div>
					</div>";
			}
		}
	}
	
	// display errors
	if(!empty($error) && $error != 'none'){
		echo "<div class='ui-widget error'>
				<div class='ui-state-error ui-corner-all' style='padding: 0px 0.7em;'>
					<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: 0.3em;'></span><strong>Erorr:</strong> ".$error."</p>
				</div>
			</div><br>";
	}
?>
		<form id="patient" method="post">
			<label><span class='red'>*</span>UR No.</label>
				<input id="urn" type="text" name="urNoPatient" value="<?php //echo $row['URNumber']; ?>"/><br>
			<label><span class='red'>*</span>Surname</label>
				<input id="surname" type="text" name="surname" value="<?php //echo ($row['Surname']);?>"><br>
			<label><span class='red'>*</span>First Name</label>
				<input id="name" type="text" name="fistname" value="<?php //echo $row['FirstName']; ?>"><br>
			<label><span class='red'>*</span>D.O.B (yyyy-mm-dd)</label>
				<input id="dob" type="text" name="dob" value="<?php //echo $row['DOB']; ?>"><br>
			<label><span class='red'>*</span>Sex</label><?php echo gender(); ?><br>
			<label><span class='red'>*</span>Admission Status</label><?php echo patient_status() ?><br>
			<div><label><span class='red'>*</span>Comments</label>
				<textarea name="comments" rows="7" cols="30"><?php //echo $row['Comments']; ?></textarea></div>
			<div id="buttonsBar">
				<span class='red'>*</span> fileds are required<input type="submit" value="Add Patient" class="buttons" name="addPatient">
			</div>
		</form>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

<script>
	$(document).ready(function(){
		$("#dob").datepicker({
			dateFormat: 'yy-mm-dd' 
		});
		$('nav a').button();
	});	
</script>
</body>
</html>
<?php unset($_POST) ?>