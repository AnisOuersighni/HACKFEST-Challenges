<?php
ini_set('display_errors', 0);  // Don't display errors to the user

// Check if the NexusCorp_archive_cookie is set and valid
if (isset($_COOKIE['NexusCorp_archive_cookie'])) {
    $cookie_value = $_COOKIE['NexusCorp_archive_cookie'];
    $valid_cookie = '5e884898da28047151d0e56f8dc6292773603d0d9f89e1a91fce2281e9b04fc0';

    if ($cookie_value === $valid_cookie) {
        // If the cookie is valid, allow access and show the page with form
        echo "<div class='container'>
                <h1>NexusCorp archive data</h1>
                <p>Welcome to the secure archive! You have access to this restricted area.</p>";


        // Sanitize the user input for the 'page' parameter
        $page = isset($_GET['page']) ? $_GET['page'] : '';

        // Block any use of PHP wrappers like php://
        if (preg_match('/^php:\/\//', $page)) {
            die("<p class='warning' style='color: #ff0000;'>Access Denied: PHP wrapper detected in page parameter. (not the way)</p>");
        }

        // Check if the 'page' parameter starts with ^../ (directory traversal attempt)
        if (preg_match('/^\.{2}\/\//', $page)) {
            // If ^../ is found, show a message and block the access
            echo "<p class='warning' style='color: #ff0000;'>Directory traversal attempt blocked: Invalid file path. You can't start searching with ../ </p>";
            die();  // Prevent further processing if directory traversal is attempted
        }

        // Ensure that the 'page' parameter points to the 'approved' directory
       // if (strpos($page, "./approved/") !== 0 && strpos($page, "approved/") !== 0) {
        //    die("<p class='warning' style='color: #ff0000;'>Access Denied: Invalid path. only files under approved directory can be read</p>");
        //}

        // Sanitize the path by removing occurrences of "../" or other forbidden components
        if (strpos($page, "../") !== false) {
            // Sanitize out the traversal attempt by replacing "../" with an empty string
            $page = str_replace('../', '', $page);
            echo "<p class='warning' style='color: #ff0000;'>Directory traversal detected and sanitized. Attempt to access restricted file paths has been blocked.</p>";
        }

        // Make sure the page parameter does not include any absolute paths like '/etc/'
        if (preg_match('/(\/etc\/|\/dev\/|\/proc\/|\/var\/log\/)/', $page)) {
            die("<p class='warning' style='color: #ff0000;'>Access Denied: Attempt to access restricted system files.</p>");
        }

        // Make sure the page parameter does not include any relative path components
        //$safe_page = basename($page);  // Remove any directory traversal like '../../'

        // Validate if the file exists and is within the allowed folder
        $file_path = "/var/www/html/approved/{$page}";
        if (file_exists($file_path) && is_readable($file_path)) {
            echo "<div class='form-container'>
                    <h3>Access the Asset</h3>
                    <form method='GET'>
                        <label for='page'>Enter the file name:</label><br>
                        <input type='text' name='page' id='page' required><br><br>
                        <input type='submit' value='Fetch Page'>
                    </form>
                    <h3>Content from {basename($page)}</h3>
                    <pre>";
            echo file_get_contents($file_path);
            echo "</pre>
                  </div>";
        } else {
            echo "<p class='warning' style='color: #ff0000;'>Access Denied: The requested file does not exist or is not readable.</p>";
        }

        echo "</div>";
    } else {
        // If the cookie is invalid
        echo "<h2>Access Denied</h2>";
        echo "<p class='warning' style='color: #ff0000;'>We are watching, and you aren't allowed to access such an asset!</p>";
    }
} else {
    // If the cookie is not set
    echo "<h2>Access Denied</h2>";
    echo "<p class='warning' style='color: #ff0000;'>We are watching, and you aren't allowed to access such an asset!</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCorp archive data</title>
    <style>
        /* Reset margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling with background image */
        body {
            font-family: 'Arial', sans-serif;
            background: url('./imgs/mission2.png') no-repeat center center fixed; /* Replace with actual path */
            background-size: cover;
            color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            filter: brightness(60%); /* Dim the background to make form readable */
        }

        /* Container for the form */
        .container {
            width: 100%;
            max-width: 800px;
            background-color: rgba(29, 29, 29, 0.8); /* Semi-transparent background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
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
            padding: 10px;
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

        /* Logs section */
        .logs {
            background-color: #111;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }

        pre {
            font-size: 14px;
            color: #00ff00;  /* Green terminal text */
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        /* Cookie hint section */
        .cookie-hint {
            background-color: #222;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            color: #ffcc00;
            margin-top: 15px;
        }

        .cookie-hint p {
            font-weight: bold;
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

        /* Custom styling for the form container */
        .form-container {
            background-color: rgba(29, 29, 29, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }

        /* Warning styles */
        .warning {
            color: #ff0000;
            font-weight: bold;
        }
    </style>
</head>
<body>


<div class="container">
    <!-- Content will be displayed dynamically by PHP -->
</div>

</body>
</html>
