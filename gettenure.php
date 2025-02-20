<?php
// Open the SQLite database
$db = new PDO('sqlite:Energy.sqlite3');

// Filter the data
$year = 'all';
$county = 'all';
$total = 'all';
$ownerOccupied = 'all';
$renterOccupied = 'all';
$limit = 'all';

if (isset($_GET['year'])) {
    $year = $_GET['year'];
}

if (isset($_GET['county'])) {
    $county= $_GET['county'];
}

if (isset($_GET['total'])) {
    $total = $_GET['total'];
}

if (isset($_GET['ownerOccupied'])) {
    $ownerOccupied = $_GET['ownerOccupied'];
}

if (isset($_GET['renterOccupied'])) {
    $renterOccupied = $_GET['renterOccupied'];
}

if (isset($_GET['limit'])) {
    $limit = $_GET['limit'];
}

//Build Query
$query = 'SELECT * FROM "tenure"';
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
