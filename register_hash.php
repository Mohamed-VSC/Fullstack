<?php
$password = $_POST['password'];
$username = $_POST['username'];
require_once "db_connection.php"; // Zorg ervoor dat je database connectie correct is

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    // // $password = trim($_POST['password']);
    $role = "user"; // Standaard rol is nu "user"

    if (empty($username) || empty($password)) {
        header("Location: register.php?error=emptyfields");
        exit();
    }

    $queryCheckUser = "SELECT username FROM account WHERE username = ?";
    if ($stmt = $conn->prepare($queryCheckUser)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            header("Location: register.php?error=userexists");
            $stmt->close();
            exit();
        }
        $stmt->close();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $queryInsertAccount = "INSERT INTO account (username, password, role) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($queryInsertAccount)) {
        $stmt->bind_param("sss", $username, $hashedPassword, $role);
        if ($stmt->execute()) {
            header("Location: login.php?success=registered");
        } else {
            header("Location: register.php?error=dberror");
        }
        $stmt->close();
    }

    $conn->close();
}
