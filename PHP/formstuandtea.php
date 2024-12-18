<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher and Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #007BFF;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }
        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
        }
        .navbar a:hover {
            background-color: #0056b3;
        }
        .content {
            margin: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="content">
        <h1>Welcome, Student And Teacher!</h1>
        <p>Select an item from the menu bar to view details.</p>
    </div>
    <div class="navbar">
        <a href="viewallstudent.php">Student List</a>
        <a href="viewallteacher.php">Teacher List</a>
        <a href="viewallcourse.php">Course List</a>
        <a href="score.php">Score</a>
        <a href="attendance.php">Attendance</a>
    </div>
</body>
</html>
