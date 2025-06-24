<?php
session_start();
ob_start();

require_once "db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        header("Location: login.php?error=emptyfields");
        exit();
    }

    $stmt = $conn->prepare("SELECT idaccount, username, password, role FROM account WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header("Location: login.php?error=nouser");
        exit();
    }

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['account_id'] = $user['idaccount'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: overzicht.php");
        exit();
    } else {
        header("Location: login.php?error=wronginput");
        exit();
    }

    $stmt->close();
    $conn->close();
}

ob_end_flush();
