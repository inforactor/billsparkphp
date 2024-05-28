<?php
$db = mysqli_connect('localhost', 'root', 'gU2N@ndA$', 'billspark');
if (!$db) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

$uid = $_GET['uid'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch card details
    $query = "SELECT * FROM payment WHERE uid = '$uid'";
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $cardDetails = mysqli_fetch_assoc($result);
        echo json_encode(["status" => "success", "cardDetails" => $cardDetails]);
    } else {
        echo json_encode(["status" => "error", "message" => "No card details found"]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save or update card details
    $cardNumber = $_POST['CardNumber'];
    $expiryDate = $_POST['ExpiryDate'];
    $cvv = $_POST['CVV'];
    $cardholderName = $_POST['CardholderName'];

    $query = "SELECT * FROM payment WHERE uid = '$uid'";
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Update existing card details
        $updateQuery = "UPDATE payment SET card_number = '$cardNumber', expiry_date = '$expiryDate', cvv = '$cvv', cardholder_name = '$cardholderName' WHERE uid = '$uid'";
        $updateResult = mysqli_query($db, $updateQuery);

        if ($updateResult) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update card details"]);
        }
    } else {
        // Insert new card details
        $insertQuery = "INSERT INTO payment (uid, card_number, expiry_date, cvv, cardholder_name) VALUES ('$uid', '$cardNumber', '$expiryDate', '$cvv', '$cardholderName')";
        $insertResult = mysqli_query($db, $insertQuery);

        if ($insertResult) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to save card details"]);
        }
    }
}

mysqli_close($db);
?>
