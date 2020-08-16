<?php

require "record_ip.php";
session_start();

?>

<html>

	<link rel="stylesheet" type="text/css" href="style.css">

	<div class="circle center"></div>

	<form class="center square" action="index.php" method="post">

		<?php
			
			if (isset($_POST['login-submit'])) {
				
				require "database.php";
				
				$conn = new mysqli($servername, $dbUser, $dbPwd, $dbName);
				
				if ($conn->connect_errno) {
					echo "SQL Database connection failed<br>";
				}
				else {
					
					$usr = $_POST['user'];
					$pwd = $_POST['pass'];
					$pattern = '/^[a-zA-Z0-9!@#$%^&*()\-=_+]*$/';
					
					if (preg_match($pattern, $usr) && preg_match($pattern, $pwd)) {
						
						$query = "SELECT * FROM users WHERE uid='".$usr."' AND pwd='".$pwd."';";
						$result = $conn->query($query);
						if (!$result){
							echo "Query failure<br>";
						}
						else {
							
							$row = $result->fetch_row();
							if (!$row) {
								echo "Incorrect credentials<br>";
							}
							else {
								$_SESSION['userID'] = $row[0];
								$_SESSION['username'] = $row[1];
								$result->free_result();
								$date = getdate();
								$date = $date["hours"].":".$date["minutes"].":".$date["seconds"]." ".$date["month"]." ".$date["mday"].", ".$date["year"];
								$query = "UPDATE `users` SET `ip`='".$_SERVER['REMOTE_ADDR']."', `last_visit`='".$date."' WHERE `id`='".$_SESSION['userID']."';";
								$conn->query($query);
							}
							
						}
						
					}
					else {
						
						echo "Invalid characters used<br>";
						
					}
					
				}
				$conn->close();
				
			}
			else if (isset($_POST['logout-submit'])) {
				
				unset($_SESSION['userID']);
				unset($_SESSION['username']);
				echo "Logged out<br>";
				
			}
			
			if (isset($_SESSION['userID'])) {
				
				echo "Logged in as: ".$_SESSION['username']."<br>";
				echo "<input type='submit' name='logout-submit' value='Logout'><br><br>";
				
				require "directory.php";
				echoDir("./downloads/".$_SESSION['username']);
				
			}
			else {
				
				echo "<input type='text' id='user' name='user' placeholder='Username' ><br><br>
				<input type='password' id='pass' name='pass' placeholder='Password'><br><br>
				<input type='submit' name='login-submit' value='Login'><br><br>";
				
			}
			
		?>

	</form>


</html>