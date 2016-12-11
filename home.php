<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>My first PHP website</title>
	</head>
	<?php
	if(!isset($_SESSION['user'])){ //checks if user is logged in
		header("location:index.php"); // redirects if user is not logged in
	}
	
	$user = $_SESSION['user']; //assigns user value
	?>
	<body>
		<h2>Home Page</h2>
		<p>Hello <?php Print "$user"?>!</p> <!--Displays user's name-->
		<a href="logout.php">Click here to logout</a><br/><br/>
		<form action="add.php" method="POST">
			Add more to list: <input type="text" name="details"/><br/>
			public post? <input type="checkbox" name="public[]" value="yes"/><br/>
			<input type="submit" value="Add to list"/>
		</form>
		<h2 align="center">My list</h2>
		<table border="1px" width="100%">
			<tr>
				<th>Id</th>
				<th>Details</th>
				<th>Post Time</th>
				<th>Edit Time</th>
				<th>Edit</th>
				<th>Delete</th>
				<th>Public Post</th>
			</tr>
			<?php
				$conn_info = 'mysql:host=localhost;dbname=first_db;charset=utf8mb4';
				$conn_username = 'root';
				$conn_pwd = 'root';
			  	try{
				    	$conn = new PDO($conn_info,$conn_username,$conn_pwd);
				    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				    	$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				    	$stmt = $conn->query("Select * from list");
				    	foreach ($stmt as $row) {
				    		Print "<tr>";
							Print '<td align="center">'. $row['list_id'] . "</td>";
							Print '<td align="center">'. $row['details'] . "</td>";
							Print '<td align="center">'. $row['posted_date']. " - ". $row['posted_time']."</td>";
							Print '<td align="center">'. $row['edited_date']. " - ". $row['edited_time']. "</td>";
							Print '<td align="center"><a href="edit.php?id='. $row['list_id'] .'">edit</a> </td>';
							Print '<td align="center"><a href="#" onclick="myFunction('.$row['list_id'].')">delete</a> </td>';
							Print '<td align="center">'. $row['public']. "</td>";
							Print "</tr>";
				    	}
					}
					catch(PDOException $e){
					   echo "Error connecting to mysql: ". $e->getMessage();
					}
			?>
		</table>
		<script>
			function myFunction(id)
			{

				if (confirm("Are you sure you want to delete this record?")){
				  	window.location.assign("delete.php?id=" + id);
				  }
			}
		</script>
	</body>
</html>