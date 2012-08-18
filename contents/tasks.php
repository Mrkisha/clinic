<?php
	// get patient identifier
	$patient = array();
	$sql = mysql_query("SELECT `Identifier` FROM patient WHERE URNumber = {$_SESSION['URNumber']}");
	$row = mysql_fetch_assoc($sql);
	foreach($row as $key => $value){
		$patient[$key] = $value;
	}

	$sql = mysql_query('SELECT `tasks`.`TaskID`, `tasks`.`TaskCreate` ,  `tasks`.`Task` ,  `staff`.`staffName` ,  `tasks`.`TaskComplete` ,  `tasks`.`TaskArchive` ,  `tasks`.`Patient_Identifier` 
							FROM  `tasks` 
								INNER JOIN  `patient` ON (  `tasks`.`Patient_Identifier` =  `patient`.`Identifier` ) 
								INNER JOIN  `staff` ON (  `staff`.`staffID` =  `tasks`.`TaskAssign_RegistrarID` ) 
							WHERE (`tasks`.`TaskArchive` = 0	AND  `tasks`.`Patient_Identifier` = "' . $patient['Identifier'] . '")
							ORDER BY TaskComplete ASC
						');
?>
<table>
	<tr>
		<th>Date</th><th>Task</th><th>Who</th><th>Done</th><th>Archive</th><th></th>
	</tr>
<?php
	if(mysql_num_rows($sql) == 0){
?>
	<tr>
		<td></td><td></td><td></td><td></td><td></td><td></td>
	</tr>
	<tr>
		<td></td><td></td><td></td><td></td><td></td><td></td>
	</tr>
<?php
	} else {
		while($row = mysql_fetch_assoc($sql)){
			if($row['TaskComplete'] == 1){
				$taskComplete = "Yes";
			} else {
				$taskComplete = "No";
			}
			
			if($row['TaskArchive'] == 1){
				$taskArchive = "Yes";
			} else {
				$taskArchive = "No";
			}
			
			if($taskComplete == 'No'){ $highlight = 'highlight';} else { $highlight = '';};
			echo "<tr class='{$highlight}'>";
			echo "<td>" . date("d/m/Y", strtotime($row['TaskCreate'])) . "</td>";
			echo "<td>" . $row['Task'] . "</td>";
			echo "<td>" . $row['staffName'] . "</td>";
			echo "<td>" . $taskComplete . "</td>";
			echo "<td>" . $taskArchive . "</td>";
?>
				<td class="centerElem">
					<a href="edit/editExistingTask.php?taskID=<?php echo $row['TaskID']; ?>">Edit</a>
				</td>
<?php
			echo "</tr>";
		}
	}
?>
</table>
