<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central Operation System Portal</title>
    <style>
        /* General styling for the page */
        body {
            font-family: 'Courier New', Courier, monospace; /* Terminal-like font */
            background: url('./imgs/watchdog3.png') no-repeat center center fixed;
            background-size: cover;
            color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            filter: brightness(60%);
        }

        /* Container for the main content */
        .container {
            width: 100%;
            max-width: 1000px; /* Increase the max width */
            height: 80%; /* Set a fixed height for the container */
            background-color: rgba(29, 29, 29, 0.8); /* Semi-transparent background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            overflow-y: auto; /* Enables scrolling */
        }

        /* Header */
        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 28px;
            color: #fff;
        }

        /* Form styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            color: #ccc;
        }

        input[type="text"], input[type="password"] {
            
            width: 100%;
            max-width: 500px; /* Increase the max width */padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #333;
            color: #fff;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        /* Logs Section Styling */
        .logs {
            background-color: #111;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.7); /* Adding subtle glow */
        }

        /* Terminal-style text for logs */
        .logs pre.terminal {
            font-family: 'Courier New', Courier, monospace;
            font-size: 16px;
            color: #00ff00;  /* Classic green terminal text */
            background-color: #111; /* Dark background for logs */
            padding: 15px;
            border-radius: 5px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        /* Dashboard and other sections */
        .dashboard {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
            text-align: center;
        }

        .dashboard h1 {
            font-size: 36px;
            color: #00ff00;
        }

        /* Logout button */
        .logout {
            background-color: #e74c3c;
            padding: 10px 20px;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            width: 100%;
            margin-top: 20px;
        }

        .logout:hover {
            background-color: #c0392b;
        }

        /* Red warning message */
        .warning {
            color: red;
            font-size: 20px;
            text-align: center;
            background-color: black;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

<div class="container">
    <!-- Check if the cookie exists -->
    <?php
    $expected_cookie_value = 'eyJ1c2VybmFtZSI6ImhhY2tlciIsImlzQWdlbnQiOjF9';  // The cookie value to check for

    if (!isset($_COOKIE['session']) || $_COOKIE['session'] !== $expected_cookie_value) {
        // If cookie is not set or invalid, show a red message and a button to redirect to index.php
        echo "<div class='warning'>
                Hacker, please finish the first part of the challenge first before proceeding.
                <br><br>
                <button class='logout' onclick='window.location.href=\"index.php\"'>Go to the First Part</button>
              </div>";
        exit(); // Stop further execution
    }
    ?>

    <!-- Form to input username -->
    <form method="POST" id="login-form">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Enter your username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
        </div>
        <div>
            <input type="submit" value="Login">
        </div>
    </form>

    <?php
    ini_set('display_errors', 1);  // Show errors for debugging
    error_reporting(E_ALL);        // Report all errors

    function detect_sql_injection($input) {
        // Banned SQL injection keywords (case-sensitive matching)
        $filter = array('union', 'UNION', 'select', 'SELECT', 'or', 'load_file', 'LOAD_FILE', 'from', 'where', 'WHERE', 'drop', 'update', 'insert', 'delete', 'DELETE', 'exec', 'benchmark', 'sleep', 'and');
        
        // Check each banned keyword
        foreach ($filter as $banned) {
            if (strpos($input, $banned) !== false) {
                return true;  // SQL injection detected
            }
        }
        
        // Check for dangerous characters
        if (preg_match("/[\';=]/", $input)) {
            return true;  // Dangerous characters detected
        }
        
        return false;  // No SQL injection detected
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];

        if (detect_sql_injection($username) || detect_sql_injection($password)) {
            // If an SQL injection attempt is detected, show the message and stop further execution
            echo "<div style='color: red; font-size: 20px; text-align: center; background-color: black; padding: 20px; border-radius: 10px;'>SQL Injection Attempt Detected! You are not allowed to proceed.</div>";
            echo "<div style='color: red; font-size: 20px; text-align: center; background-color: black; padding: 20px; border-radius: 10px;'>Our system blocks words and chars that are prohibited, Can you bypass that ;) ?</div>";
            die();  // Stop the script to prevent further processing
        }

        // Connection to the database
        $conn = new mysqli("172.28.0.3", "jerbi", "zer0_day_p@Sswo0rd", "zero_day");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Vulnerable SQL query for login authentication
        $sql_login = "SELECT * FROM login_table WHERE username = \"$username\" AND password = \"$password\"";
        echo "Running Login Query: $sql_login<br>";  // Display the query for debugging purposes
        
        // Execute the login query
        $result_login = $conn->query($sql_login);
        
        // Check if the login query was successful
        if ($result_login === false) {
            die("Login Query failed: " . $conn->error); // Show MySQL error if the query failed
        }

        if ($result_login->num_rows > 0) {
            // Successful login, fetch logs based on the username

            // Vulnerable SQL query to reflect logs
            $sql_logs = "SELECT * FROM logs WHERE username = \"$username\"";  // Vulnerable query
            
            echo "Running Logs Query: $sql_logs<br>";  // Display the query for debugging purposes
            // Execute the logs query
            $result_logs = $conn->query($sql_logs);
            
            // Check if the query was successful
            if ($result_logs === false) {
                die("Logs Query failed: " . $conn->error); // Show MySQL error if the query failed
            }

            if ($result_logs->num_rows > 0) {
                // Display logs in a hacker terminal theme
                echo "<div class='logs'>
                        <h3>Recent User Logs</h3>
                        <pre class='terminal'>";

                // Fetch and display the log_message for the user
                while ($row = $result_logs->fetch_assoc()) {
                    echo "[INFO] " . $row['log_message'] . "\n";
                }

                echo "</pre></div>";
            } else {
                // No logs found for the user
                echo "<p>No logs found for user $username.</p>";
            }

            // Display the dashboard after successful login
            echo "<div class='dashboard'>
                    <h1>Agent Dashboard</h1>
                    <p>Welcome back, $username</p>
                  </div>";

            // Logs and Mission Details (simulated here as part of the login process)
            echo "<div class='logs'>
                    <h3>System Logs</h3>
                    <pre class='terminal'>
                    [INFO] User \"$username\" successfully logged in.
                    [INFO] Surveillance Feed Accessed.
                    [SECURITY] Unauthorized access attempt from IP 192.168.1.50.
                    [INFO] Access to mission logs successful.
                    [WARNING] Potential vulnerability detected in the server logs.
                    </pre>
                  </div>";

            echo "<div class='logs'>
                    <h3>Mission Report</h3>
                    <pre class='terminal'>
                    MISSION STATUS: ACTIVE
                    Objective: Retrieve NexusCorp archive data.
                    Last Action: We obtained the needed cookie to access the endpoint [ stored in db ]
                    The orders are clear: NexusCorp_archive_cookie should be protected at all costs.
                    </pre>
                  </div>";

            echo "<button class='logout' onclick='window.location.href=\"ctOS.php\"'>Logout</button>";

        } else {
            // Authentication failed
            echo "<p>Login failed! Please try again.</p>";
        }

        $conn->close();
    }
    ?>
</div>

</body>
</html>