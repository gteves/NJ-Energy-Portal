<?php

error_log("PHP error logging is working.");

// Open the SQLite database
$db = new PDO('sqlite:Energy.sqlite3');

// Filter the data
$county = 'all';
$municipality = 'all';
$year = 'all';
$residentialElectricity = 'all';
$residentialNaturalGas = 'all';
$limit = 'all';

error_log("Searching for municipality: " . $municipality);
error_log("SQL Query Params: " . json_encode($params));

if (isset($_GET['county'])) {
    $county = $_GET['county'];
}

if (isset($_GET['Municipality'])) {
    $municipality = $_GET['Municipality'];
}

if (isset($_GET['year'])) {
    $year = $_GET['year'];
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
$query = 'SELECT * FROM "Municipal_Level_Utility_Data"';
$conditions = [];
$params = [];

if ($county !== 'all') {
    $conditions[] = 'UPPER("County") = UPPER(:county)';
    $params[':county'] = $county;
}

if ($municipality !== 'all') {
    $conditions[] = 'UPPER("Municipality") = UPPER(:municipality)';
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
