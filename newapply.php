<?php
// Database connection
$db = mysqli_connect('localhost', 'root', 'gU2N@ndA$', 'billspark');
if (!$db) {
    echo json_encode(array("status" => "error", "message" => "Database connection failed"));
    exit;
}

// Get data from POST request
$state = isset($_POST['state']) ? $_POST['state'] : '';
$district = isset($_POST['district']) ? $_POST['district'] : '';
$city = isset($_POST['city']) ? $_POST['city'] : '';
$pin = isset($_POST['pin']) ? $_POST['pin'] : '';
$uid = $_GET['uid'];

// Generate a 15-digit random string as consumer ID
$cid = generateCID(6);

// Address table database
$addressInsertQuery = "INSERT INTO Address (state, district, city, pin, cid, uid) VALUES ('$state', '$district', '$city', '$pin', '$cid', '$uid')";
$addressInsertResult = mysqli_query($db, $addressInsertQuery);
if (!$addressInsertResult) {
    echo json_encode(["status" => "error", "message" => "Failed to insert address information"]);
    exit;
}

// Insert UID into current_balance table with an empty balance value
// Insert UID into current_balance table without specifying balance field
$insertUIDQuery = "INSERT INTO ciduid (uid) VALUES ('$uid')";
$insertUIDResult = mysqli_query($db, $insertUIDQuery);
if (!$insertUIDResult) {
    echo json_encode(["status" => "error", "message" => "Failed to insert UID into current_balance table"]);
    exit;
}

// Get the current balance and CID values
$currentBalanceQuery = "SELECT * FROM ciduid WHERE uid = '$uid'";
$currentBalanceResult = mysqli_query($db, $currentBalanceQuery);
if (mysqli_num_rows($currentBalanceResult) > 0) {
    $row = mysqli_fetch_assoc($currentBalanceResult);
    $cid1 = $row['cid1'];
    $cid2 = $row['cid2'];
    $cid3 = $row['cid3'];

    // Determine which CID fields are empty and insert the new CID accordingly
    if (empty($cid1)) {
        $updateCIDQuery = "UPDATE ciduid SET cid1 = '$cid' WHERE uid = '$uid'";
    } elseif (empty($cid2)) {
        $updateCIDQuery = "UPDATE ciduid SET cid2 = '$cid' WHERE uid = '$uid'";
    } elseif (empty($cid3)) {
        $updateCIDQuery = "UPDATE ciduid SET cid3 = '$cid' WHERE uid = '$uid'";
    } else {
        // Maximum connection limit reached
        echo json_encode(["status" => "error", "message" => "You have reached the maximum connection limit"]);
        exit;
    }

    // Execute the update query
    $updateCIDResult = mysqli_query($db, $updateCIDQuery);
    if (!$updateCIDResult) {
        echo json_encode(["status" => "error", "message" => "Failed to update CID"]);
        exit;
    }

    // Success message with the generated CID
    echo json_encode(["status" => "success", "message" => "Success, your CID: $cid"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to retrieve ciduid table"]);
}

// Close database connection
mysqli_close($db);

// Function to generate a random string
function generateCID($length = 6) {
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>
