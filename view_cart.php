<?php
session_start();

$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Winkelwagen</title>
    <style>
        table { width: 50%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
        .btn { padding: 5px 10px; cursor: pointer; margin: 5px; border-radius:5px; border:none; }
        .btn-remove { background-color:#dc3545; color:white; }
        .btn-clear { background-color:#007bff; color:white; }
        a.back { display:block; text-align:center; margin:20px; text-decoration:none; color:white; background:#28a745; padding:10px; border-radius:5px; }
        a.back:hover { background:#1e7e34; }
    </style>
</head>
<body>
    <h1>Winkelwagen</h1>

    <table>
        <tr>
            <th>Product</th>
            <th>Prijs</th>
            <th>Aantal</th>
            <th>Acties</th>
        </tr>
        <?php if (!empty($cart)) : ?>
            <?php foreach ($cart as $id => $item) : ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo htmlspecialchars($item['price']); ?></td>
                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                <td>
                    <form method="post" action="remove_cart.php" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                        <button type="submit" class="btn btn-remove">Verwijder product</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="4">Je winkelwagen is leeg.</td>
            </tr>
        <?php endif; ?>
    </table>

    <?php if (!empty($cart)) : ?>
        <form method="post" action="clear_cart.php" style="text-align:center; margin-top:10px;">
            <button type="submit" class="btn btn-clear">Leeg winkelwagen</button>
        </form>
    <?php endif; ?>

    <a href="overzicht.php" class="back">← Terug naar overzicht</a>
</body>
</html>
