<?php
$servername = "localhost";  // Database server
$username = "root";         // Database username
$password = "";             // Database password
$dbname = "studentmanagement";         // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch subjects and students for dropdown (if necessary)
$students_query = "SELECT * FROM student"; // Assuming 'students' table exists
$students_result = $conn->query($students_query);

$subjects_query = "SELECT * FROM subject"; // Assuming 'subjects' table exists
$subjects_result = $conn->query($subjects_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score Management</title>
    
    <style>/* General Body Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Form Container */
form {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 400px;
    margin-top: 20px;
}

/* Heading Style */
h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Label Styling */
label {
    font-size: 14px;
    font-weight: bold;
    color: #555;
    margin-bottom: 8px;
    display: block;
}

/* Input and Select Fields */
input[type="text"],
input[type="number"],
input[type="date"],
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

/* Focus Styles */
input[type="text"]:focus,
input[type="number"]:focus,
input[type="date"]:focus,
select:focus {
    border-color: #4c9aff;
    outline: none;
}

/* Submit Button Style */
input[type="submit"] {
    background-color: #4c9aff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #3a80d6;
}

/* Style for Error Messages or Success */
.alert {
    padding: 10px;
    background-color: #f2dede;
    color: #a94442;
    margin-top: 20px;
    border-radius: 5px;
    font-size: 14px;
}

.alert.success {
    background-color: #dff0d8;
    color: #3c763d;
}
</style>
</head>
<body>

<h2>Manage Student Scores</h2>
<form action="save_score.php" method="POST">
    <label for="student_id">Student:</label>
    <select name="student_id" id="student_id" required>
        <option value="">Select a student</option>
        <?php while ($student = $students_result->fetch_assoc()): ?>
            <option value="<?= $student['student_id']; ?>"><?= $student['student_name']; ?></option>
        <?php endwhile; ?>
    </select>
    <br>

    <label for="subject_id">Subject:</label>
    <select name="subject_id" id="subject_id" required>
        <option value="">Select a subject</option>
        <?php while ($subject = $subjects_result->fetch_assoc()): ?>
            <option value="<?= $subject['subject_id']; ?>"><?= $subject['subject_name']; ?></option>
        <?php endwhile; ?>
    </select>
    <br>

    <label for="score">Score:</label>
    <input type="number" name="score" id="score" step="0.01" min="0" max="10" required>
    <br>

    <label for="exam_date">Exam Date:</label>
    <input type="date" name="exam_date" id="exam_date" required>
    <br>

    <input type="submit" value="Save Score">
</form>

</body>
</html>
