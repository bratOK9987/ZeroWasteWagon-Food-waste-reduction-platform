<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    $host = "localhost";
    $username = "zero_waste_user"; // Your MariaDB username
    $password = "zzzxxx"; // Your MariaDB password
    $database = "zero_waste_wagon"; // Your database name

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the submitted email
    $email = $conn->real_escape_string($_POST["email"]);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
    $stmt->bind_param("s", $email);

    // Execute and close
    if ($stmt->execute()) {
        echo "Thank you for subscribing!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
