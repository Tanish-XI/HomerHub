<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "homerhub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user input
function sanitizeInput($input) {
    // Use appropriate sanitization techniques based on your needs
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $name = sanitizeInput($_POST["name"]);
    $phone_number = sanitizeInput($_POST["phone_number"]);
    $email = sanitizeInput($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password
    $address = sanitizeInput($_POST["address"]);

    // Insert data into the database
    $sql = "INSERT INTO user_info (name, phone_number, email, password, address) VALUES ('$name', '$phone_number', '$email', '$password', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="style/index.css">
</head>
<body>

    

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Name: <input type="text" name="name" required><br>
    Phone Number: <input type="text" name="phone_number" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    Address: <input type="text" name="address" required><br>
    <input type="submit" value="Register">
</form>

</body>
</html>
