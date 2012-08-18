<?php
	$patient = array();
	$sql = mysql_query("SELECT `Identifier` FROM patient WHERE URNumber = {$_SESSION['URNumber']}");
	if(mysql_num_rows($sql) == 1){
		
		$row = mysql_fetch_assoc($sql);
		
		foreach($row as $key => $value){
			$patient[$key] = $value;
		}
		
		$sql = mysql_query("SELECT `condition`.`ConditionID`, `diagnoslist`.`Diagnos`, `sidelist`.`Sid`, `sitelist`.`Sit`, `condition`.`InjuryDate`, `condition`.`CondComments`
								FROM
									`condition`
									INNER JOIN `sidelist` ON (`condition`.`SideID` = `sidelist`.`SidID`)
									INNER JOIN `sitelist` ON (`condition`.`SitID` = `sitelist`.`SitListID`)
									INNER JOIN `diagnoslist` ON (`diagnoslist`.`DiagnListID` = `condition`.`DiagnListID`)
								WHERE `Patient_Identifier` = '{$patient['Identifier']}'
								ORDER BY `InjuryDate` DESC
							");
?>

<table>
	<form action="redirect.php" method="post"></form>
		<tr>
			<th>Diagnosis</th><th>Side</th><th>Site</th><th>Injuery Date</th><th>Comments</th><th>Activate</th><th></th>
		</tr>
<?php
			while($row = mysql_fetch_assoc($sql)){
				echo "<tr>";
				echo "<td>".$row['Diagnos']."</td>";
				echo "<td>".$row['Sid']."</td>";
				echo "<td>".$row['Sit']."</td>";
				echo "<td>".date("d/m/Y", strtotime($row['InjuryDate']))."</td>";
				echo "<td>".$row['CondComments']."</td>";
				echo "<td class='centerElem'><input type=\"button\" name=\"activate\" value='Activate' class='prcBtn'><input type='hidden' name='conditionID' value='".$row['ConditionID']."'></td>";
				echo "<td class='centerElem'><a href='edit/editExistingCondition.php?condition_id={$row['ConditionID']}'>Edit</a></td>";
				echo "</tr>";
			}
	
?>
	</form>
	
</table>
<?php
	} else {
		echo "yo";
	}

?>