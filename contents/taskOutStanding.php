<?php
	// get patient identifier
	$patient = array();
	$sql = mysql_query("SELECT `Identifier` FROM patient WHERE URNumber = {$_SESSION['URNumber']}");
	$row = mysql_fetch_assoc($sql);
	foreach($row as $key => $value){
		$patient[$key] = $value;
	}

	$sql = mysql_query('SELECT
							    `patient`.`URNumber`
							    , `patient`.`Surname`
							    , `patient`.`FirstName`
							    , `tasks`.`Task`
								, `tasks`.`TaskID`
							    , `staff`.`staffInit`
							    , `tasks`.`TaskComplete`
							    , `tasks`.`TaskArchive`
							FROM
							    `tasks`
							    INNER JOIN `patient` 
							        ON (`tasks`.`Patient_Identifier` = `patient`.`Identifier`)
							    INNER JOIN `staff` 
							        ON (`staff`.`staffID` = `tasks`.`TaskAssign_RegistrarID`)
							WHERE `tasks`.`TaskArchive` = 0
							ORDER BY `tasks`.`TaskComplete`;
						');
?>
<table>
	<tr>
		<th>UR</th><th>Surname</th><th>First Name</th><th>Task</th><th>Assign</th><th>Complete?</th><th>Archive?</th><th></th>
	</tr>
<?php
	if(mysql_num_rows($sql) == 0){
?>
	<tr>
		<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	</tr>
	<tr>
		<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	</tr>
<?php
	} else {
		while($row = mysql_fetch_assoc($sql)){
			if($row['TaskComplete'] == '0'){ $highlight = 'highlight';} else { $highlight = '';};
			echo "<tr class='{$highlight}'>";
			echo "<td>" . $row['URNumber'] . "</td>";
			echo "<td>" . $row['Surname'] . "</td>";
			echo "<td>" . $row['FirstName'] . "</td>";
			echo "<td width='220'>" . $row['Task'] . "</td>";
			echo "<td>" . $row['staffInit'] . "</td>";
			echo "<td>" . ($row['TaskComplete'] == 1 ? 'Yes' : 'No') . "</td>";
			echo "<td>" . ($row['TaskArchive'] == 1 ? 'Yes' : 'No' ) . "</td>";
			echo "<td class='centerElem'><a href='edit/editExistingTask.php?taskID=".$row['TaskID']."' class='btn btn-info'>Edit</a></td>";
			echo "</tr>";
		}
	}
?>
</table>