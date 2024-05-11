<?php //this program is not currently in use

// Receive OTP from request
$receivedOTP = $_POST['otp'];

// Generated OTP from previous code execution
$generatedOTP = $otp; // Assuming $otp is available from previous code execution

// Check if received OTP matches the generated OTP
if ($receivedOTP == $generatedOTP) {
    // OTP verification successful
    $response = array('success' => true, 'message' => 'OTP verification successful');
} else {
    // OTP verification failed
    $response = array('success' => false, 'message' => 'OTP verification failed');
}

// Return response as JSON
echo json_encode($response);
?>
