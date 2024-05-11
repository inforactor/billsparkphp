<?php
// Connect to your database
$conn = mysqli_connect("localhost", "root", "gU2N@ndA$", "billspark");

// Function to decrement balance by 1 for each user
function decrementBalance() {
    global $conn;
    
    // Decrement balance by 1 for each user if it's greater than 0
    $updateQuery = "UPDATE current_balance SET balance = GREATEST(balance - 1, 0) WHERE balance > 0";
    mysqli_query($conn, $updateQuery);
}

// Execute the decrementBalance function every 10 seconds
while (true) {
    decrementBalance();
    sleep(10); // Sleep for 10 seconds
}
?>
