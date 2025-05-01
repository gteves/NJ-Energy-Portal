<?php
header("Content-Type: application/json");

$year = $_GET['year'] ?? '';
$type = $_GET['type'] ?? '';  // e.g., Residential Electricity

// Open SQLite DB
$db = new PDO('sqlite:Energy.sqlite3');
$data = [];

// Clean column name
$type = str_replace("\xC2\xA0", " ", $type);
$type = trim($type);

// Prepare query
$query = "SELECT County, \"$type\" AS value FROM energy_consumption WHERE Year = :year";
$stmt = $db->prepare($query);
$stmt->bindValue(':year', $year);
$stmt->execute();

// Format response
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[$row['County']] = $row['value'] ?? "NDA";
}

echo json_encode($data);
?>
