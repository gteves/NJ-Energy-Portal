<?php
// Open the SQLite database
$db = new PDO('sqlite:Energy.sqlite3');

// Initialize filters
$year = 'all';
$county = 'all';
$housingYear = 'all';
$limit = 'all';

if (isset($_GET['year'])) {
    $year = $_GET['year'];
}

if (isset($_GET['county'])) {
    $county = $_GET['county'];
}

if (isset($_GET['housingYear'])) {
    $housingYear = $_GET['housingYear'];
}

if (isset($_GET['limit'])) {
    $limit = $_GET['limit'];
}

// Build base query
$validColumns = [
    "Built 1939 or earlier",
    "Built 1940 to 1949",
    "Built 1950 to 1959",
    "Built 1960 to 1969",
    "Built 1970 to 1979",
    "Built 1980 to 1989",
    "Built 1990 to 1999",
    "Built 2000 to 2004",
    "Built 2000 to 2009",
    "Built 2005 or later",
    "Built 2010 or later",
    "Built 2010 to 2013",
    "Built 2010 to 2019",
    "Built 2014 or later",
    "Built 2020 or later"
];

$selectCols = '"Year", "County"';
if ($housingYear !== 'all' && in_array($housingYear, $validColumns)) {
    $selectCols .= ', "' . $housingYear . '"';
} else {
    // If no specific column selected, select all of them
    foreach ($validColumns as $col) {
        $selectCols .= ', "' . $col . '"';
    }
}

$query = "SELECT $selectCols FROM housing_year";
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

if (!empty($conditions)) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}

if ($limit !== 'all') {
    $query .= ' LIMIT :limit';
    $params[':limit'] = $limit;
}

// Execute
$statement = $db->prepare($query);
$statement->execute($params);
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);
?>
