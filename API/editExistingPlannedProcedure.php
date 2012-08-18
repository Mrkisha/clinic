<?php

/*echo "UPDATE `procedure` SET 		
						`Equipment`= '".mysql_real_escape_string($_POST['equipment'])."',
						`ProcComments`= '".mysql_real_escape_string($_POST['comments'])."',
						`PlanOperation`= '".mysql_real_escape_string($_POST['procList'])."',
						`planTime`= '".mysql_real_escape_string($_POST['planTime'])."',
						`planDate`= '".mysql_real_escape_string($_POST['planDate'])."',
						`planSugeon`= '".mysql_real_escape_string($_POST['ConsultName'])."'
					WHERE `OperationID` = " . mysql_real_escape_string($_POST['procedure_id']);*/
			
	mysql_query("UPDATE `procedure` SET 		
						`Equipment`= '".mysql_real_escape_string($_POST['equipment'])."',
						`ProcComments`= '".mysql_real_escape_string($_POST['comments'])."',
						`PlanOperation`= '".mysql_real_escape_string($_POST['procList'])."',
						`planTime`= '".mysql_real_escape_string($_POST['planTime'])."',
						`planDate`= '".mysql_real_escape_string($_POST['planDate'])."',
						`planSugeon`= '".mysql_real_escape_string($_POST['ConsultName'])."'
					WHERE `OperationID` = " . mysql_real_escape_string($_POST['procedure_id']));
?>
