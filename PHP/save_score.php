<?php
$servername = "localhost";  // Database server
$username = "root";         // Database username
$password = "";             // Database password
$dbname = "studentmanagement";         // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
  // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $score = $_POST['score'];
    $exam_date = $_POST['exam_date'];

    // Insert score into the database
    $sql = "INSERT INTO scores (student_id, subject_id, score, exam_date) 
            VALUES ('$student_id', '$subject_id', '$score', '$exam_date')";

    if ($conn->query($sql) === TRUE) {
        echo "New score record created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
