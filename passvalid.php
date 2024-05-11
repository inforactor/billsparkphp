<?php
// Connect to your database
$conn = mysqli_connect("localhost", "root", "gU2N@ndA$", "billspark");

// Get the phone number and password from the POST request
$uid = $_POST['uid'];
$password = $_POST['password'];

// Query the database to check for a matching user
$query = "SELECT * FROM Registration WHERE uid='$uid' AND password='$password'";
$result = mysqli_query($conn, $query);

// Initialize response array
$response = array();

// Check if a user was found
if (mysqli_num_rows($result) > 0) {
    // User found, send a successful response
    $response['success'] = true;
    $response['message'] = 'Login successful';
} else {
    // User not found, send an error response
    $response['success'] = false;
    $response['message'] = 'Invalid credentials';
}

// Close the database connection
mysqli_close($conn);

// Output the JSON response
echo json_encode($response);
?>
