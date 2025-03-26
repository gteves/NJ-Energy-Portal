<?php
// Open the SQLite database
$db = new PDO('sqlite:Energy.sqlite3');

// Filters
$year = 'all';
$county = 'all';
$municipality = 'all';
$residentialElectricity = 'all';
$residentialNaturalGas = 'all';
$limit = 'all';

if (isset($_GET['year'])) { 
    $year = $_GET['year'];
}

if (isset($_GET['county'])) {
    $county = $_GET['county'];
}

if (isset($_GET['municipality'])) {
    $municipality = $_GET['municipality'];
}

if (isset($_GET['residentialElectricity'])) {
    $residentialElectricity = $_GET['residentialElectricity'];
}

if (isset($_GET['residentialNaturalGas'])) {
    $residentialNaturalGas = $_GET['residentialNaturalGas'];
}

if (isset($_GET['limit'])) {
    $limit = $_GET['limit'];
}

// Build query
$query = 'SELECT "Municipality", "County", "Year", "Residential Electricity", "Natural Gas Utility", "Residential Natural Gas" FROM "Municipal Level Utility Data - Municipal Level Utility Data"';
$conditions = [];
$params = [];

if ($year !== 'all') { 
    $conditions[] = '"Year" = :year';
    $params[':year'] = $year;
}

if ($county !== 'all') {
    $conditions[] = 'LOWER("County") = LOWER(:county)';
    $params[':county'] = $county;
}

if ($municipality !== 'all') {
    $conditions[] = 'LOWER("Municipality") = LOWER(:municipality)';
    $params[':municipality'] = $municipality;
}

if ($residentialElectricity !== 'all') {
    $conditions[] = '"Residential Electricity" = :residentialElectricity';
    $params[':residentialElectricity'] = $residentialElectricity;
}

if ($residentialNaturalGas !== 'all') {
    $conditions[] = '"Residential Natural Gas" = :residentialNaturalGas';
    $params[':residentialNaturalGas'] = $residentialNaturalGas;
}

if (!empty($conditions)) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}

if ($limit !== 'all') {
    $query .= ' LIMIT :limit';
    $params[':limit'] = $limit;
}

// Prepare and execute
$statement = $db->prepare($query);

// If limit is used, bind as integer
if ($limit !== 'all') {
    $statement->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    unset($params[':limit']);
}

// Bind all other parameters
foreach ($params as $key => $value) {
    $statement->bindValue($key, $value);
}

$statement->execute();

// Return JSON
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rows);
?>
