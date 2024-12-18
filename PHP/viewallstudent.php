<?php
$servername = "localhost"; // Change if needed
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "studentmanagement"; // Database name

// Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT student_id, full_name, birth_date, gender, major, email, phone FROM student";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Student List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Gender</th>
            <th>Major</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Display each row of data
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['StudentID']}</td>
                        <td>{$row['FullName']}</td>
                        <td>{$row['DateOfBirth']}</td>
                        <td>{$row['Gender']}</td>
                        <td>{$row['Major']}</td>
                        <td>{$row['Email']}</td>
                        <td>{$row['Phone']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No students found</td></tr>";
        }
        $conn->close(); // Close the connection
        ?>
    </table>
</body>
</html>
