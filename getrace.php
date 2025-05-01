<?php
header("Content-Type: application/json");

$year = $_GET['year'] ?? '';
$group = $_GET['group'] ?? '';

// Open SQLite DB
$db = new PDO('sqlite:Energy.sqlite3');
$data = [];

// Clean the race/ethnicity group label
$group = str_replace("\xC2\xA0", " ", $group);
$group = trim($group);

// Prepare query
$query = "SELECT County, \"$group\" AS value FROM race WHERE Year = :year";
$stmt = $db->prepare($query);
$stmt->bindValue(':year', $year);
$stmt->execute();

// Format response
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[$row['County']] = $row['value'] ?? "NDA";
}

echo json_encode($data);
?>
