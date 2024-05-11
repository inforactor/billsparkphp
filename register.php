<?php
$db = mysqli_connect('localhost', 'root', 'gU2N@ndA$', 'billspark');
if (!$db) {
    echo "Database connection failed";
}

$fname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
$lname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
$pnumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';
$pwd = isset($_POST['password']) ? $_POST['password'] : '';

// Validate input fields
$errors = array();
if (empty($fname)) {
    $errors[] = "First name is required";
}
if (empty($lname)) {
    $errors[] = "Last name is required";
}
if (empty($pnumber)) {
    $errors[] = "Phone number is required";
} elseif (!preg_match("/^[0-9]{10}$/", $pnumber)) {
    $errors[] = "Phone number should be 10 digits";
}
if (empty($pwd)) {
    $errors[] = "Password is required";
} elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $pwd)) {
    $errors[] = "Password should contain at least one uppercase letter, one lowercase letter, one number, one special character, and be at least 8 characters long";
}

if (!empty($errors)) {
    // If there are validation errors, return them as JSON response
    echo json_encode(["success" => false, "errors" => $errors]);
} else {
    // Check if the phone number already exists in the database
    $checkQuery = "SELECT * FROM Registration WHERE phonenumber = '$pnumber'";
    $checkResult = mysqli_query($db, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        // Phone number already exists, return error message
        echo json_encode(["success" => false, "message" => "Phone number already registered"]);
    } else {
        // Generate unique UID
        $uid = $fname . $lname . RandomString();

        // Insert new user data into the database
        $insert = "INSERT INTO Registration (firstname, lastname, phonenumber, uid, password) VALUES ('$fname', '$lname', '$pnumber', '$uid', '$pwd')";
        $query = mysqli_query($db, $insert);
        if ($query) {
            // Return the UID in the response
            echo json_encode(["success" => true, "uid" => $uid]);
        } else {
            // Return error message if insertion fails
            echo json_encode(["success" => false, "message" => "Registration failed"]);
        }
    }
}

// Function to generate a random string
function RandomString($length = 5) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>
