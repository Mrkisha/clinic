<?php

	function cyrillic($string) {
		$table = array(
			'Š'=>'Ш', 'š'=>'ш', 'Đ' =>'Ђ',  'đ'=>'ђ', 'Dj'=>'Ђ', 'dj'=>'ђ',  'Ž'=>'Ж',  'ž'=>'ж',  'Č'=>'Ч',  'č'=>'ч',
			'Ć'=>'Ћ', 'ć'=>'ћ', 'Dž'=>'Џ', 'dž'=>'џ', 'Lj'=>'Љ', 'lj'=>'љ', 'Nj'=>'Њ', 'nj'=>'њ',  'A'=>'А',  'a'=>'а',
			'B'=>'Б', 'b'=>'б', 'V' =>'В',  'v'=>'в',  'G'=>'Г',  'g'=>'г',  'D'=>'Д',  'd'=>'д',  'E'=>'Е',  'e'=>'е',
			'Z'=>'З', 'z'=>'з', 'I' =>'И',  'i'=>'и',  'J'=>'Ј',  'j'=>'ј',  'K'=>'К',  'k'=>'к',  'L'=>'Л',  'l'=>'л',
			'M'=>'М', 'm'=>'м', 'N' =>'Н',  'n'=>'н',  'O'=>'О',  'o'=>'о',  'P'=>'П',  'p'=>'п',  'R'=>'Р',  'r'=>'р',
			'S'=>'С', 's'=>'с', 'T' =>'Т',  't'=>'т',  'U'=>'У',  'u'=>'у',  'F'=>'Ф',  'f'=>'ф',  'H'=>'Х',  'h'=>'х',
			'C'=>'Ц', 'c'=>'ц'
		);
		
		return strtr($string, $table);
	}

		
	function mysql_prep( $value ) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on, then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	
	function protect($string){
		$string = mysql_real_escape_string($string);
		$string = strip_tags($string);
		$string = addslashes($string);
		
		return $string;
	}
	
	function check_session(){
		if(!isset($_SESSION['username'])){
			redirect_to("admin/login.php");
		}
	}
	
	function is_session(){
		if(isset($_SESSION['username'])){
			redirect_to("../admin/index.php");
		}
	}
	
	
	
	function redirect_to($location = NULL) {
		if ($location != NULL) {
			header("Location:{$location}");
			exit;
		}
	}

	function myTruncate($string, $limit, $break=".", $pad="..."){
		// return with no change if string is shorter than $limit
		if(strlen($string) <= $limit) return $string;
		
		// is $break present between $limit and the end of the string?
		if(false !== ($breakpoint= strpos($string, $break, $limit))){
			if($breakpoint < strlen($string) -1){
				$string = substr($string, 0, $breakpoint) . $pad;
			}
		}
		return $string;
	}

	function clean_url($string) {
		$entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
		$replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
		return str_replace($entities, $replacements, urlencode($string));
	}

	function mysql_fetch_fields($table) {
        // LIMIT 1 means to only read rows before row 1 (0-indexed)
        $result = mysql_query("SELECT * FROM $table");
        $num = mysql_num_fields($result);
		return $num;
	}
	
	function total_pages($tableName){
		$query = "SELECT COUNT(*) as num FROM $tableName";
		$total_pages = mysql_fetch_array(mysql_query($query));
		$total_pages = $total_pages['num'];
		return $total_pages;
	}
	
	function set_start($limit, $page){
		if($page){
			$start = ($page - 1) * $limit; 
		}else{
			$start = 0;	
		}	
		
		return $start;
	}
	
	function pagination_sql($start, $limit, $tableName){
		$query1 = "SELECT * FROM $tableName LIMIT $start, $limit";
		$result = mysql_query($query1);
		return $result;	
	}
	
	function pagination($tableName, $targetpage, $limit){
		//$tableName="properties";		
		//$targetpage = "test2.php";
	
		//Must be set and integer if not redirect to page=1
		if(!isset($_GET['page']) || !(int)$_GET['page']){
			redirect_to($targetpage.'?page=1');
		}
		//Total pages	
		$total_pages = total_pages($tableName);
		
		//redirect to page=1 if page > num rows in a query1
		if($_GET['page'] > ceil($total_pages/$limit)){
			redirect_to($targetpage.'?page=1');
		}
		
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		$start = set_start($limit, $page);
	
		// Get page data
		pagination_sql($start, $limit, $tableName);
		
		// Initial page num setup
		if ($page == 0){$page = 1;}
		$prev = $page - 1;	
		$next = $page + 1;							
		$lastpage = ceil($total_pages/$limit);		
		$LastPagem1 = $lastpage - 1;					
		
		
		$paginate = '';
		if($lastpage > 1)
		{	
			$paginate .= "<div class='paginate'>";
			// Previous
			if ($page > 1){
				$paginate.= "<a href='$targetpage?page=$prev'>previous</a>";
			}else{
				$paginate.= "<span class='disabled'>previous</span>";	
			}
			
			// Pages	
			if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					
				}
			}
			elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
			{
				// Beginning only hide later pages
				if($page < 1 + ($stages * 2))		
				{
					for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
					{
						if ($counter == $page){
							$paginate.= "<span class='current'>$counter</span>";
						}else{
							$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					
					}
					$paginate.= "...";
					$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
					$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";		
				}
				// Middle hide some front and some back
				elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
				{
					$paginate.= "<a href='$targetpage?page=1'>1</a>";
					$paginate.= "<a href='$targetpage?page=2'>2</a>";
					$paginate.= "...";
					for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
					{
						if ($counter == $page){
							$paginate.= "<span class='current'>$counter</span>";
						}else{
							$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					
					}
					$paginate.= "...";
					$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
					$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";		
				}
				// End only hide early pages
				else
				{
					$paginate.= "<a href='$targetpage?page=1'>1</a>";
					$paginate.= "<a href='$targetpage?page=2'>2</a>";
					$paginate.= "...";
					for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page){
							$paginate.= "<span class='current'>$counter</span>";
						}else{
							$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					
					}
				}
			}
						
					// Next
			if ($page < $counter - 1){ 
				$paginate.= "<a href='$targetpage?page=$next'>next</a>";
			}else{
				$paginate.= "<span class='disabled'>next</span>";
				}
				
			$paginate.= "</div>";
			return $paginate;
		}
	}
	
	function age($dob){
		$age = date("Y", time()) - date("Y", strtotime($dob));
		return $age;
	}
	
	// this functions formats dd/mm/yyyy to mysql format Y-m-d
	function format_date($date){
		$date_details = explode("/", $date);
		return date("Y-m-d", mktime(0, 0, 0, $date_details[1], $date_details[0], $date_details[2]));
	}
?>