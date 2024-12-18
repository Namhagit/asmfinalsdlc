<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Login</title>  
    <style>  
        form {  
            display: flex;  
            flex-direction: column;  
            width: 300px;  
            margin: 100px auto;  
            padding: 20px;  
            border: 1px solid #ddd;  
            border-radius: 5px;  
            background-color: #f9f9f9;  
        }  

        /* Style the labels */  
        label {  
            font-size: 16px;  
            margin-bottom: 5px;  
        }  

        /* Style the input fields */  
        input[type="text"],  
        input[type="password"] {  
            padding: 10px;  
            margin-bottom: 15px;  
            border: 1px solid #ccc;  
            border-radius: 3px;  
            font-size: 16px;  
            width: calc(100% - 22px);  
            /* Adjust width to fit padding */  
        }  

        /* Style the login button */  
        input[type="submit"] {  
            padding: 10px;  
            background-color: #4CAF50;  
            color: white;  
            border: none;  
            border-radius: 3px;  
            font-size: 16px;  
            cursor: pointer;  
            transition: background-color 0.3s;  
        }  

        input[type="submit"]:hover {  
            background-color: #45a049;  
        }  

        .register-link {  
            text-align: center;  
            margin-top: 15px;  
            font-size: 14px;  
        }  

        .register-link a {  
            color: #4CAF50;  
            text-decoration: none;  
            transition: color 0.3s;  
        }  

        .register-link a:hover {  
            color: #45a049;  
        }  
    </style>  
</head>  
<body>  
    <form action="" method="POST">  
        <label for="username">Username:</label>  
        <input type="text" name="username" required> <br>  
        
        <label for="password">Password:</label>  
        <input type="password" name="password" required> <br>  
        
        <label for="role">Role:</label>  
        <select id="role" name="role" required>  
            <option value="admin">Admin</option>  
            <option value="student">Student</option>  
            <option value="teacher">Teacher</option> <!-- Added teacher role -->  
        </select> <br>  

        <input type="submit" name="login" value="Login">  
        <div class="register-link">  
            Don't have an account? <a href="register.php">Register</a>  
        </div>  
    </form>  

<?php  
session_start(); // Start the session  
$servername = "localhost";  
$username_db = "root";  
$password_db = "";  
$dbname = "studentmanagement";  
$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);  

// Check connection  
if (!$conn) {  
    die("Connection failed: " . mysqli_connect_error());  
}  

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    // Validate and sanitize user inputs  
    $username = mysqli_real_escape_string($conn, $_POST['username']);  
    $password = $_POST["password"];  
    
    // Prepare the SQL statement  
    $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");  
    $stmt->bind_param("s", $username);  
    $stmt->execute();  
    $stmt->store_result();  

    if ($stmt->num_rows > 0) {  
        $stmt->bind_result($hashed_password, $role);  
        $stmt->fetch();  
        
        // Verify the password  
        if (password_verify($password, $hashed_password)) {  
            $_SESSION['username'] = $username;  
            $_SESSION['role'] = $role; // Store the role in the session  

            echo "<script>alert('You have logged in successfully!')</script>";  
            
            // Redirect based on user role  
            if ($role == 'admin') {  
                header("Location: formchinh.php");  
                exit();  
            } elseif ($role == 'student') {  
                header("Location: formstuandtea.php"); // Redirect to the student page  
                exit();  
            } elseif ($role == 'teacher') {  
                header("Location: formstuandtea.php"); // Redirect to the teacher page (can change this to a different page if needed)  
                exit();  
            }  
        } else {  
            echo "<script>alert('Password or username is incorrect, please try again!')</script>";  
        }  
    } else {  
        echo "<script>alert('Password or username is incorrect, please try again!')</script>";  
    }  

    $stmt->close();  
}  

$conn->close();  
?>  
</body>  
</html>