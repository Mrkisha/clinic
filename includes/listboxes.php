<?php
	
	function gender(){
		$results = "<select name='gender' id='gender'><option value=''>-- Sex --</option>";
		$sql = mysql_query("SELECT * FROM genderlist");
				
		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['GendID']) . "'>" . $row['Gend'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}

	function patient_status(){
		$results = "<select id='patientStatus' name='patientStatus'><option value=''>-- Patient Status --</option>";
		$sql = mysql_query("SELECT * FROM patientstatus");
				
		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['PatientStatusID']) . "'>" . $row['PatientStatus'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}

	function diagnosis(){
		$results = "<select name='Diagnos' id='diagnos'><option value=''>-- Diagnosis --</option>";
		$sql = mysql_query("SELECT * FROM diagnoslist");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['DiagnListID']) . "'>" . $row['Diagnos'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}

	function sit(){
		$results = "<select name='Sit' id='sit'><option value=''>-- Sit list --</option>";
		$sql = mysql_query("SELECT * FROM sitelist");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['SitListID']) . "'>" . $row['Sit'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}
	
	function sid(){
		$results = "<select name='Sid' id='sid'><option value=''>-- Sid list --</option>";
		$sql = mysql_query("SELECT * FROM sidelist");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['SidID']) . "'>" . $row['Sid'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}
	
	function primReg(){
		$results = "<select name='RegistrarName' id='RegistrarName'><option value=''>-- Prim Reg --</option>";
		$sql = mysql_query("SELECT * FROM staff WHERE staffTypeID = 2");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['staffID']) . "'>" . $row['staffName'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}
	
	function primConsult(){
		$results = "<select name='ConsultName' id='ConsultName'><option value=''>-- Surgeon --</option>";
		$sql = mysql_query("SELECT * FROM staff WHERE staffTypeID = 1");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['staffID']) . "'>" . $row['staffName'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}
	
	function assistant(){
		$results = "<select name='assistant' id='assistant'><option value=''>-- Assistant --</option>";
		$sql = mysql_query("SELECT * FROM staff WHERE staffTypeID = 1");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['staffID']) . "'>" . $row['staffName'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}
	
	function procStatus(){
		$results = "<select id='procStatus' name='procStatus'><option value=''>-- Proc Status --</option>";
		$sql = mysql_query("SELECT * FROM  `procstatus` ");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['ProcStatID']) . "'>" . $row['ProcStat'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}
	
	function procList(){
		$results = "<select name='procList' id='procList'><option value=''>-- Proc List --</option>";
		$sql = mysql_query("SELECT * FROM  `proclist` ");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['ProclistID']) . "'>" . $row['Proc'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}
	
	function admitType(){
		$results = "<select name='admitType' id='admitType'><option value=''>-- Admit type --</option>";
		$sql = mysql_query("SELECT * FROM  `admittype` ");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['AdmitTypeID']) . "'>" . $row['AdmitType'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}
	
	function referral(){
		$results = "<select name='referral' id='referral'><option value=''>-- Referral src --</option>";
		$sql = mysql_query("SELECT * FROM  `referralsource` ");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['RefsourceID']) . "'>" . $row['RefSource'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}
	
	function admitFrom(){
		$results = "<select name='admitFrom' id='admitFrom'><option value=''>-- Admitted from --</option>";
		$sql = mysql_query("SELECT * FROM  `origdestin` ");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['OrgDestID']) . "'>" . $row['OriginDestin'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}
	
	function dischTo(){
		$results = "<select name='dischTo' id='dischTo'><option value=''>-- Dischareged to --</option>";
		$sql = mysql_query("SELECT * FROM  `origdestin` ");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['OrgDestID']) . "'>" . $row['OriginDestin'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}
	
	function wardList(){
		$results = "<select name='wardList' id='wardList'><option value=''>-- Ward list --</option>";
		$sql = mysql_query("SELECT * FROM  `wards` ");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['WardID']) . "'>" . $row['Ward'] . '</option>';
		}
		$results .= "</select>";
		return $results;
	}
	
	function condiotoonList_admission($id){
		$results = "<select name='conditionID' id='conditionID'><option value=''>-- Condition --</option>";
		$sql = mysql_query("SELECT
								    `diagnoslist`.`Diagnos`
								    , `sidelist`.`Sid`
								    , `sitelist`.`Sit`
								    , `condition`.`ConditionID`
								FROM
								    `diagnoslist`
								    INNER JOIN `condition` 
								        ON (`diagnoslist`.`DiagnListID` = `condition`.`DiagnListID`)
								    INNER JOIN `sidelist` 
								        ON (`sidelist`.`SidID` = `condition`.`SideID`)
								    INNER JOIN `sitelist` 
								        ON (`sitelist`.`SitListID` = `condition`.`SitID`)
								WHERE `condition`.`Patient_Identifier` = $id
							");
										
		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['ConditionID']) . "'>" . $row['Diagnos'] . ' ' . $row['Sid'] .' ' . $row['Sit'] .'</option>';
		}
		
		$results .= "</select>";
		return $results;
	}

	function registrar_role(){
		$results = "<select name='role' id=''><option value=''>-- Registrar role list --</option>";
		$sql = mysql_query("SELECT * FROM  `regrolelist` ");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['regrolelistID']) . "'>" . $row['regrolelistvalue'] . '</option>';
		}
		$results .= "</select>";
		return $results;

	}
	
	function surg_and_assist_comProc($name, $desc){
		$results = "<select name='$name' id='$name'><option value=''>-- ".ucfirst($desc)." --</option>";
		$sql = mysql_query("SELECT * FROM staff");

		while($row = mysql_fetch_assoc($sql)){
			$results .= "<option value='" . strtolower($row['staffID']) . "'>" . $row['staffName'] . '</option>';
		}
		
		$results .= "</select>";
		return $results;
	}

?>