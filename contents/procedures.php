<?php
	session_start();
	
	require_once('../includes/database.php');
	
	$_SESSION['ConditionID'] = $_POST['conditionID'];
	
	// get patient identifier
	$patient = array();
	$sql = mysql_query("SELECT Identifier FROM patient WHERE URNumber = '{$_SESSION['URNumber']}'");
	$row = mysql_fetch_assoc($sql);
	
	foreach($row as $key => $value){
		$patient[$key] = $value;
	}
	
	$data = array();
	$sql = mysql_query("SELECT * FROM (
							SELECT
								`procedure`.`OperationID`
								,`proclist`.`Proc`
								, `surgeon`.`staffName` AS `surgeon`
								, `assistant`.`staffName` AS `assistant`
								, `procedure`.`Date`
								, `procedure`.`Time`
								, `procedure`.`Condition_ConditionID`
								, `condition`.`Patient_Identifier`
								, `procedure`.`ProcStatID`
							FROM `proclist`
								INNER JOIN `procedure` ON (`proclist`.`ProclistID` = `procedure`.`ProclistID`)
								INNER JOIN `staff` AS `surgeon` ON (`surgeon`.`staffID` = `procedure`.`SurgeonID`)
								INNER JOIN `staff` AS `assistant` ON (`assistant`.`staffID` = `procedure`.`AssistantID`)
								INNER JOIN `condition` ON (`condition`.`ConditionID` = `procedure`.`Condition_ConditionID`)
							WHERE (`condition`.`Patient_Identifier` = {$patient['Identifier']} 
								AND `procedure`.`ProcStatID` = 2
								AND `procedure`.`Condition_ConditionID` = {$_POST['conditionID']})
															
							UNION ALL
							
							SELECT
								`procedure`.`OperationID`
								,`proclist`.`Proc`
								, `surgeon`.`staffName` AS `surgeon`
								, '' AS `assistant`
								, `procedure`.`planDate` AS `Date`
								, `procedure`.`planTime` AS `Time`
								, `procedure`.`Condition_ConditionID`
								, `condition`.`Patient_Identifier`
								, `procedure`.`ProcStatID`
							FROM `proclist`
								INNER JOIN `procedure` ON (`proclist`.`ProclistID` = `procedure`.`PlanOperation`)
								INNER JOIN `staff` AS `surgeon` ON (`surgeon`.`staffID` = `procedure`.`planSugeon`)
								INNER JOIN `condition` ON (`condition`.`ConditionID` = `procedure`.`Condition_ConditionID`)
							WHERE (`condition`.`Patient_Identifier` = {$patient['Identifier']} 
								AND `procedure`.`ProcStatID` = 1 
								AND `procedure`.`Condition_ConditionID` = {$_POST['conditionID']})
							) `procedures`
							ORDER BY `Date`, `Time`
	
	
		");
	
	/*$sql = mysql_query("SELECT  `procedure`.`OperationID`, `proclist`.`Proc` ,  `staff`.`staffName` as surgeon ,  `staff_1`.`staffName` as assistant ,  `procedure`.`Date` ,  `procedure`.`Time` 
							FROM  `proclist` 
							INNER JOIN  `procedure` ON (  `proclist`.`ProclistID` =  `procedure`.`ProclistID` ) 
							INNER JOIN  `staff` ON (  `staff`.`staffID` =  `procedure`.`SurgeonID` ) 
							INNER JOIN  `staff` AS  `staff_1` ON (  `staff_1`.`staffID` =  `procedure`.`AssistantID` ) 
							INNER JOIN  `condition` ON (  `procedure`.`Condition_ConditionID` =  `condition`.`ConditionID` ) 
							INNER JOIN  `patient` ON (  `condition`.`Patient_Identifier` =  `patient`.`Identifier` ) 
							WHERE  `condition`.`Patient_Identifier` = {$patient['Identifier']}
								AND ConditionID = {$_POST['conditionID']}
							ORDER BY  `procedure`.`Date` DESC ,  `procedure`.`Time` DESC 
					");*/
					/*echo "SELECT  `procedure`.`OperationID`, `proclist`.`Proc` ,  `staff`.`staffName` as surgeon ,  `staff_1`.`staffName` as assistant ,  `procedure`.`Date` ,  `procedure`.`Time` 
							FROM  `proclist` 
							INNER JOIN  `procedure` ON (  `proclist`.`ProclistID` =  `procedure`.`ProclistID` ) 
							INNER JOIN  `staff` ON (  `staff`.`staffID` =  `procedure`.`SurgeonID` ) 
							INNER JOIN  `staff` AS  `staff_1` ON (  `staff_1`.`staffID` =  `procedure`.`AssistantID` ) 
							INNER JOIN  `condition` ON (  `procedure`.`Condition_ConditionID` =  `condition`.`ConditionID` ) 
							INNER JOIN  `patient` ON (  `condition`.`Patient_Identifier` =  `patient`.`Identifier` ) 
							WHERE  `condition`.`Patient_Identifier` = {$patient['Identifier']}
								AND ConditionID = {$_POST['conditionID']}
							ORDER BY  `procedure`.`Date` DESC ,  `procedure`.`Time` DESC";*/

	if(mysql_num_rows($sql) > 0){
		
		$sql2 = mysql_query("SELECT `diagnoslist`.`Diagnos`, `sidelist`.`Sid`, `sitelist`.`Sit`, 
										`condition`.`InjuryDate`, `condition`.`Patient_Identifier`, `condition`.`ConditionID`
								FROM `diagnoslist`
								INNER JOIN `condition` ON (`diagnoslist`.`DiagnListID` = `condition`.`DiagnListID`)
								INNER JOIN `sidelist` ON (`sidelist`.`SidID` = `condition`.`SideID`)
								INNER JOIN `sitelist` ON (`sitelist`.`SitListID` = `condition`.`SitID`)
								WHERE (`condition`.`Patient_Identifier` = {$patient['Identifier']})
								LIMIT 0, 1;
							");
							
						
		$data2 = array();			
		$row2 = mysql_fetch_assoc($sql2);
		
		foreach($row2 as $key => $value){
			$data2[$key] = $value;
		}
?>
<form action="edit/redirect.php" method="post">
	<input type="submit" name="addPlannedProcedure" value="Add Planned Procedure" class="btn btn-success">
	<input type="submit" name="addCompleteProcedure" value="Add Complete Procedure" class="btn btn-warning">
	<input class="btn disabled span2" value="Procedures: " ><br>
</form>
	<?php echo $data2['Diagnos'].", ".$data2['Sid'].", ".$data2['Sit'].", ".$data2['InjuryDate']; ?>
	<table>
		<tr>
			<th>Operation</th><th>Surgeon</th><th>Assistant</th><th>Date</th><th>Time</th><th></th>
		</tr>
<?php
		while($row = mysql_fetch_assoc($sql)){
			foreach($row as $key => $value){
				$data[$key] = $value;
			}
			
			echo "<tr>";
				echo "<td>{$row['Proc']}</td>";
				echo "<td>{$row['surgeon']}</td>";
				echo "<td>{$row['assistant']}</td>";
				echo "<td>".date("d/m/Y", strtotime($row['Date']))."</td>";
				echo "<td>{$row['Time']}</td>";
				echo "<td><a href='edit/";
				if($row['ProcStatID'] == 1){
					echo "editExistingPlannedProcedure";
				} else {
					echo "editExistingProcedure";
				}
				echo ".php?procedure_id={$row['OperationID']}'>Edit</a></td>";
			echo "</tr>";
		}
		
?>
	</table>
<?php
		
	}
?>