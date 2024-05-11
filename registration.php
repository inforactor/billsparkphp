
<?php //not in use


// Function to sanitize input data for SQL Injection protection
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required parameters are set
    if (isset($_POST['firstname'], $_POST['lastname'], $_POST['phonenumber'])) {
        // Sanitize input data
        $firstname = sanitize($_POST['firstname']);
        $lastname = sanitize($_POST['lastname']);
        $phonenumber = sanitize($_POST['phonenumber']);

        // Perform validation
        if (!empty($firstname) && !empty($lastname) && !empty($phonenumber)) {
            // Connect to MySQL database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "billspark";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and bind SQL statement
            $stmt = $conn->prepare("INSERT INTO Registration (firstname, lastname, phonenumber) VALUES ($firstname, $lastname, $phonenumber)");
            $stmt->bind_param("sss", $firstname, $lastname, $phonenumber);

            // Execute SQL statement
            if ($stmt->execute()) {
                // Registration successful
                $response = ['success' => true, 'message' => 'Registration successful'];
            } else {
                // Registration failed
                $response = ['success' => false, 'message' => 'Registration failed'];
            }

            // Close database connection
            $stmt->close();
            $conn->close();
        } else {
            // Invalid input data
            $response = ['success' => false, 'message' => 'Please fill in all fields'];
        }
    } else {
        // Required parameters not set
        $response = ['success' => false, 'message' => 'Please fill in all fields'];
    }
} else {
    // Invalid request method
    $response = ['success' => false, 'message' => 'Method Not Allowed'];
}

// Set response headers
header('Content-Type: application/json');

// Output the JSON response
echo json_encode($response);
?>