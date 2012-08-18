<?php
	session_start();
	
	require_once('../includes/database.php');
	require_once('../includes/functions.php');

	if($_POST){
		if(isset($_POST['saveAndRetrieve'])) {
			require_once('../API/editPatient.php');
			redirect_to('../patientViewRecord.php');
			
		} elseif (isset($_POST['addAndRetrieve'])){
			require_once '../API/addPatient.php';
			redirect_to('../patientViewRecord.php');
			
		} elseif(isset($_POST['addAndNewCond'])){
			require_once '../API/addPatient.php';
			redirect_to('editCondition.php');
			
		} elseif(isset($_POST['saveChangesGoPatientRec'])) {
			//editCondition 1st button
			require_once('../API/editCondition.php');
			redirect_to('../patientViewRecord.php');
			
		} elseif(isset($_POST['saveChangesAddProcedure'])) {
				//editCondition 2nd
				//operationID = procedureID
			require_once('../API/editCondition.php');
			redirect_to('editPlannedProcedure.php');
			
		} elseif(isset($_POST['saveChangesCompletedProcedure'])) {
			//editCondition 3rd button
			require_once('../API/editCondition.php');
			redirect_to('editCompletedProcedure.php');
			
		} elseif(isset($_POST['savePlanProcAndReturn'])){
			//editPlannedProcedure 1st button
			require_once('../API/editPlannedProcedure.php');
			redirect_to('../patientViewRecord.php');
			
			
		} elseif(isset($_POST['savePlanGoToTask'])){			
			require_once('../API/editPlannedProcedure.php');
			redirect_to('../taskList.php');
			
		} elseif(isset($_POST['convToComplProc'])){	
			require_once('../API/editPlannedProcedure.php');
			redirect_to('editCompletedProcedure.php');
			
		} elseif(isset($_POST['saveAddRegRole'])){	
			//editCompletedProcedure 1nd button	
			// get patient ID
			$sql_id = mysql_query(
			"SELECT `Identifier` FROM `patient` WHERE `URNumber` = {$_SESSION['URNumber']}"
			);
			
			$patient_identifier = '';
			while($row = mysql_fetch_assoc($sql_id)){
				$patient_identifier = $row['Identifier'];
			}
			
			// add another procedure to db
			mysql_query("INSERT INTO `procedure` (`Condition_ConditionID`, `ProcStatID`)
							VALUES (
								{$_SESSION['ConditionID']},
								2
							)
				");
			// get the id, if on add new procedure user decides not to insert data, 
			// then we have to delete previously added row
			$_SESSION['OperationID'] = mysql_insert_id();
			require_once('../API/editCompletedProcedure.php');
			redirect_to('../add/addRegistrarRole.php');
			
		} elseif(isset($_POST['saveGotoViewRec'])){
			// unset this session variable
			if(isset($_SESSION['add_planned_procedure'])){
				unset($_SESSION['add_planned_procedure']);
			}
			
			if(isset($_SESSION['condition_ID'])){
					// get patient ID
				$sql_id = mysql_query(
				"SELECT `Identifier` FROM `patient` WHERE `URNumber` = {$_SESSION['URNumber']}"
				);
				
				$patient_identifier = '';
				while($row = mysql_fetch_assoc($sql_id)){
					$patient_identifier = $row['Identifier'];
				}
				
				
				
				// add another procedure to db
				mysql_query("INSERT INTO `procedure` (`Condition_ConditionID`, `ProcStatID`)
								VALUES (
									{$_SESSION['ConditionID']},
									2
								)
					");
				// get the id, if on add new procedure user decides not to insert data, 
				// then we have to delete previously added row
				$_SESSION['OperationID'] = mysql_insert_id();
			}
			//editCompletedProcedure 2st button
			require_once('../API/editCompletedProcedure.php');
			redirect_to('../patientViewRecord.php');
			
		} elseif($_POST['addAnotherProc']){
			//editCompletedProcedure 3nd button	
			if(!isset($_SESSION['condition_ID'])){
				// update existing one
				include('../API/editCompletedProcedure.php');
			}
			
			// get patient ID
			$sql_id = mysql_query(
			"SELECT `Identifier` FROM `patient` WHERE `URNumber` = {$_SESSION['URNumber']}"
			);
			
			$patient_identifier = '';
			while($row = mysql_fetch_assoc($sql_id)){
				$patient_identifier = $row['Identifier'];
			}
			
			
			
			// add another procedure to db
			mysql_query("INSERT INTO `procedure` (`Condition_ConditionID`, `ProcStatID`)
							VALUES (
								{$_SESSION['ConditionID']},
								2
							)
				");
			// get the id, if on add new procedure user decides not to insert data, 
			// then we have to delete previously added row
			$_SESSION['OperationID'] = mysql_insert_id();
			
			require_once('../API/editCompletedProcedure.php');

			redirect_to('editCompletedProcedure.php');
///////////////////////////////////////////////////////////////////////////////
		} elseif(isset($_POST['findUrNo'])){
			//destroy sessions for new search
			
			//patientViewRecord find button
			// get patient ID (identifier)
			$patient_id = array();
			$sql = mysql_query("SELECT `Identifier`, `URNumber`	FROM `patient` WHERE URnumber = {$_POST['urNo']}");
			$row = mysql_fetch_assoc($sql);
			if($row == 1){
				foreach($row as $key => $value){
					$patient_id[$key] = $value;
				}
				
				$_SESSION['URNumber'] = $patient_id['URNumber'];
			}
			redirect_to("test.php");
			
		} elseif(isset($_POST['addTask'])){
			redirect_to('editTask.php');
			
		} elseif(isset($_POST['addCondition'])){
			
			redirect_to('editCondition.php');
		} elseif(isset($_POST['addPlannedProcedure'])){
			
			redirect_to('editPlannedProcedure.php');
		} elseif(isset($_POST['addCompleteProcedure'])){
			redirect_to('editCompletedProcedure.php');
			
		} elseif(isset($_POST['saveTaskGoToRec'])){
			// editTask 1st buttom
			require_once('../API/editTasks.php');
			redirect_to('../patientViewRecord.php');
			
		} elseif(isset($_POST['saveTaskGoToTaslkList'])){
			// editTask 2nd buttom
			require_once('../API/editTasks.php');
			redirect_to('../taskList.php');
			
		} elseif(isset($_POST['saveAddNewTask'])){
			// editTask 3nd buttom
			require_once('../API/editTasks.php');
			redirect_to('editTask.php');
			
		} elseif(isset($_POST['addTask2'])){

			redirect_to('editTask.php');
		} elseif(isset($_POST['addOutstanding'])){
			redirect_to('../outstandingCases.php');
			
		} elseif(isset($_POST['addTask2'])){
			redirect_to('edit/editTask.php');
			
		} elseif(isset($_POST['updateTaskGoToRec'])){	
			require_once('../API/updateTasks.php');
			redirect_to('../patientViewRecord.php');
		
		} elseif(isset($_POST['updateCondition'])) {
			require_once('../API/updateCondition.php');
			redirect_to('../patientViewRecord.php');
			
		} elseif(isset($_POST['updateChangesAddProcedure'])) {
			//editExistingCondition 2nd
			//operationID = procedureID
			require_once('../API/editExistingCondition.php');
			redirect_to('editPlannedProcedure.php');
			
		} elseif(isset($_POST['updateChangesCompletedProcedure'])) {
			//editCondition 3rd button
			require_once('../API/editExistingCondition.php');
			redirect_to('editCompletedProcedure.php');
		
		} elseif(isset($_POST['updateAddRegRole'])){
			// editExistingProcedure 1nd button
			require_once('../API/updateProcedure.php');
			redirect_to('../add/addRegistrarRole.php');
				
		} elseif(isset($_POST['editGotoViewRec'])){
			// editExistingProcedure 2nd button
			require_once('../API/updateProcedure.php');
			redirect_to('../patientViewRecord.php');
			
		}  elseif(isset($_POST['saveAdmGoToPatient'])){
			// editAdmission 1st button
			$_SESSION['conditionID'] = mysql_escape_string($_POST['conditionID']);
			require_once('../API/editAdmission.php');
			redirect_to('../patientViewRecord.php');
			
		} elseif(isset($_POST['saveAndAddCond'])){
			// editAdmission 2st button
			$_SESSION['conditionID'] = mysql_escape_string($_POST['conditionID']);
			require_once('../API/editAdmission.php');
			redirect_to('../edit/editCondition.php');
			
		} elseif(isset($_POST['saveAndGotoWard'])){
			// editAdmission 3st button
			$_SESSION['conditionID'] = mysql_escape_string($_POST['conditionID']);
			require_once('../API/editAdmission.php');
			redirect_to('../wardList.php');
			
		} elseif(isset($_POST['saveReturnToProc'])){
			require_once('../API/addRegistrarRole.php');
			redirect_to("../edit/editExistingProcedure.php?procedure_id={$_SESSION['OperationID']}");
			
		} elseif(isset($_POST['addNewAdmission'])){
			redirect_to("../edit/editAdmission.php");
			
		}  elseif(isset($_POST['admitPatient'])){
			redirect_to("../patientAdmission.php");
			
		} elseif(isset($_POST['updatePlanProcAndReturn'])){
			require_once("../API/editExistingPlannedProcedure.php");
			redirect_to('../patientViewRecord.php');
			
		} elseif(isset($_POST['updatePlanGoToTask'])){
			require_once("../API/editExistingPlannedProcedure.php");
			redirect_to('../taskList.php');
			
		} elseif(isset($_POST['updateConvToComplProc'])){
			require_once("../API/editExistingPlannedProcedure.php");
			redirect_to('editExistingProcedure.php?procedure_id='.$_POST['procedure_id']);
			
		} elseif(isset($_POST['udpateAdmGoToPatient'])){
			require_once("../API/editExistingAdmission.php");
			redirect_to('../patientViewRecord.php');
			
		} elseif(isset($_POST['updateAndAddCond'])){
			require_once("../API/editExistingAdmission.php");
			redirect_to('../edit/editCondition.php');
			
		} elseif(isset($_POST['updateAndGotoWard'])){
			require_once("../API/editExistingAdmission.php");
			redirect_to('../wardList.php');
			
		} 
	}
	
	

?>