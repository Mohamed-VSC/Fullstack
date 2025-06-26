<?php
session_start();
require_once "db_connection.php";

if (!isset($_SESSION['account_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'] ?? null; // Voeg dit toe

$storage = [];
$query = "SELECT * FROM `voorraad` 
INNER JOIN product ON voorraad.product_idproduct = product.idproduct
INNER JOIN locatie ON voorraad.locatie_idlocatie = locatie.idlocatie
INNER JOIN fabriek on product.fabriek_idfabriek = fabriek.idfabriek;";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $storage[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        h1 {
            text-align: center;
        }

        table {
            margin: 0 auto;
        }

        body {
            font-family: Arial, sans-serif;
        }

        a {
            text-decoration: none;
            color: black;
        }

        a:hover {
            color: blue;
        }

        a:visited {
            color: black;
        }

        a:active {
            color: black;
        }

        .logout-btn {
             padding: 10px 20px;
             background-color: #4CAF50; /* Groen */
             color: white;
             border: none;
             border-radius: 5px;
             cursor: pointer;
             font-weight: bold;
             transition: background-color 0.3s ease;
        }
        .logout-btn:hover {
            background-color:rgb(5, 19, 6); /* Donkerder groen bij hover */
        }

        .action-buttons a.btn {
    padding: 6px 12px;
    margin-right: 5px;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    text-decoration: none;
    transition: background-color 0.2s ease-in-out;
}

a.btn.update {
    background-color: #007bff; /* blauw */
}

a.btn.update:hover {
    background-color: #0056b3;
}

a.btn.delete {
    background-color: #dc3545; /* rood */
}

a.btn.delete:hover {
    background-color: #a71d2a;
}

a.btn.add {
    background-color: #28a745; /* groen */
}

a.btn.add:hover {
    background-color: #1e7e34;
}

    </style>
</head>

<body>
    <form action="logout.php" method="post" style="position: absolute; top: 20px; left: 20px;">
        <button type="submit" class="logout-btn">
            Logout
        </button>
    </form>

    <h1>Overzicht</h1>

    <table>
        <tr>
            <th>Product</th>
            <th>Type</th>
            <th>Fabriek</th>
            <th>Aantal</th>
            <th>Locatie</th>
            <?php if ($role === "admin") : ?>
                <th>Inkoopprijs</th>
                <th>Verkoopprijs</th>
                <th>Acties</th>
            <?php elseif ($role === "user") : ?>
                <th>prijs</th>
            <?php endif; ?>

        </tr>
        <?php foreach ($storage as $row) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['omschrijving'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['type'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['naamFabriek'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['aantal'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['plaats'] ?? ''); ?></td>
                <?php if ($role === "admin") : ?>
                    <td><?php echo htmlspecialchars($row['inkoopprijs'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['verkoopprijs'] ?? ''); ?></td>
                    <td class="action-buttons">
                        <a class="btn update" href="edit.php?id=<?php echo htmlspecialchars($row['id'] ?? ''); ?>">Update</a>
                        <a class="btn delete" href="delete.php?id=<?php echo htmlspecialchars($row['id'] ?? ''); ?>">Delete</a>
                        <a class="btn add" href="add.php?id=<?php echo htmlspecialchars($row['id'] ?? ''); ?>">Add</a>
                    </td>
                <?php elseif ($role === "user") : ?>
                    <td><?php echo htmlspecialchars($row['prijs'] ?? ''); ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>