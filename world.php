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
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

if ($lookup === 'cities') {
    // Lookup cities only if a country is provided
    if (!empty($country)) {
        $stmt = $conn->prepare("
            SELECT cities.name AS city_name, cities.district, cities.population
            FROM cities
            INNER JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE :country
            ORDER BY cities.population DESC
        ");
        $stmt->bindValue(':country', "%$country%");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $results = []; // Cannot lookup cities without a country
    }
} else {
    // Lookup countries
    if (!empty($country)) {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->bindValue(':country', "%$country%");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // No country input: return all countries
        $stmt = $conn->query("SELECT * FROM countries");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<?php if ($results): ?>
    <?php if ($lookup === 'cities'): ?>
        <table class="city-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>District</th>
                    <th>Population</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['city_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['district']); ?></td>
                        <td><?php echo htmlspecialchars($row['population']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
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
    <?php endif; ?>
<?php else: ?>
    <p class="no-results">No results found.</p>
<?php endif; ?>
