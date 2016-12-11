<html>
    <head>
        <title>My first PHP Website</title>
    </head>
    <body>
        <h2>Registration Page</h2>
        <a href="index.php">Click here to go back</a><br/><br/>
        <form action="register.php" method="POST">
           Enter Username: <input type="text" name="username" required="required" /> <br/>
           Enter password: <input type="password" name="password" required="required" /> <br/>
           <input type="submit" value="Register"/>
        </form>
    </body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $bool = true;
  $conn_info = 'mysql:host=localhost;dbname=first_db;charset=utf8mb4';
  $conn_username = 'root';
  $conn_pwd = 'root';
  try{
    $conn = new PDO($conn_info,$conn_username,$conn_pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $conn->query('SELECT * FROM users');
 
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      if($username == $row['user_name']){
        $bool = false; // sets bool to false
        Print '<script>alert("Username has been taken!");</script>'; //Prompts the user
        Print '<script>window.location.assign("register.php");</script>'; // redirects to register.php
      }
    }

    if($bool) // checks if bool is true
    {
      $conn->prepare('INSERT INTO users (user_name, password) VALUES (?,?)')->exec([$username,$password]);
      Print '<script>alert("Successfully Registered!");</script>'; // Prompts the user
      Print '<script>window.location.assign("register.php");</script>'; // redirects to register.php
    }
  }
  catch(PDOException $e){
   echo "Error connecting to mysql: ". $e->getMessage();
  }

}

?>