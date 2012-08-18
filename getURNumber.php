<?php
	require_once('includes/database.php');

    $search_term = "%".mysql_real_escape_string($_GET['term'])."%";
	
    $sql = mysql_query("SELECT * FROM patient WHERE URNumber LIKE '".$search_term."'");
	
	$return_arr = array();

    while ($row = mysql_fetch_assoc($sql)) {

		$row_array['value'] = $row['URNumber'];
		$row_array['label'] = "{$row['Surname']}, {$row['FirstName']}, {$row['DOB']}, {$row['GendID']}";
        $return_arr[] = $row_array;
	}
	
	/* Toss back results as json encoded array. */
	echo json_encode($return_arr);
	

?>