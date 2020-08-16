<?php

function record_ip() {
	
	require "database.php";
	$conn = new mysqli($servername, $dbUser, $dbPwd, $dbName);
	
	if (!$conn->connect_errno) {
		
		$date = getdate();
		$date = $date["hours"].":".$date["minutes"].":".$date["seconds"]." ".$date["month"]." ".$date["mday"].", ".$date["year"];
		
		$query = "SELECT * FROM ip_list WHERE ip='".$_SERVER['REMOTE_ADDR']."';";
		$result = $conn->query($query);
		if ($result->fetch_row()) {
			
			$result->free_result();
			$query = "UPDATE `ip_list` SET `date`='".$date."' WHERE `ip`='".$_SERVER['REMOTE_ADDR']."';";
			$conn->query($query);
			
			
		}
		else {
			
			$query = "INSERT INTO `ip_list` (`ip`, `date`) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".$date."');";
			$conn->query($query);
			
		}
		
	}
	
	$conn->close();
	
}

record_ip();

?>