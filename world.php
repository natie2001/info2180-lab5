<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$country = isset($_GET['country']) ? $_GET['country'] : '';

if (!empty($country)) {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->bindValue(':country', "%$country%");
    $stmt->execute();
} else {
    $stmt = $conn->query("SELECT * FROM countries");
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>World Database Lookup</title>
    <link rel="stylesheet" href="world.css">
</head>
<body>
    <header>
        <h1>World Database Lookup</h1>
    </header>

    <main>
        <div id="controls">
            <form method="get" action="world.php">
                <input type="text" name="country" id="country" placeholder="Enter country name" value="<?php echo htmlspecialchars($country); ?>">
                <button type="submit" id="lookup">Lookup</button>
            </form>
        </div>

        <div id="result">
            <?php if ($results): ?>
                <table class="country-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Continent</th>
                            <th>Independence</th>
                            <th>Head of State</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['continent']); ?></td>
                                <td><?php echo htmlspecialchars($row['independence_year']); ?></td>
                                <td><?php echo htmlspecialchars($row['head_of_state']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-results">No countries found.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
