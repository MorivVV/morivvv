<?php
$kodid =$_GET['id'];
$x = $_GET['x'];
$y = $_GET['y'];
include "db.php";
$sql = "UPDATE bd_css_setting  
       SET x=$x, 
		   y=$y
	   WHERE kod_user=$kodid";
$result = mysqli_query($link, $sql); 
?>