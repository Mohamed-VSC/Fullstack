<?php
session_start();
require_once "db_connection.php";

if (!isset($_SESSION['account_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'] ?? null; // Voeg dit toe

$storage = [];
$query = "select * FROM voorraad";
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
    </style>
</head>

<body>
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
            <?php endif; ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "admin") : ?>
                <th>Acties</th>
            <?php endif; ?>

        </tr>
        <?php foreach ($storage as $row) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['product'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['type'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['fabriek'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['aantal'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['locatie'] ?? ''); ?></td>
                <?php if ($role === "admin") : ?>
                    <td><?php echo htmlspecialchars($row['inkoopprijs'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['verkoopprijs'] ?? ''); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>">Update</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                        <a href=""></a>
                    </td>
                    <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</form>

    <form action="logout.php" method="post" style="position: absolute; top: 20px; left: 20px;">
        <button type="submit" class="logout-btn">
            Logout
        </button>
    </form>

</body>

</html>