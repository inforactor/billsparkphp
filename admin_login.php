<?php

// Database connection parameters
$servername = "localhost"; // Change this to your MySQL server's address
$username = "root"; // Change this to your MySQL username
$password = "gU2N@ndA$"; // Change this to your MySQL password
$database = "billspark"; // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve admin_id and password from POST request
$admin_id = $_POST['admin_id'];
$password = $_POST['password'];

// SQL query to fetch admin details
$sql = "SELECT * FROM Admin WHERE admin_id = '$admin_id' AND password = '$password'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Admin found, return success response
    $response = array("success" => true, "message" => "Login successful");
    echo json_encode($response);
} else {
    // Admin not found or incorrect credentials, return failure response
    $response = array("success" => false, "message" => "Invalid admin ID or password");
    echo json_encode($response);
}

$conn->close();

?>
