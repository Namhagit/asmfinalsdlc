<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "studentmanagement"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $attendance_date = $_POST['attendance_date'];
    $status = $_POST['status'];

    // Check if student exists
    $checkStudent = "SELECT * FROM student WHERE student_id = '$student_id'";
    $result = $conn->query($checkStudent);

    if ($result->num_rows > 0) {
        // Student exists, proceed with the insert
        $sql = "INSERT INTO attendance (student_id, subject_id, attendance_date, status) 
                VALUES ('$student_id', '$subject_id', '$attendance_date', '$status')";

        if ($conn->query($sql) === TRUE) {
            echo "Attendance marked successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Student ID does not exist!";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Form</title>
    <style>
    /* General body styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* Center the form on the page */
h2 {
    text-align: center;
    color: #333;
}

form {
    background-color: white;
    width: 50%;
    margin: 50px auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Form label styling */
label {
    font-weight: bold;
    color: #333;
}

/* Input and select field styles */
input[type="number"], input[type="date"], select {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

/* Submit button styles */
button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
}

button:hover {
    background-color: #45a049;
}

/* Responsive design */
@media screen and (max-width: 600px) {
    form {
        width: 90%;
    }
}
</style>
</head>
<body>

<h2>Mark Attendance</h2>

<form action="attendance.php" method="POST">
    <label for="student_id">Student ID:</label>
    <input type="number" id="student_id" name="student_id" required><br><br>

    <label for="subject_id">Subject ID:</label>
    <input type="number" id="subject_id" name="subject_id" required><br><br>

    <label for="attendance_date">Attendance Date:</label>
    <input type="date" id="attendance_date" name="attendance_date" required><br><br>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="present">Present</option>
        <option value="absent">Absent</option>
        <option value="late">Late</option>
    </select><br><br>

    <button type="submit">Submit</button>
</form>

</body>
</html>
