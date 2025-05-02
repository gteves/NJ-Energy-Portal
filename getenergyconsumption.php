<?php
// Open the SQLite database
$db = new PDO('sqlite:Energy.sqlite3');

// Filter the data
$year = 'all';
$county = 'all';
$residential = 'all';
$commercial = 'all';
$industrial = 'all';
$streetLighting = 'all';
$total = 'all';
$limit = 'all';

if (isset($_GET['year'])) {
    $year = $_GET['year'];
}

if (isset($_GET['county'])) {
    $county = $_GET['county'];
}

if (isset($_GET['residential'])) {
    $residential = $_GET['residential'];
}

if (isset($_GET['commercial'])) {
    $commercial = $_GET['commercial'];
}

if (isset($_GET['industrial'])) {
    $industrial = $_GET['industrial'];
}

if (isset($_GET['streetLighting'])) {
    $streetLighting = $_GET['streetLighting'];
}

if (isset($_GET['total'])) {
    $total = $_GET['total'];
}

if (isset($_GET['limit'])) {
    $limit = $_GET['limit'];
}

// Build Query
$query = 'SELECT * FROM "energy_consumption"';
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

if ($residential !== 'all') {
    $conditions[] = 'LOWER("Residential Electricity") = LOWER(:residential)';
    $params[':residential'] = $residential;
}

if ($commercial !== 'all') {
    $conditions[] = 'LOWER("Commercial Electricity") = LOWER(:commercial)';
    $params[':commercial'] = $commercial;
}

if ($industrial !== 'all') {
    $conditions[] = 'LOWER("Industrial Electricity") = LOWER(:industrial)';
    $params[':industrial'] = $industrial;
}

if ($streetLighting !== 'all') {
    $conditions[] = 'LOWER("Street Lighting Electricity") = LOWER(:streetLighting)';
    $params[':streetLighting'] = $streetLighting;
}

if ($total !== 'all') {
    $conditions[] = 'LOWER("Total Electricity (kWh)") = LOWER(:total)';
    $params[':total'] = $total;
}

if (!empty($conditions)) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}

if ($limit !== 'all') {
    $query .= ' LIMIT :limit';
    $params[':limit'] = $limit;
}

// Prepare the statement
$statement = $db->prepare($query);
$statement->execute($params);
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);
?>
