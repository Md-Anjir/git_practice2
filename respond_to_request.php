<?php
// Check if request_id is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['requestId'])) {
    // Process the response here
    $requestId = $_POST['requestId'];
    
    // Database connection parameters
    $servername = "localhost";
    $username = "root"; // default username for XAMPP
    $password = ""; // default password for XAMPP (empty)
    $dbname = "practice"; // replace 'your_database_name' with your actual database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to update success status
    $sql_update_success = "UPDATE blood_requests SET success = 'yes' WHERE requestId = '$requestId'";
    if ($conn->query($sql_update_success) === TRUE) {
        echo "Response submitted for request ID: $requestId";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
