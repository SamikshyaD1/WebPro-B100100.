<?php
session_start();
$conn = new mysqli("localhost", "root", "", "sappeal_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    die(json_encode(["error" => "User not logged in."]));
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT name, address, contactno, email FROM users WHERE id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row); // Return profile data as JSON
} else {
    echo json_encode(["error" => "User not found"]);
}

$conn->close();
?>