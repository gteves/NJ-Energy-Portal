<?php
// Open the SQLite database
$db = new PDO('sqlite:Energy.sqlite3');

// Filter the data
$year = 'all';
$county = 'all';
$total = 'all';
$bottled_LP_gas= 'all';
$coal_or_coke = 'all';
$electricity = 'all';
$fuel_oil_kerosene = 'all';
$no_fuel_used = 'all';
$other_fuel = 'all';
$solar_energy = 'all';
$utility_gas = 'all';
$wood = 'all';
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

if (isset($_GET['bottled_LP_gas'])) {
    $bottled_LP_gas = $_GET['bottled_LP_gas'];
}

if (isset($_GET['coal_or_coke'])) {
    $coal_or_coke = $_GET['coal_or_coke'];
}

if (isset($_GET['electricity'])) {
    $electricity = $_GET['electricity'];
}

if (isset($_GET['fuel_oil_kerosene'])) {
    $fuel_oil_kerosene = $_GET['fuel_oil_kerosene'];
}

if (isset($_GET['no_fuel_used'])) {
    $no_fuel_used = $_GET['no_fuel_used'];
}

if (isset($_GET['other_fuel'])) {
    $other_fuel = $_GET['other_fuel'];
}

if (isset($_GET['solar_energy'])) {
    $solar_energy = $_GET['solar_energy'];
}

if (isset($_GET['utility_gas'])) {
    $utility_gas = $_GET['utility_gas'];
}

if (isset($_GET['wood'])) {
    $wood = $_GET['wood'];
}

if (isset($_GET['limit'])) {
    $limit = $_GET['limit'];
}

//Build Query
$query = 'SELECT * FROM "heating_final_cleaned"';
$conditions = [];
$params = [];

if ($year !== 'all') {
    $conditions[] = 'LOWER("Year") = LOWER(:year)';
    $params[':year'] = (int)$year;
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
