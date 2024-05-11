
<?php //this program is not currently in use
require_once 'vendor/autoload.php';

use TelegramBot\Api\Client; // Import the correct namespace for the library

// Replace 'YOUR_BOT_TOKEN' with the token provided by BotFather
$botToken = '7035946899:AAHQWXKR5O_6000sJ3eCGafD5nhs_vPrF70'; // Update with your bot token
$telegram = new Client($botToken);

// Replace 'YOUR_CHAT_ID' with the chat ID of the user you want to send the OTP message to
$chatId = @9706673946; // Update with the recipient's chat ID

// Generate a random OTP (e.g., a 6-digit number)
$otp = rand(100000, 999999);

// Message content with OTP
$message = "Your OTP is: $otp";

// Send message with chat ID and message content
$response = $telegram->sendMessage($chatId, $message);

// Check if the message was sent successfully
if ($response) {
    echo 'OTP message sent successfully.';
} else {
    echo 'Failed to send OTP message.';
}

// Close the connection
$telegram->terminate();
?>
