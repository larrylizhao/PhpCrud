<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		session_start();
	  	$username = $_POST['username'];
		$password = $_POST['password'];
		$conn_info = 'mysql:host=localhost;dbname=first_db;charset=utf8mb4';
		$conn_username = 'root';
		$conn_pwd = 'root';
	  	try{
	    	$conn = new PDO($conn_info,$conn_username,$conn_pwd);
	    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    	$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	    	$stmt = $conn->prepare("SELECT * from users WHERE user_name=?");
	    	$stmt->execute([$username]);
	    	foreach ($stmt as $row){
				if($password == $row['password']){
					$_SESSION['user'] = $username; //set the username in a session. This serves as a global variable
					header("location: home.php"); // redirects the user to the authenticated home page
				}
				else{
					Print '<script>alert("Incorrect password!");</script>'; //Prompts the user
					Print '<script>window.location.assign("login.php");</script>'; // redirects to login.php
				}
			}
			Print '<script>alert("Incorrect user name!");</script>'; //Prompts the user
			Print '<script>window.location.assign("login.php");</script>'; // redirects to login.php
	    }
	    catch(PDOException $e){
		   echo "Error connecting to mysql: ". $e->getMessage();
		}

	}
	
?>