
<?php
// Replace these credentials with your actual database details
$host = 'localhost';
$username = 'root';
$password = 'root';
$db_name = 'magizham';

// Connect to the database
$conn = new mysqli($host, $username, $password, $db_name);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Sanitize user input (to prevent SQL injection)
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Hash the password (optional, but highly recommended for security)
    $hashed_password = hash('sha256', $password);

    // Query the database to check if the user exists
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // User authenticated successfully

        // Start a session or set a cookie to track login status
        session_start();
        $_SESSION['logged_in'] = true;

        // Redirect the user to the dashboard or another page
        header("Location: dashboard.html");
        exit();
    } else {
        // Invalid username or password
        // Redirect back to the login page with an error message
        header("Location: index.html?error=1");
        exit();
    }
}

// Close the database connection
$conn->close();
