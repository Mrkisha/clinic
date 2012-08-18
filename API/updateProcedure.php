<?php

	mysql_query("UPDATE `procedure`
					SET 
					  `ProclistID` = {$_POST['procList']},
					  `SurgeonID` = {$_POST['ConsultName']},
					  `AssistantID` = {$_POST['assistant']},
					  `Equipment` = '{$_POST['equipment']}',
					  `Date` = '{$_POST['date']}',
					  `Time` = '{$_POST['time']}',
					  `ProcComments` = '{$_POST['comments']}',
					  `ProcStatID` = 2
					WHERE `OperationID` = " . mysql_real_escape_string($_POST['procedure_id']));


?>