<?php
require 'vendor/autoload.php'; // Make sure this path is correct

// Suppose these are your "from" numbers, perhaps loaded from a database or configuration file
$fromNumbers = ['+64274380671', '+1234567890', '+0987654321'];

// Your API Key and client initialization (Replace with your actual API Key)
$apiKey = 'Q3uxKqNvHQlzu0b6HCIyHiN30g53CJGBCX-UMtVthAn-NErJ2qwf8IS9ph7Est-C';
$client = new GuzzleHttp\Client();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from = $_POST['fromNumber'];
    $to = array_map('trim', explode(',', $_POST['toNumber'])); // Splitting string into array and trimming spaces
    $content = $_POST['content'];

    try {
        $response = $client->request('POST', 'https://api.httpsms.com/v1/messages/send', [
            'headers' => ['x-api-key' => $apiKey],
            'json' => [
                'content' => $content,
                'from' => $from,
                'to' => $to  // Now 'to' is an array of numbers
            ]
        ]);

        $result = $response->getBody();
        echo "<p>Message sent! Response: $result</p>";
    } catch (\GuzzleHttp\Exception\GuzzleException $e) {
        echo "<p>Error sending message: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send SMS</title>
</head>
<body>
    <h1>Send SMS</h1>
    <form method="POST" action="index.php">
        <!-- From Number (Selection List) -->
        <label for="fromNumber">From:</label>
        <select name="fromNumber" id="fromNumber">
            <?php foreach ($fromNumbers as $number): ?>
                <option value="<?php echo $number; ?>"><?php echo $number; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <!-- To Number (Text Field for multiple numbers) -->
        <label for="toNumber">To (separate numbers with commas):</label>
        <input type="text" id="toNumber" name="toNumber" pattern="[+\d,]+" title="Only numbers, +, and , are allowed." required><br><br>
        
        <!-- Content (Text Area) -->
        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required></textarea><br><br>
        
        <!-- Send Button -->
        <input type="submit" value="Send">
    </form>
</body>
</html>
