<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "sappeal_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Get form data
$name = $_POST['name'];
$address = $_POST['address'];
$contactno = $_POST['contactno'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

// Insert data into the database
$sql = "INSERT INTO users (name, address, contactno, email, password) VALUES ('$name', '$address', '$contactno', '$email', '$password')";

if ($conn->query($sql)) {
    echo "Registration successful!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>