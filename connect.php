<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "survey_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$contact_number = $_POST['number'];
$favorite_food = implode(', ', $_POST['food']);
$like_movies = $_POST['movies'];
$like_radio = $_POST['radio'];
$like_eat_out = $_POST['eatOut'];
$like_tv = $_POST['tv'];

// Insert data into the database
$sql = "INSERT INTO survey_results (name, email, dob, contact_number, favorite_food, like_movies, like_radio, like_eat_out, like_tv)
        VALUES ('$name', '$email', '$dob', '$contact_number', '$favorite_food', '$like_movies', '$like_radio', '$like_eat_out', '$like_tv')";

if ($conn->query($sql) === TRUE) {
    // Redirect to thank you page
    header("Location: thankyou.html");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
