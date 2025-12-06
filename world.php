<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? $_GET['country'] : '';


if (!empty($country)) {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->bindValue(':country', "%$country%");
    $stmt->execute();
} 

else {
    $stmt = $conn->query("SELECT * FROM countries");
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo '<ul class="country-list">';
foreach ($results as $row) {
    echo '<li class="country-item">' 
         . $row['name'] . ' is ruled by ' . $row['head_of_state'] .
         '</li>';
}
echo '</ul>';
?>
