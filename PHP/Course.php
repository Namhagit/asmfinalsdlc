<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentmanagement";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý thêm, sửa, xóa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subjectid = $_POST['ID'];
    $subjectname = $_POST['Name'];
    $department = $_POST['Department'];
    $credit = $_POST['Credit'];

    if ($action == "add") {
        $sql = "INSERT INTO Courses (ID, Name, Department, Credit) 
                VALUES ('$subjectid', '$subjectname', $department, '$credit')";
    } elseif ($action == "edit") {
        $sql = "UPDATE Courses 
                SET Name='$subjectname', Department=$department, Credit='$credit'' 
                WHERE ID='$subjectid'";
    } elseif ($action == "delete") {
        $sql = "DELETE FROM Courses WHERE ID='$subjectid'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Thao tác thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Tìm kiếm
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$sql = "SELECT * FROM subject WHERE subject_name LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
</head>
<style>
    /* Reset mặc định */
body, h1, h2, p, table, input, textarea, select, button {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    box-sizing: border-box;
}

/* Toàn bộ trang */
body {
    background-color: #f8f9fa;
    color: #333;
    line-height: 1.6;
    margin: 20px;
    padding: 0;
}

h1, h2 {
    text-align: center;
    color: #0056b3;
}

form {
    margin: 20px auto;
    max-width: 600px;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Các trường nhập liệu */
label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input[type="text"],
input[type="number"],
textarea,
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

textarea {
    resize: none;
    height: 100px;
}

/* Nút bấm */
button {
    display: inline-block;
    padding: 10px 15px;
    margin-right: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

button:hover {
    background-color: #0056b3;
}

/* Bảng danh sách */
table {
    width: 100%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f4f4f4;
    font-weight: bold;
    color: #333;
}

tr:hover {
    background-color: #f1f1f1;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Form tìm kiếm */
form[method="GET"] {
    text-align: center;
    margin-bottom: 20px;
}

form[method="GET"] input[type="text"] {
    width: 300px;
    display: inline-block;
}

form[method="GET"] button {
    display: inline-block;
}

</style>
<body>
    <h1>Subject Manaagement</h1>
    <a href="formchinh.php">Return</a>

    <!-- Form Thêm/Sửa/Xóa -->
    <form method="POST">
        <label for="MaMonHoc">Subject ID:</label>
        <input type="text" name="ID" required><br>

        <label for="TenMonHoc">Subject Name:</label>
        <input type="text" name="Subject Name" required><br>

        <label for="SoTinChi">Department:</label>
        <input type="text" name="department" required><br>

        <label for="MoTa">Number of Credits:</label>
        <textarea name="numberofcredit"></textarea><br>

        <button type="submit" name="action" value="add">Add</button>
        <button type="submit" name="action" value="edit">Update</button>
        <button type="submit" name="action" value="delete">Delete</button>
    </form>

    <!-- Form Tìm kiếm -->
    <form method="GET">
        <input type="text" name="search" placeholder="Tìm kiếm môn học..." value="<?php echo $search; ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Danh sách môn học -->
    <h2>Course List</h2>
    <table border="1">
        <tr>
            <th>CourseID</th>
            <th>Course Name</th>
            <th>Department</th>
            <th>Number of credits</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['ID']}</td>
                        <td>{$row['Name']}</td>
                        <td>{$row['Department']}</td>
                        <td>{$row['Credit']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
