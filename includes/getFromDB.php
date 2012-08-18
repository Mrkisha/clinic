<?php

	function getDiagnose($id){
		$sql = mysql_query("SELECT * FROM diagnoslist WHERE DiagnListID  = $id");
		while($row = mysql_fetch_assoc($sql)){
			$result = $row['Diagnos'];
		}
		return $result;
	}
	
	function getSite($id){
		$sql = mysql_query("SELECT * FROM sitelist WHERE SitListID  = $id");
		while($row = mysql_fetch_assoc($sql)){
			$result = $row['Sit'];
		}
		return $result;
	}
	
	function getSide($id){
		$sql = mysql_query("SELECT * FROM sidelist WHERE SidID  = $id");
		while($row = mysql_fetch_assoc($sql)){
			$result = $row['Sid'];
		}
		return $result;
	}

?>