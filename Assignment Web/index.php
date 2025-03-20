<?php
require 'env.php';

try {
    $pdo = new PDO($attr, $user, $PASS, $opts);
    $rows = 20;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $rows;


    $stmt = $pdo->prepare("SELECT * FROM users LIMIT :start, :rows");
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':rows', $rows, PDO::PARAM_INT);
    $stmt->execute();
    $users = $stmt->fetchAll();
    $stmt->execute();
    
    $users_assoc = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->execute();

    $users_num = $stmt->fetchAll(PDO::FETCH_NUM);
    $stmt->execute();

    $users_both = $stmt->fetchAll(PDO::FETCH_BOTH);
    $stmt->execute();

    $stmt = $pdo->query("SELECT Email FROM users LIMIT 1");
    $email = $stmt->fetchColumn();

    $total = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $pages = ceil($total / $rows);
    
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Users</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        <?php
            foreach ($users as $row) {
                echo "<tr>";
                echo "<td>".$row['ID']."</td>";
                echo "<td>".$row['Name']."</td>";
                echo "<td>".$row['Email']."</td>";
                echo "</tr>";
            }
        ?>
    </table>

    <h3>FETCH_ASSOC</h3>
    <pre><code><?php print_r($users_assoc); ?></code></pre>

    <h3>FETCH_NUM</h3>
    <pre><code><?php print_r($users_num); ?></code></pre>

    <h3>FETCH_BOTH</h3>
    <pre><code><?php print_r($users_both); ?></code></pre>

    <h3>FETCH_COLUMN (First Email)</h3>
    <p><?php echo $email; ?></p>


    <div>
        <p>Page <?php echo $page; ?> of <?php echo $pages; ?></p>
        <div>
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">Previous</a>
            <?php endif; ?>

            <?php if ($page < $pages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
