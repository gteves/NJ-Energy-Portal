<?php
header("Content-Type: application/json");

// Get inputs
$year = $_GET['year'] ?? '';
$builtBracket = $_GET['built'] ?? '';

// Open SQLite DB
$db = new PDO('sqlite:Energy.sqlite3');
$data = [];

// Clean bracket name
$builtBracket = str_replace("\xC2\xA0", " ", $builtBracket);
$builtBracket = trim($builtBracket);

// Prepare query
$query = "SELECT County, \"$builtBracket\" AS value FROM housing_year WHERE Year = :year";
$stmt = $db->prepare($query);
$stmt->bindValue(':year', $year);
$stmt->execute();

// Format response
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[$row['County']] = $row['value'] ?? "NDA";
}

echo json_encode($data);
?>
