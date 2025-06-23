<?php
// Database configuration
$servername = "10.1.0.6"; // Use your server IP or hostname if not local
$username = "zerowasteuser"; // Your MySQL username
$password = "password"; // Your MySQL user's password
$dbname = "zerowastewagon_db"; // Your database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and sanitize input
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $password = htmlspecialchars(strip_tags($_POST['password']));
        $phoneNumber = htmlspecialchars(strip_tags($_POST['phoneNumber']));
        $country = htmlspecialchars(strip_tags($_POST['country']));
        $city = htmlspecialchars(strip_tags($_POST['city']));
        $registrationDate = date("Y-m-d H:i:s");

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL to insert new user
        $sql = "INSERT INTO USERS (Name, Email, Password, PhoneNumber, Country, City, RegistrationDate)
                VALUES (:name, :email, :hashedPassword, :phoneNumber, :country, :city, :registrationDate)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':hashedPassword' => $hashedPassword,
            ':phoneNumber' => $phoneNumber,
            ':country' => $country,
            ':city' => $city,
            ':registrationDate' => $registrationDate
        ]);

        echo "Registration successful.";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
