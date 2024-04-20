<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Request Form - Submission Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: large;
        }
        h2 {
            color: red;
            text-align: center;
        }
        
        h3 {
            color: green;
            text-align: center;
        }
        label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Submission Result</h2>
        <?php
        // Start session
        session_start();

        // Check if user is logged in
        if(!isset($_SESSION['phone'])) {
        header("Location: login_form.html");
        exit;
        }
        // Database connection parameters
        $servername = "localhost";
        $username = "root"; // default username for XAMPP
        $password = ""; // default password for XAMPP (empty)
        $dbname = "practice";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve user information
        $phone = $_SESSION['phone'];
        $sql = "SELECT * FROM users WHERE phone='$phone'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // User found, display user information
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $user_ID = $row['user_ID'];
            // You can retrieve other user information here
        } else {
            // User not found
            echo "User not found";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $bloodGroup = $_POST['bloodGroup'];
            $hospital = $_POST['hospital'];
            $amount = $_POST['amount'];
            $location = $_POST['location'];
            $date = $_POST['date'];
            $time = $_POST['time'];

            // SQL query to insert data into the table
            $sql = "INSERT INTO blood_requests (bloodGroup,user_ID,phone,hospital, amount, location, date, time)
                    VALUES ('$bloodGroup','$user_ID','$phone','$hospital', '$amount', '$location', '$date', '$time')";

            if ($conn->query($sql) === TRUE) {
                $last_id = $conn->insert_id;
                echo "<p><strong>Name:</strong> $name</p>";
                echo "<p><strong>Phone Number:</strong> $phone</p>";
                echo "<p><strong>Hospital:</strong> $hospital</p>";
                echo "<p><strong>Blood Group:</strong> $bloodGroup</p>";
                echo "<p><strong>Amount of Blood Needed:</strong> $amount units</p>";
                echo "<p><strong>Location:</strong> $location</p>";
                echo "<p><strong>Date:</strong> $date</p>";
                echo "<p><strong>Time:</strong> $time</p>";
                echo "<h3>Data inserted successfully. Request ID: $last_id</h3>";

                echo '<div style="text-align: center; margin-top: 20px;">';
                echo '<form action="home.php" method="post">';
                echo '<button type="submit" style="color: white; font-size: large; background-color: red; padding: 8px 16px; cursor: pointer; border: none; border-radius: 5px;">Home Page</button>';
                echo '</form>';
                echo '</div>';
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<p>No data submitted.</p>";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>
</html>