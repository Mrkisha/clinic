<?php

	$patient = array();

	$sql = mysql_query('SELECT
							    `patient`.`URNumber`
							    , `patient`.`Surname`
							    , `patient`.`FirstName`
							    , `patient`.`DOB`
							    , `diagnoslist`.`Diagnos`
								, `sitelist`.`Sit`
								, `sidelist`.`Sid`
							    , `proclist`.`Proc`
								, `procedure`.`OperationID`
							    , `procedure`.`planTime`
							    , `procedure`.`planDate`
							    , `surgeon`.`staffInit` AS `planSurg`
							    , `condition`.`ConditionID`

							FROM `diagnoslist`
							    INNER JOIN `condition` ON (`diagnoslist`.`DiagnListID` = `condition`.`DiagnListID`)
							    INNER JOIN `patient` ON (`condition`.`Patient_Identifier` = `patient`.`Identifier`)
							    INNER JOIN `procedure` ON (`procedure`.`Condition_ConditionID` = `condition`.`ConditionID`)
							    INNER JOIN  `proclist` ON (`proclist`.`ProclistID` =  `procedure`.`PlanOperation`)
							    INNER JOIN `staff` AS `surgeon` ON (`surgeon`.`staffID` = `procedure`.`planSugeon`)
								INNER JOIN `sitelist` ON (`sitelist`.`SitListID` = `condition`.`SitID`)
								INNER JOIN `sidelist` ON (`sidelist`.`SidID` = `condition`.`SideID`) 
							WHERE (`procedure`.`ProcStatID` = 1)
							ORDER BY planDate ASC, planTime ASC, planSugeon ASC
						');
?>
	<table>
		<tr>
			<th>UR</th><th>Surname</th><th>First Name</th><th>Age</th><th>Diagnosis</th><th>Side</th><th>Site</th><th>Plan Operation</th><th>Plan Date</th><th>Plan Time</th><th>Plan Surg</th><th>Plan Reg</th><th></th>
		</tr>
<?php
	if(@mysql_num_rows($sql) < 1){
?>
	<tr>
		<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	</tr>
	<tr>
		<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	</tr>
<?php
	} else {
		while($row = mysql_fetch_assoc($sql)){
			echo "<tr>";
			echo "<td>" . $row['URNumber'] . "</td>";
			echo "<td>" . $row['Surname'] . "</td>";
			echo "<td>" . $row['FirstName'] . "</td>";
			echo "<td>" . age(date("Y-m-d", strtotime($row['DOB']))) . "</td>";
			echo "<td>" . $row['Diagnos'] . "</td>";
			echo "<td>" . $row['Sid'] . "</td>";
			echo "<td>" . $row['Sit'] . "</td>";
			echo "<td>" . $row['Proc'] . "</td>";
			echo "<td>" . date("d/m/Y", strtotime($row['planDate'])) . "</td>";
			echo "<td>" . $row['planTime'] . "</td>";
			echo "<td>" . $row['planSurg'] . "</td>";
			echo "<td>" . $row['planRegistrar'] . "</td>";
			echo "<td><a href='edit/editExistingPlannedProcedure.php?procedure_id=".$row['OperationID']."' class='btn btn-primary btn-mini'>Edit</a></td>";
			echo "</tr>";
		}
	}
?>
</table>
