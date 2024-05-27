<?php
// Set up database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Validate form data (you can add more validation if needed)
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "Please fill in all fields.";
        exit;
    }

    // Prepare and execute the database insertion query
    $stmt = $conn->prepare("INSERT INTO sendms (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "Message sent and stored successfully!<br>";
    } else {
        echo "Sorry, something went wrong. Please try again later.";
    }

    $stmt->close();
}

// Retrieve messages from the database
$sql = "SELECT * FROM sendms";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Name: " . $row["name"] . "<br>";
        echo "Email: " . $row["email"] . "<br>";
        echo "Subject: " . $row["subject"] . "<br>";
        echo "Message: " . $row["message"] . "<br><br>";
    }
} else {
    echo "No messages found.";
}

$conn->close();
?>