<?php
session_start();
require_once "db_connection.php";

if ($_SESSION['role'] !== 'admin') {
    header("Location: overzicht.php");
    exit();
}

// Dropdowns vullen
$productResult = $conn->query("SELECT idproduct, omschrijving FROM product");
$locatieResult = $conn->query("SELECT idlocatie, plaats FROM locatie");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $aantal = $_POST['aantal'];
    $inkoopprijs = $_POST['inkoopprijs'];
    $verkoopprijs = $_POST['verkoopprijs'];
    $product_id = $_POST['product_id'];
    $locatie_id = $_POST['locatie_id'];

    $stmt = $conn->prepare("
        INSERT INTO voorraad (type, aantal, inkoopprijs, verkoopprijs, product_idproduct, locatie_idlocatie) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("siddii", $type, $aantal, $inkoopprijs, $verkoopprijs, $product_id, $locatie_id);
    $stmt->execute();

    header("Location: overzicht.php");
    exit();
} 
?>

<h2>Voorraad toevoegen</h2>
<form method="POST">
    <label>Type:<br>
        <input type="text" name="type" required>
    </label><br>

    <label>Aantal:<br>
        <input type="number" name="aantal" required>
    </label><br>

    <label>Inkoopprijs:<br>
        <input type="number" step="0.01" name="inkoopprijs" required>
    </label><br>

    <label>Verkoopprijs:<br>
        <input type="number" step="0.01" name="verkoopprijs" required>
    </label><br>

    <label>Product:<br>
        <select name="product_id" required>
            <?php while ($row = $productResult->fetch_assoc()) : ?>
                <option value="<?= $row['idproduct'] ?>"><?= htmlspecialchars($row['omschrijving']) ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <label>Locatie:<br>
        <select name="locatie_id" required>
            <?php while ($row = $locatieResult->fetch_assoc()) : ?>
                <option value="<?= $row['idlocatie'] ?>"><?= htmlspecialchars($row['plaats']) ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <button type="submit">Toevoegen</button>
</form>
