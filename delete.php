<?php
session_start();
require_once "db_connection.php";

if ($_SESSION['role'] !== 'admin') {
    header("Location: overzicht.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: overzicht.php");
    exit();
}

$stmt = $conn->prepare("DELETE FROM voorraad WHERE idvoorraad = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: overzicht.php");
exit();
?>
