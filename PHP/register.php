<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Register</title>  
    <style>  
        body {  
            font-family: Arial, sans-serif;  
            background-color: #f4f4f9;  
            margin: 0;  
            padding: 0;  
            display: flex;  
            justify-content: center;  
            align-items: center;  
            height: 100vh;  
        }  

        form {  
            background-color: #ffffff;  
            padding: 20px 30px;  
            border-radius: 8px;  
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  
            width: 300px;  
        }  

        h1 {  
            text-align: center;  
            color: #333333;  
        }  

        label {  
            display: block;  
            margin-bottom: 5px;  
            color: #555555;  
            font-weight: bold;  
        }  

        input, select {  
            width: 100%;  
            padding: 8px;  
            margin-bottom: 15px;  
            border: 1px solid #cccccc;  
            border-radius: 4px;  
        }  

        button {  
            width: 100%;  
            padding: 10px;  
            background-color: #4CAF50;  
            color: white;  
            border: none;  
            border-radius: 4px;  
            cursor: pointer;  
        }  

        button:hover {  
            background-color: #45a049;  
        }  

        p {  
            text-align: center;  
            margin-top: 10px;  
        }  

        p a {  
            color: #007BFF;  
            text-decoration: none;  
        }  

        p a:hover {  
            text-decoration: underline;  
        }  
    </style>  
</head>  
<body>  
    <form action="" method="POST">  
        <label for="id">ID:</label>  
        <input type="text" id="id" name="user_id" required> <!-- Changed name from id to user_id -->  

        <label for="username">Username:</label>  
        <input type="text" id="username" name="username" required>  

        <label for="password">Password:</label>  
        <input type="password" id="password" name="password" required>  

        <label for="role">Role:</label>  
        <select id="role" name="role" required>  
            <option value="admin">Admin</option> <!-- Corrected the option values -->  
            <option value="teacher">Teacher</option>  
            <option value="student">Student</option>  
        </select>  

        <button type="submit" name="submit">Register</button>  
        <p>You already have an account? <a href="login.php">Login here</a></p>  
    </form>  

    <?php  
    $servername = "localhost";  
    $username_db = "root";  
    $password_db = "";  
    $dbname = "studentmanagement";  

    // Kết nối cơ sở dữ liệu  
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);  

    // Kiểm tra kết nối  
    if ($conn->connect_error) {  
        die("Connection failed: " . $conn->connect_error);  
    }  

    if ($_SERVER["REQUEST_METHOD"] == "POST") {  
        $id = $_POST["user_id"]; // Corrected input name  
        $username = $_POST["username"];  
        $password = $_POST["password"];  
        $role = $_POST["role"];  

        // Kiểm tra các trường nhập liệu  
        if (empty($id) || empty($username) || empty($password) || empty($role)) {  
            echo "Vui lòng điền đầy đủ thông tin!<br>";  
        } else {  
            // Mã hóa mật khẩu  
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);  

            // Sử dụng Prepared Statement  
            $stmt = $conn->prepare("INSERT INTO users (user_id, username, password, role) VALUES (?, ?, ?, ?)");  
            $stmt->bind_param("isss", $id, $username, $hashed_password, $role); // Changed from "issss" to "isss"  

            // Thực thi truy vấn  
            if ($stmt->execute()) {  
                echo "Đăng ký thành công!<br>";  
                echo "<script>window.open('login.php', '_self')</script>";  
            } else {  
                echo "Đăng ký thất bại: " . htmlspecialchars($stmt->error) . "<br>"; // Escaped error message  
            }  

            $stmt->close();  
        }  
    }  

    $conn->close();  
    ?>  
</body>  
</html>