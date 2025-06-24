<?php
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 320px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .error {
            color: red;
            background: #ffe6e6;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            text-align: left;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            background: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background: #45a049;
        }

        .login-link {
            margin-top: 15px;
            font-size: 14px;
        }

        .login-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Register</h1>

        <?php if ($error === "userexists"): ?>
            <p class="error">Username already taken!</p>
        <?php elseif ($error === "dberror"): ?>
            <p class="error">Something went wrong. Try again.</p>
        <?php endif; ?>

        <form method="POST" action="register_hash.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Role:</label>
            <input type="text" id="role" name="role" value="admin" required>

            <button type="submit">Register</button>
        </form>

        <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>

</html>