<?php
	
	if(isset($_POST)){
		print_r($_POST);
	}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<form action="" method="post">
  <input type="checkbox" name="vehicle[]" value="Bike" /> I have a bike<br />
  <input type="checkbox" name="vehicle[]" value="Car"  /> I have a car <br />
  <input type="submit" value="Submit" />
</form>
</body>
</html>