<?php
// Connect to your database
$conn = mysqli_connect("localhost", "root", "gU2N@ndA$", "billspark");

// Get the UID from the GET request
$uid = $_GET['uid'];

// Query the database to retrieve the balance for the given UID
$query = "SELECT balance FROM current_balance WHERE uid='$uid'";
$result = mysqli_query($conn, $query);

// Check if a balance was found
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $balance = $row['balance'];
} else {
  // No balance found for the given UID, set balance to 0
  $balance = 0;
}

// Close the database connection
mysqli_close($conn);

// Send the balance back to the Flutter app
$response = array('success' => true, 'balance' => $balance);
echo json_encode($response);
?>
