<?php

	mysql_query("UPDATE `tasks` SET
								`Task` = '{$_POST['task']}',
								`TaskCreate` = '{$_POST['dateTask']}',
								`TaskAssign_RegistrarID` = {$_POST['RegistrarName']},
								`TaskComplete` = '{$_POST['taskComplete']}',
								`TaskArchive` = '{$_POST['taskArchive']}'
							WHERE `TaskID` = " . mysql_real_escape_string($_POST['task_ID']));

?>