<?php
header("Content-Type: application/json");

$year = $_GET['year'] ?? '';
$group = $_GET['income'] ?? '';

$db = new PDO('sqlite:Energy.sqlite3');
$data = [];

// Use column name from dropdown (e.g. "Low Income")
$query = "SELECT County, \"$group\" AS value FROM income_groups_separated WHERE Year = :year";
$stmt = $db->prepare($query);
$stmt->bindValue(':year', $year);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[$row['County']] = $row['value'] ?? "NDA";
}

echo json_encode($data);
?>
