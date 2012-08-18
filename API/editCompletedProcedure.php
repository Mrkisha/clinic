<?php
			
	mysql_query("UPDATE `procedure` SET  
						`Equipment` 	= '{$_POST['equipment']}',
						`ProcComments` 	= '{$_POST['comments']}',
						`ProclistID` 	= {$_POST['procList']},
						`Time` 			= '{$_POST['time']}',
						`Date` 			= '{$_POST['date']}',
						`SurgeonID`		= '{$_POST['ConsultName']}',
						`AssistantID`	= '{$_POST['assistant']}',
						`ProcStatID` 	= 2
					WHERE `OperationID` = " . $_SESSION['OperationID'] );

?>