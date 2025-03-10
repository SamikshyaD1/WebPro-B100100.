<?php
session_start();
$conn = new mysqli("localhost", "root", "", "sappeal_db");

if ($conn->connect_error) {
    die("Database connection failed");
}

// Get email and password from POST request
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validate input
if (empty($email) || empty($password)) {
    $_SESSION['error'] = "Email and password are required";
    header("Location: form.html"); // Redirect back to login form
    exit;
}

// Use prepared statements to prevent SQL injection
$sql = "SELECT id, name, address, contactno, email, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    if (password_verify($password, $row['password'])) { // Secure password verification
        // Set session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['address'] = $row['address'];
        $_SESSION['contactno'] = $row['contactno'];
        $_SESSION['email'] = $row['email'];

        header("Location: index.html"); // Redirect to homepage
        exit;
    } else {
        $_SESSION['error'] = "Invalid password!";
        header("Location: form.html"); // Redirect back to login page
        exit;
    }
} else {
    $_SESSION['error'] = "User not found!";
    header("Location: form.html"); // Redirect back to login page
    exit;
}


// Close resources
$stmt->close();
$conn->close();
?>
