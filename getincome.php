<?php
// Open the SQLite database
$db = new PDO('sqlite:Energy.sqlite3');

// Filter the data
$year = 'all';
$county = 'all';
$totalIncome = 'all';
$lowIncome = 'all';
$moderateIncome = 'all';
$highIncome = 'all';
$veryHighIncome = 'all';
$limit = 'all';

if (isset($_GET['year'])) {
    $year = $_GET['year'];
}

if (isset($_GET['county'])) {
    $county = $_GET['county'];
}

if (isset($_GET['totalIncome'])) {
    $totalIncome = $_GET['totalIncome'];
}

if (isset($_GET['lowIncome'])) {
    $lowIncome = $_GET['lowIncome'];
}

if (isset($_GET['moderateIncome'])) {
    $moderateIncome = $_GET['moderateIncome'];
}

if (isset($_GET['highIncome'])) {
    $highIncome = $_GET['highIncome'];
}

if (isset($_GET['veryHighIncome'])) {
    $veryHighIncome = $_GET['veryHighIncome'];
}

if (isset($_GET['limit'])) {
    $limit = $_GET['limit'];
}

// Build Query
$query = 'SELECT * FROM "income_groups_separated"';
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

if ($totalIncome !== 'all') {
    $conditions[] = 'LOWER("Total Income") = LOWER(:totalIncome)';
    $params[':totalIncome'] = $totalIncome;
}

if ($lowIncome !== 'all') {
    $conditions[] = 'LOWER("Low Income") = LOWER(:lowIncome)';
    $params[':lowIncome'] = $lowIncome;
}

if ($moderateIncome !== 'all') {
    $conditions[] = 'LOWER("Moderate Income") = LOWER(:moderateIncome)';
    $params[':moderateIncome'] = $moderateIncome;
}

if ($highIncome !== 'all') {
    $conditions[] = 'LOWER("High Income") = LOWER(:highIncome)';
    $params[':highIncome'] = $highIncome;
}

if ($veryHighIncome !== 'all') {
    $conditions[] = 'LOWER("Very High Income") = LOWER(:veryHighIncome)';
    $params[':veryHighIncome'] = $veryHighIncome;
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
