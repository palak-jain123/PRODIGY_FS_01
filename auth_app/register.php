<?php
require 'config.php';  // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate password criteria
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        echo "<div class='message error'>Password must be at least 8 characters, include 1 uppercase letter, 1 number, and 1 special character.</div>";
        exit;
    }

    // Generate a random salt for bcrypt (Blowfish)
    $salt = '$2y$10$' . bin2hex(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));  // 16-byte salt

    // Hash password with crypt() using Blowfish
    $hashed_password = crypt($password, $salt);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, password, salt) VALUES (?, ?, ?)");

    // Check if the statement is prepared successfully
    if ($stmt === false) {
        die('Error preparing the statement: ' . $conn->error);
    }

    // Bind the parameters, pass them by reference
    $stmt->bind_param("sss", $username, $hashed_password, $salt);

    // Execute the query
    if ($stmt->execute()) {
        echo "<div class='message success'>Registration successful. <a href='login.php'>Login here</a></div>";
    } else {
        echo "<div class='message error'>Error: " . $stmt->error . "</div>";
    }

    // Close the statement
    $stmt->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            height: 100vh;
            background: linear-gradient(-45deg, #ff6ec4, #7873f5, #4df5c8, #fcb045);
            background-size: 400% 400%;
            animation: disco 10s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes disco {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        form {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 0 30px rgba(0,0,0,0.2);
            width: 320px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #5f27cd;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #341f97;
        }

        .message {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 6px;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<form method="POST">
    <h2>Register</h2>
    <input type="text" name="username" required placeholder="Enter Username">
    <input type="password" name="password" required 
    placeholder="Enter Password" minlength="5" maxlength="8"
    pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
    title="Password must be at least 8 characters long and include 1 uppercase letter, 1 number, and 1 special character.">

    <button type="submit">Register</button>
</form>

</body>
</html>
