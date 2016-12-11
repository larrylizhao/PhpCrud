<!DOCTYPE html>

<html>
    <head>
        <title>My first PHP Website</title>
    </head>
    <body>
        <h2>Your Banking</h2>
        <form action="checklogin.php" method="POST">
           Enter Username: <input type="text" name="username" required="required" /> <br/>
           Enter password: <input type="password" name="password" required="required" /> <br/>
           <input type="submit" value="Login"/>
        </form>        
        <a href="register.php"> Click here to register </a>
    </body>
</html> 