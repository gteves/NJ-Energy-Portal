<?php
try {
    // Establish database connection
    $dsn = 'sqlite:Energy.sqlite3'; // Path to your SQLite database
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validate and fetch ZIP code from GET request
    if (!isset($_GET['zip_code']) || empty(trim($_GET['zip_code']))) {
        echo json_encode(['status' => 'error', 'message' => 'ZIP Code is required.']);
        exit;
    }

    $zipCode = trim($_GET['zip_code']);

    // Prepare and execute SQL query with the ZIP code
    $stmt = $pdo->prepare('SELECT "County Name", "Energy Burden Pct Income", ZIP_Code 
                           FROM "Energy Burden Zip Codes" 
                           WHERE ZIP_Code = :zipCode');
    $stmt->bindParam(':zipCode', $zipCode, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if data is found
    if ($result) {
        echo json_encode(['status' => 'success', 'data' => $result]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data found for the provided ZIP Code.']);
    }
} catch (Exception $e) {
    // Handle any exceptions
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
