<?php
// Database connection
$host = "localhost"; // Update with your database host if needed
$username = "root"; // Update if using a different username
$password = ""; // Update if your database has a password
$database = "Lab_5b";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$matric = $_POST['matric'];
$name = $_POST['name'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
$role = $_POST['role'];

// Insert data into the table
$sql = "INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $matric, $name, $password, $role);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
