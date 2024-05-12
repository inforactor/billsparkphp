<?php
// Database connection
$db = mysqli_connect('localhost', 'root', 'gU2N@ndA$', 'billspark');
if (!$db) {
    echo "Database connection failed";
}

// Retrieve user information based on UID
$uid = $_GET['uid'];

// Retrieve address information
$addressQuery = "SELECT * FROM Address WHERE uid = '$uid'";
$addressResult = mysqli_query($db, $addressQuery);

// Check if user exists
if (mysqli_num_rows($addressResult) > 0) {
    // Fetch all address information
    $addresses = array();
    while ($row = mysqli_fetch_assoc($addressResult)) {
        $addresses[] = $row;
    }
} else {
    // If no addresses found, set addresses to an empty array
    $addresses = array();
}

// Retrieve CID information
$cidQuery = "SELECT * FROM ciduid WHERE uid = '$uid'";
$cidResult = mysqli_query($db, $cidQuery);

// Retrieve payment information
$paymentQuery = "SELECT * FROM payment WHERE uid = '$uid'";
$paymentResult = mysqli_query($db, $paymentQuery);

// Retrieve registration information
$registrationQuery = "SELECT * FROM Registration WHERE uid = '$uid'";
$registrationResult = mysqli_query($db, $registrationQuery);

// Check if user exists
if (mysqli_num_rows($registrationResult) > 0) {
    // Fetch user information
    $userInfo = mysqli_fetch_assoc($registrationResult);

    // Fetch CID information
    $cidInfo = mysqli_fetch_assoc($cidResult);

    // Fetch payment information
    $paymentInfo = mysqli_fetch_assoc($paymentResult);

    // Combine all information into a single array
    $userData = array(
        "userInfo" => $userInfo,
        "addresses" => $addresses,
        "cidInfo" => $cidInfo,
        "paymentInfo" => $paymentInfo
    );

    // Convert data to JSON format and output
    echo json_encode($userData);
} else {
    // User not found
    echo json_encode(["error" => "User not found"]);
}

// Close database connection
mysqli_close($db);
?>
