<!-- fungsi delete data -->
<?php 
	include "config.php";
	$id=$_POST["id"];
	$sql="delete from data_hp where id='{$id}'";
	if($con->query($sql)){
		echo true;
	}else{
		echo false;
	}
?>