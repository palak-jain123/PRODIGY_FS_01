<?php
//require 'config.php';
//require 'middleware.php';
?>

<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            background: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        h2 {
            color: #333;
        }

        a.logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a.logout:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>You are now logged in to your dashboard.</p>

    <ul>
        <li>👤 View Profile</li>
        <li>⚙️ Update Settings</li>
        <li>📁 Access Private Content</li>
        <!-- Add your features here -->
    </ul>

    <a class="logout" href="logout.php">Logout</a>
</div>

</body>
</html>
