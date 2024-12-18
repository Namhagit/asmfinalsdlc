<?php
$host = 'localhost';  // MySQL server address
$user = 'root';       // MySQL username
$password = '';       // MySQL password
$database = 'studentmanagement'; // Database name

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM subject";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course List</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Course List</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Subject Name</th>
            <th>Department</th>
            <th>Credits</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['subject_id'] . "</td>";
                echo "<td>" . $row['subject_name'] . "</td>";
                echo "<td>" . $row['department'] . "</td>";
                echo "<td>" . $row['credits'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No courses available</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
