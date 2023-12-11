<?php
// Establish MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biometricattendace";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredUsername = $_POST['username'];
    $enteredPassword = $_POST['password'];

    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM usercred WHERE username=? AND password=?");
    $stmt->bind_param("ss", $enteredUsername, $enteredPassword);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Successful login
        // Redirect to ManageUsers.php upon successful login
        header("Location: ManageUsers.php");
        exit();
    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>
