 
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "homerhub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Placeholder for user authentication logic
function authenticateUser($email, $password, $conn) {
    // Add your authentication logic here
    // For example, compare user credentials with database records
    $email = sanitizeInput($email);
    $password = sanitizeInput($password);
    
    // Retrieve hashed password from the database based on the provided email
    $sql = "SELECT password FROM user_info WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPasswordFromDB = $row['password'];

        // Verify the password
        if (password_verify($password, $hashedPasswordFromDB)) {
            return true; // Password is correct
        } else {
            return false; // Password is incorrect
        }
    } else {
        return false; // User with the provided email not found
    }
}

// Check if the form is submitted for login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Placeholder for user authentication
    if (authenticateUser($email, $password, $conn)) {
        // Redirect to the dashboard or another authenticated page
        header("Location:home.html");
        exit();
    } else {
        $loginError = "Invalid email or password.";
    }
}

// Function to sanitize user input
function sanitizeInput($input) {
    // Use appropriate sanitization techniques based on your needs
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style/index.css">
    <!-- Include other necessary stylesheets and scripts -->
</head>

<body>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
    <a href="register.php">Register</a>

    <?php
    // Display login error (if any)
    if (isset($loginError)) {
        echo '<div class="error">' . $loginError . '</div>';
    }
    ?>

</body>

</html>