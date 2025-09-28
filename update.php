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

// Ophalen voorraadregel
$stmt = $conn->prepare("SELECT * FROM voorraad WHERE idvoorraad = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$voorraad = $result->fetch_assoc();

if (!$voorraad) {
    header("Location: overzicht.php");
    exit();
}

// Ophalen producten en locaties voor dropdown
$productResult = $conn->query("SELECT idproduct, omschrijving FROM product");
$locatieResult = $conn->query("SELECT idlocatie, plaats FROM locatie");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $aantal = $_POST['aantal'];
    $inkoopprijs = $_POST['inkoopprijs'];
    $verkoopprijs = $_POST['verkoopprijs'];
    $product_id = $_POST['product_id'];
    $locatie_id = $_POST['locatie_id'];

    $stmt = $conn->prepare("UPDATE voorraad SET type = ?, aantal = ?, inkoopprijs = ?, verkoopprijs = ?, product_idproduct = ?, locatie_idlocatie = ? WHERE idvoorraad = ?");
    $stmt->bind_param("sssdiii", $type, $aantal, $inkoopprijs, $verkoopprijs, $product_id, $locatie_id, $id);
    $stmt->execute();

    header("Location: overzicht.php");
    exit();
}
?>

<h2>Voorraad aanpassen</h2>
<form method="POST">
    <label>Type:<br>
        <input type="text" name="type" value="<?php echo htmlspecialchars($voorraad['type']); ?>" required>
    </label><br>

    <label>Aantal:<br>
        <input type="text" name="aantal" value="<?php echo htmlspecialchars($voorraad['aantal']); ?>" required>
    </label><br>

    <label>Inkoopprijs:<br>
        <input type="text" name="inkoopprijs" value="<?php echo htmlspecialchars($voorraad['inkoopprijs']); ?>" required>
    </label><br>

    <label>Verkoopprijs:<br>
        <input type="text" name="verkoopprijs" value="<?php echo htmlspecialchars($voorraad['verkoopprijs']); ?>" required>
    </label><br>

    <label>Product:<br>
        <select name="product_id" required>
            <?php while ($row = $productResult->fetch_assoc()) : ?>
                <option value="<?= $row['idproduct'] ?>" <?= ($row['idproduct'] == $voorraad['product_idproduct']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['omschrijving']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <label>Locatie:<br>
        <select name="locatie_id" required>
            <?php while ($row = $locatieResult->fetch_assoc()) : ?>
                <option value="<?= $row['idlocatie'] ?>" <?= ($row['idlocatie'] == $voorraad['locatie_idlocatie']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['plaats']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <button type="submit">Opslaan</button>
</form>
