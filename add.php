<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("location:index.php");
	}

	if($_SERVER['REQUEST_METHOD'] = "POST") //Added checking to keep the page secured
	{
		$details = $_POST['details'];
		$time = strftime("%X");//time
		$date = strftime("%B %d, %Y");//date
		$decision ="no";

		$conn_info = 'mysql:host=localhost;dbname=first_db;charset=utf8mb4';
		$conn_username = 'root';
		$conn_pwd = 'root';
	  	try{
		    	$conn = new PDO($conn_info,$conn_username,$conn_pwd);
		    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    	$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		    	if(isset($_POST['public'])){
		    		foreach($_POST['public'] as $each_check) //gets the data from the checkbox
			 		{
			 			if($each_check !=null ){ //checks if the checkbox is checked
			 				$decision = "yes"; //sets teh value
			 			}
			 		}	
		    	}
		    	
				$stmt = $conn->prepare("INSERT INTO list (details, posted_date, posted_time, public) VALUES (?,?,?,?)");
				$stmt->execute([$details,$date,$time,$decision]);
				header("location: home.php");
			}
			catch(PDOException $e){
			   echo "Error connecting to mysql: ". $e->getMessage();
			}
	}
	else
	{
		header("location:home.php"); //redirects back to home
	}
?>