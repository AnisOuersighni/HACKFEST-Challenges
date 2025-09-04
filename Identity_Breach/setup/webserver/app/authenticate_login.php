<?php
ini_set("session.cookie_httponly", True);  //  it instructs PHP to only allow access to session cookies through HTTP. 
					   //This adds an extra layer of security by preventing client-side scripts (such as JavaScript) from accessing session cookies, which helps mitigate certain types of attacks, such as XSS.
include "../phpconf/config.php";

try {
 	//  establishes a connection to a MySQL database using the PDO (PHP Data Objects) extension
 	
    $conn = new PDO("mysql:host=$db_address;dbname=intelDB", $db_username, $db_password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  # to handle the error 
} catch(PDOException $e) {
    echo "Connection to the database failed." . $e->getMessage();
}

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	if (isset($_POST["username"]) && isset($_POST["password"]))
	{
		$username = $_POST["username"];
		$password = $_POST["password"];
		
		// for debugging purposes
		error_log("Username: " . $username . " Password: " . $password);

        $statement = $conn->prepare('SELECT username, password FROM soldiers WHERE username = ? and password = ?');
        $statement->bindParam(1, $username, PDO::PARAM_STR);
        $statement->bindParam(2, $password, PDO::PARAM_STR);

		$statement->execute();
		$row = $statement->fetch();
		if ($row){
			$_SESSION["loggedin"] = true;
			$_SESSION["user"] = $username;
			header('Location: /account.php');
			die();
    	}
		else {
        	header('Location: /login.php?error=wrong');
			die();
    	}

		$result->finalize();
	}
}
?>
