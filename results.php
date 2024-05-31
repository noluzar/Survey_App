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

// Total number of surveys completed
$totalSurveysResult = $conn->query("SELECT COUNT(*) AS total_surveys FROM survey_results");
$totalSurveys = $totalSurveysResult->fetch_assoc()['total_surveys'];

// Average age of the people that participated in the survey
$averageAgeResult = $conn->query("SELECT AVG(YEAR(CURDATE()) - YEAR(dob)) AS average_age FROM survey_results");
$averageAge = round($averageAgeResult->fetch_assoc()['average_age'], 1);

// Oldest person that participated in the survey
$oldestPersonResult = $conn->query("SELECT name, dob FROM survey_results ORDER BY dob ASC LIMIT 1");
$oldestPerson = $oldestPersonResult->fetch_assoc();
$oldestPersonName = $oldestPerson['name'];
$oldestPersonDob = $oldestPerson['dob'];

// Youngest person that participated in the survey
$youngestPersonResult = $conn->query("SELECT name, dob FROM survey_results ORDER BY dob DESC LIMIT 1");
$youngestPerson = $youngestPersonResult->fetch_assoc();
$youngestPersonName = $youngestPerson['name'];
$youngestPersonDob = $youngestPerson['dob'];

// Percentage of people who like Pizza
$pizzaLoversResult = $conn->query("SELECT COUNT(*) AS pizza_lovers FROM survey_results WHERE FIND_IN_SET('Pizza', favorite_food)");
$pizzaLovers = $pizzaLoversResult->fetch_assoc()['pizza_lovers'];
$pizzaPercentage = round(($pizzaLovers / $totalSurveys) * 100, 1);

// People like to eat out (average rating)
$eatOutRatingResult = $conn->query("SELECT AVG(like_eat_out) AS average_eat_out_rating FROM survey_results");
$eatOutRating = round($eatOutRatingResult->fetch_assoc()['average_eat_out_rating'], 1);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"
    <title>Survey Results</title>
</head>
<body>
<nav> 
    <label class="logo">_Surveys</label>
        <ul>
            <li><a class="active" href="index.html">FILL OUT FORM</a></li>
            <li><a class="active" href="#">VIEW SURVEY RESULTS</a></li>
        </ul>
       </nav>

    <h1>Survey Results</h1>
    <p>Total number of surveys completed: <?php echo $totalSurveys; ?></p><br>
    <p>Average age of participants: <?php echo $averageAge; ?></p><br>
    <p>Oldest person: <?php echo $oldestPersonName . " (" . $oldestPersonDob . ")"; ?></p><br>
    <p>Youngest person: <?php echo $youngestPersonName . " (" . $youngestPersonDob . ")"; ?></p><br>
    <p>Percentage of people who like Pizza: <?php echo $pizzaPercentage; ?>%</p><br>
    <p>Average rating for liking to eat out: <?php echo $eatOutRating; ?></p><br>
</body>
</html>
