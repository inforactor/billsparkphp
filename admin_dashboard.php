<?php
// Database connection
$db = mysqli_connect('localhost', 'root', 'gU2N@ndA$', 'billspark');
if (!$db) {
    echo "Database connection failed";
}

// Retrieve user data from Registration table
$query = "SELECT firstname, lastname, phonenumber, uid FROM Registration";
$result = mysqli_query($db, $query);

// Check if query was successful
if ($result) {
    $userData = array();
    // Fetch results and store in array
    while ($row = mysqli_fetch_assoc($result)) {
        $userData[] = $row;
    }
    // Encode array as JSON and output
    echo json_encode($userData);
} else {
    // If query failed, return error message
    echo json_encode(array("error" => "Failed to fetch user data"));
}

// Close database connection
mysqli_close($db);
?>
