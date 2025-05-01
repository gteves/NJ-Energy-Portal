<?php
header("Content-Type: application/json");

$year = $_GET['year'] ?? '';
$bracket = $_GET['income'] ?? '';

$db = new PDO('sqlite:Energy.sqlite3');
$data = [];

// Direct query using exact column name
$query = "SELECT County, \"$bracket\" AS value FROM income_data WHERE year = :year";
$stmt = $db->prepare($query);
$stmt->bindValue(':year', $year);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[$row['County']] = $row['value'] ?? "NDA";
}

echo json_encode($data);
?>
