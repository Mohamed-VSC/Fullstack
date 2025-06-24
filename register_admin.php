<?php
session_start();
require_once "db_connection.php";

if (!isset($_SESSION['account_id']) || $_SESSION['role'] !== "admin") {
    header("Location: overzicht.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);
    $role = "user"; // Admin maakt altijd een "user" aan

    if (empty($username) || empty($password)) {
        header("Location: overzicht.php?error=emptyfields");
        exit();
    }

    $queryCheckUser = "SELECT username FROM account WHERE username = ?";
    if ($stmt = $conn->prepare($queryCheckUser)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            header("Location: overzicht.php?error=userexists");
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
            header("Location: overzicht.php?success=useradded");
        } else {
            header("Location: overzicht.php?error=dberror");
        }
        $stmt->close();
    }

    $conn->close();
}
