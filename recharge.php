<?php
$db = mysqli_connect('localhost', 'root', 'gU2N@ndA$', 'billspark');
if (!$db) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

// Get data from POST request
$rechargeAmount = isset($_POST['Recharge']) ? $_POST['Recharge'] : '';
$cardNumber = isset($_POST['CardNumber']) ? $_POST['CardNumber'] : '';
$expiryDate = isset($_POST['ExpiryDate']) ? $_POST['ExpiryDate'] : '';
$cvv = isset($_POST['CVV']) ? $_POST['CVV'] : '';
$cardholderName = isset($_POST['CardholderName']) ? $_POST['CardholderName'] : '';
$uid = $_GET['uid'];

// Check if the UID already exists in current_balance table
$uidCheckQuery = "SELECT uid FROM current_balance WHERE uid = '$uid'";
$uidCheckResult = mysqli_query($db, $uidCheckQuery);

if (!$uidCheckResult) {
    echo json_encode(["status" => "error", "message" => "Failed to check UID existence"]);
    exit;
}

if (mysqli_num_rows($uidCheckResult) == 0) {
    // UID does not exist, insert it into current_balance table
    $insertUIDQuery = "INSERT INTO current_balance (uid) VALUES ('$uid')";
    $insertUIDResult = mysqli_query($db, $insertUIDQuery);

    if (!$insertUIDResult) {
        echo json_encode(["status" => "error", "message" => "Failed to insert UID into current_balance table"]);
        exit;
    }
}

// Update current balance
$updateQuery = "UPDATE current_balance SET balance = COALESCE(balance, 0) + $rechargeAmount WHERE uid = '$uid'";
$updateResult = mysqli_query($db, $updateQuery);

if ($updateResult) {
    // Insert payment details into payment table
    $insertPaymentQuery = "INSERT INTO payment (uid, card_number, expiry_date, cvv, cardholder_name) 
                          VALUES ('$uid', '$cardNumber', '$expiryDate', '$cvv', '$cardholderName')";
    $insertPaymentResult = mysqli_query($db, $insertPaymentQuery);

    if ($insertPaymentResult) {
        // Insert recharge history
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d H:i:s');
        $insertQuery = "INSERT INTO history (uid, recharge_amount, date_time) VALUES ('$uid', '$rechargeAmount', '$date')";
        $insertResult = mysqli_query($db, $insertQuery);

        if ($insertResult) {
            echo json_encode(["status" => "success", "rechargeAmount" => $rechargeAmount]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to insert recharge history"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to insert payment details"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update current balance"]);
}

mysqli_close($db);
?>
