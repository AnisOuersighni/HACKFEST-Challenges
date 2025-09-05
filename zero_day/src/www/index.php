<?php
ini_set('display_errors', 0);  // Don't display errors to the user

$logged = false;

// Check if the user wants to log out (home page)
if (isset($_GET['logout'])) {
    setcookie("session", "", time() - 3600, "/");  // Delete the session cookie by setting it in the past
    header("Location: index.php");  // Redirect to index.php after logging out
    exit();
}

if (isset($_POST['username'])) {
    $username = $_POST["username"];
    $isAgent = 0;
    $b64cookie = base64_encode(json_encode(array("username" => $username, "isAgent" => $isAgent)));
    setcookie("session", $b64cookie, time() + 300, "/");
    $logged = true;
}

if (isset($_COOKIE["session"])) {
    try {
        $session_data = json_decode(base64_decode($_COOKIE["session"]), true);
    } catch (Exception $e) {
        echo "Are you trying to mess with our system ?";
        die();
    }

    if ($session_data == null) {
        echo "Are you trying to mess with our system?";
        die();
    }
    
    if (!array_key_exists("username", $session_data)) {
        echo "Nah, we insist you send your name Agent.";
        die();
    }
    if (!array_key_exists("isAgent", $session_data)) {
        echo "isAgent parameter is mandatory, don't mess with it";
        die();
    }
    if (count($session_data) != 2) {
        echo "don't play with parameters";
        die();
    }
    $username = $session_data["username"];
    if ($username == "") {
        echo "Nah, we insist you send your name Agent.";
        die();
    }
    $isAgent = $session_data["isAgent"];
    if ($isAgent != 0 && $isAgent != 1) {
        echo "Are you trying to mess with our System?";
        die();
    }
    $logged = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Zero-Day - Exfiltration</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <header>
      <h1>Authentication Portal</h1>
    </header>

    <?php if (!$logged): ?>
    <!-- Login Form -->
    <div class="login-box">
      <h2>Please Enter Your Username</h2>
      <form method="POST" action="">
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
        <button type="submit" class="btn">Login</button>
      </form>
    </div>
    <?php else: ?>
    <!-- Logged In Message -->
    <div class="welcome-box">
      <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
      <p>You are now logged in. </p>

      <?php if ($isAgent): 
            setcookie("session", "eyJ1c2VybmFtZSI6ImhhY2tlciIsImlzQWdlbnQiOjF9", time() + 3000, "/");?>
      <div class="agent-box">
        <h3>Special Agent</h3>
        <p>You have access to the Central Operation System.</p>
        <a href="ctOS.php" class="btn">Proceed to Central Operation System</a>
      </div>
      <?php else: ?>
      <p>Only confirmed agents can proceed with this challenge. Please contact your supervisor.</p>
      <?php endif; ?>
      
      <!-- Log out Button -->
      <a href="index.php?logout=true" class="btn">Logout and Go back to Home Page</a>
    </div>
    <?php endif; ?>
  </div>
</body>
</html>
