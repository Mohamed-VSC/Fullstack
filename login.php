<?php
session_start();


// if (isset($_SESSION['username'])) {
//     header("Location: overzicht.php");
//     exit();
// }

$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .main {
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

        .wrap {
            text-align: center;
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

        .register-link {
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <section class="main">
        <h1>Login</h1>

        <?php if ($error === "emptyfields"): ?>
            <p class="error">Fill in all fields!</p>
        <?php elseif ($error === "wronginput"): ?>
            <p class="error">Wrong input!</p>
        <?php elseif ($error === "nouser"): ?>
            <p class="error">User not found!</p>
        <?php endif; ?>

        <form action="login_process.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your Username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <div class="wrap">
                <button type="submit">Submit</button>
            </div>
        </form>

        <p class="register-link">No account? <a href="register.php">Register here</a></p>
    </section>
</body>

</html>