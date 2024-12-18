<?php
$servername = "localhost";
$username = "root"; // Change to your MySQL account
$password = "";
$dbname = "studentmanagement";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Khởi tạo các biến
$editMode = false;
$student = [
    'StudentID' => '',
    'FullName' => '',
    'DateOfBirth' => '',
    'Gender' => '',
    'Major' => '',
    'Email' => '',
    'Phone' => ''
];

// Xử lý logic thêm, sửa, xóa sinh viên
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {
        $id = $_POST['StudentID'];
        $name = $_POST['FullName'];
        $dob = $_POST['DateOfBirth'];
        $gender = $_POST['Gender'];
        $major = $_POST['Major'];
        $email = $_POST['Email'];
        $phone = $_POST['Phone'];

        if ($id) {
            // Sửa sinh viên
            $sql = "UPDATE Students SET 
                        FullName = ?, 
                        DateOfBirth = ?, 
                        Gender = ?,
                        Major = ?,
                        Email = ?, 
                        Phone = ?
                    WHERE StudentID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $name, $dob, $gender, $major, $email, $phone, $id);
        } else {
            // Thêm mới sinh viên
            $sql = "INSERT INTO Students (FullName, DateOfBirth, Gender, Major, Email, Phone) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $name, $dob, $gender, $major, $email, $phone);
        }

        if ($stmt->execute()) {
            header("Location: Student.php");
            exit();
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['delete'];
        $sql = "DELETE FROM Students WHERE StudentID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: Student.php");
        exit();
    }
}

// Tải dữ liệu để sửa sinh viên
if (isset($_GET['edit'])) {
    $editMode = true;
    $id = $_GET['edit'];
    $sql = "SELECT * FROM Students WHERE StudentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Thiết lập chung */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        .container {
            margin-top: 30px;
            max-width: 800px;
        }
        /* Tiêu đề */
        h2 {
            font-size: 2em;
            font-weight: bold;
        }
        /* Card và các thành phần */
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            font-weight: bold;
        }
        .card-body {
            padding: 20px;
        }
        .btn {
            border-radius: 5px;
        }
        /* Biểu mẫu */
        form .form-label {
            font-weight: bold;
        }       
        form .form-control {
            border-radius: 5px;
        }
        /* Bảng danh sách sinh viên */
        .table {
            margin-top: 15px;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: #f0f8ff;
        }       
        .btn-sm {
            padding: 5px 10px;
        }
        .btn-warning {
            color: #fff;
        }
        .btn-danger {
            color: #fff;
        }
        /* Nút hành động */
        .btn-sm {
            font-size: 0.9em;
            margin: 0 2px;
        }
        /* Màu sắc */
        .bg-info {
            background-color: #17a2b8 !important;
        }
        .text-primary {
            color: #007bff !important;
        }

    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center text-primary mb-4">Student Management</h2>

    <!-- Biểu mẫu Thêm/Sửa -->
    <div class="card mb-5">
        <div class="card-header bg-info text-white">
            <h5><?= $editMode ? 'Sửa thông tin sinh viên' : 'Thêm sinh viên mới' ?></h5>
        </div>
        <div class="card-body">
            <form method="POST">
            <div class="mb-3">
                    <label for="ID" class="form-label">ID:</label>
                    <input type="text" class="form-control" id="ID" name="ID" value="<?= $student['StudentID'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="FullName" class="form-label">FullName:</label>
                    <input type="text" class="form-control" id="FullName" name="FullName" value="<?= $student['FullName'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="DateOfBirth" class="form-label">DateOfBirth:</label>
                    <input type="date" class="form-control" id="DateOfBirth" name="DateOfBirth" value="<?= $student['DateOfBirth'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="Gender" class="form-label">Gender:</label>
                    <input type="gender" class="form-control" id="Gender" name="Gender" value="<?= $student['Gender'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="Major" class="form-label">Major:</label>
                    <input type="text" class="form-control" id="Major" name="Major" value="<?= $student['Major'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="Email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="Email" name="Email" value="<?= $student['Email'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="Phone" class="form-label">Phone:</label>
                    <input type="text" class="form-control" id="Phone" name="Phone" value="<?= $student['Phone'] ?>" required>
                </div>
                
                <button type="submit" name="save" class="btn btn-success"><?= $editMode ? 'Update' : 'Add' ?></button>
                <?php if ($editMode): ?>
                    <a href="Student.php" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <!-- Bảng hiển thị danh sách sinh viên -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5>Student List</h5>
            <a href="formchinh.php">Return</a>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>FullName</th>
                        <th>DateOfBirth</th>
                        <th>Gender</th>
                        <th>Major</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM student");
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['StudentID'] ?></td>
                            <td><?= $row['FullName'] ?></td>
                            <td><?= $row['DateOfBirth'] ?></td>
                            <td><?= $row['Gender'] ?></td>
                            <td><?= $row['Major'] ?></td>
                            <td><?= $row['Email'] ?></td>
                            <td><?= $row['Phone'] ?></td>
                            <td>
                                <a href="?edit=<?= $row['StudentID'] ?>" class="btn btn-warning btn-sm">Update</a>
                                <form method="POST" style="display: inline-block;">
                                    <button type="submit" name="delete" value="<?= $row['StudentID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>