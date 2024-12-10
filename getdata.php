<?php
// Open the SQLite database
$db = new PDO('sqlite:Energy.sqlite3');

// Filter the data
$county = 'all';
$municipality = 'all';
$residentialElectricity = 'all';
$residentialNaturalGas = 'all';
$limit = 'all';

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

//Build Query
$query = 'SELECT * FROM "2022_Municipal_Level_Utility_Data"';
$conditions = [];
$params = [];

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

// // Fetch all rows as an associative array
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);
?>
