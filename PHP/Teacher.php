<?php
$servername = "localhost";
$username = "root"; // Change to your MySQL account
$password = "";
$dbname = "studentmanagement";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add/edit/delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $department = $_POST['department'];

        $sql = "INSERT INTO teachers (name, email, phone, department) VALUES ('$name', '$email', '$phone', '$department')";
        $conn->query($sql);
    }

    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $department = $_POST['department'];

        $sql = "UPDATE teachers SET name='$name', email='$email', phone='$phone', department = '$department' WHERE id=$id";
        $conn->query($sql);
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM teachers WHERE id=$id";
        $conn->query($sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management</title>
    <style>
        /* General */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

        /* Add teacher form */
        form {
            margin-bottom: 20px;
        }

        form input {
            margin: 5px 0;
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        form button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
        }

        /* Teacher table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }

        table th, table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        /* Actions */
        form[method="POST"] {
            display: inline-block;
            margin: 5px 0;
        }

        form input[type="text"],
        form input[type="email"] {
            width: 150px;
            margin: 0 5px;
            padding: 5px;
            font-size: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            padding: 5px 10px;
            font-size: 12px;
        }

        form button[name="delete"] {
            background-color: #f44336;
            color: white;
        }

        form button[name="delete"]:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <h1>Teacher Management</h1>

    <h2>Add Teacher</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Teacher Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone Number">
        <input type="text" name="department" placeholder="department">
        <button type="submit" name="add">Add</button>
    </form>

    <h2>Teacher List</h2>
    <a href="formchinh.php">Go Back</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM teacher");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['department']}</td>
                <td>
                    <form method='POST' style='display: inline-block;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <input type='text' name='name' value='{$row['name']}' required>
                        <input type='email' name='email' value='{$row['email']}' required>
                        <input type='text' name='phone' value='{$row['phone']}'>
                        <input type='text' name='department' value='{$row['department']}'>
                        <button type='submit' name='edit'>Edit</button>
                    </form>
                    <form method='POST' style='display: inline-block;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit' name='delete'>Delete</button>
                    </form>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
