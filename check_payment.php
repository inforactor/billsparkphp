<?php
$db = mysqli_connect('localhost', 'root', 'gU2N@ndA$', 'billspark');
if (!$db) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

$uid = $_GET['uid'];

// Check if the user has saved payment details
$query = "SELECT * FROM payment WHERE uid = '$uid'";
$result = mysqli_query($db, $query);

if ($result && mysqli_num_rows($result) > 0) {
    echo json_encode(["status" => "success", "hasPaymentDetails" => true]);
} else {
    echo json_encode(["status" => "success", "hasPaymentDetails" => false]);
}

mysqli_close($db);
?>
