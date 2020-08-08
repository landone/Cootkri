<?php

session_start();

?>

<html>

	<link rel="stylesheet" type="text/css" href="style.css">

	<div class="circle center"></div>

	<form class="center square" action="index.php" method="post">

		<?php
			
			if (isset($_SESSION['userID'])) {
				
				echo "Logged in as: ".$_SESSION['username']."<br>";
				
			}
			else if (isset($_POST['login-submit'])) {
				
				require "database.php";
				
				$conn = new mysqli($servername, $dbUser, $dbPwd, $dbName);
				
				if ($conn->connect_errno) {
					echo "SQL Database connection failed<br>";
					die();
				}
				
				$usr = $_POST['user'];
				$pwd = $_POST['pass'];
				
				if (!empty($usr) && !empty($pwd)) {
					
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
							session_start();
							$_SESSION['userID'] = $row[0];
							$_SESSION['username'] = $row[1];
							echo "Logged in as: ".$_SESSION['username']."<br>";
						}
						$result->free_result();
					}
					
				}
				
				$conn->close();
				
			}
			
		?>

		<input type="text" id="user" name="user" placeholder="Username" ><br><br>
		<input type="password" id="pass" name="pass" placeholder="Password"><br><br>
		<input type="submit" name="login-submit" value="Login"><br><br>

	</form>


</html>