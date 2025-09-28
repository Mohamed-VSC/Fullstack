<?php
session_start();

// Verwijder alles uit de winkelwagen
unset($_SESSION['cart']);

header("Location: view_cart.php");
exit();
