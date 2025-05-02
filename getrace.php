<?php
// Open the SQLite database
$db = new PDO('sqlite:Energy.sqlite3');

// Filter the data
$year = 'all';
$county = 'all';
$total = 'all';
$hispanicOrLatino = 'all';
$notHispanicOrLatino = 'all';
$limit = 'all';

if (isset($_GET['year'])) {
    $year = $_GET['year'];
}

if (isset($_GET['county'])) {
    $county = $_GET['county'];
}

if (isset($_GET['total'])) {
    $total = $_GET['total'];
}

if (isset($_GET['hispanicOrLatino'])) {
    $hispanicOrLatino = $_GET['hispanicOrLatino'];
}

if (isset($_GET['notHispanicOrLatino'])) {
    $notHispanicOrLatino = $_GET['notHispanicOrLatino'];
}

if (isset($_GET['limit'])) {
    $limit = $_GET['limit'];
}

// Build Query
$query = 'SELECT * FROM "race"';
$conditions = [];
$params = [];

if ($year !== 'all') {
    $conditions[] = 'LOWER("Year") = LOWER(:year)';
    $params[':year'] = $year;
}

if ($county !== 'all') {
    $conditions[] = 'LOWER("County") = LOWER(:county)';
    $params[':county'] = $county;
}

if ($total !== 'all') {
    $conditions[] = 'LOWER("Total") = LOWER(:total)';
    $params[':total'] = $total;
}

if ($hispanicOrLatino !== 'all') {
    $conditions[] = 'LOWER("Hispanic or Latino") = LOWER(:hispanicOrLatino)';
    $params[':hispanicOrLatino'] = $hispanicOrLatino;
}

if ($notHispanicOrLatino !== 'all') {
    $conditions[] = 'LOWER("Not Hispanic or Latino") = LOWER(:notHispanicOrLatino)';
    $params[':notHispanicOrLatino'] = $notHispanicOrLatino;
}

// Make the final query
if (!empty($conditions)) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}

if ($limit !== 'all') {
    $query .= ' LIMIT :limit';
    $params[':limit'] = $limit;
}

// Prepare the statement
$statement = $db->prepare($query);

// Execute the statement
$statement->execute($params);

// Fetch all rows as an associative array
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);
?>
