<?php
			ini_set('mysql.connect_timeout', 300);
			ini_set('default_socket_timeout', 300);

			include_once "resource/session.php";
					
			
			$servername = "127.0.0.1.3306";
			$username = "root";
			$password = "mariadb";
			$dbname = "Farm";
			
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
           
			
?>