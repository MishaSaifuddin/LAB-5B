<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lab_5b";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission for updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $conn->real_escape_string($_POST['matric']);
    $name = $conn->real_escape_string($_POST['name']);
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "UPDATE users SET name='$name', role='$role' WHERE matric='$matric'";
    if ($conn->query($sql) === TRUE) {
        $message = "User updated successfully.";
    } else {
        $message = "Error updating user: " . $conn->error;
    }
}

// Filter and retrieve only specific users
$sql = "
    SELECT matric, name, role 
    FROM users 
    WHERE matric IN ('02000', 'A100', 'A101', 'A103')
";
$result = $conn->query($sql);

// Retrieve user details for updating if 'update' action is triggered
$userToEdit = null;
if (isset($_GET['action']) && $_GET['action'] === 'update' && isset($_GET['matric'])) {
    $matric = $conn->real_escape_string($_GET['matric']);
    $sql = "SELECT * FROM users WHERE matric='$matric'";
    $editResult = $conn->query($sql);
    if ($editResult->num_rows === 1) {
        $userToEdit = $editResult->fetch_assoc();
    } else {
        $message = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('BG.jpg'); /* Path to your background image */
            background-size: cover; /* Make the image cover the entire background */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent tiling/repeating of the image */
            margin: 0;
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 40px 0;
            background-color: #fff;
            border: 2px solid #ddd;
        }

        table th, table td {
            padding: 12px 18px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #b81c8d;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #b81c8d;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffffff;
        }

        a {
            color: blue;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form label {
            display: block;
            margin-bottom: 9px;
            font-weight: bold;
        }

        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #b81c8d;
        }

        .message {
            margin-bottom: 20px;
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Update Users</h1>

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if ($userToEdit): ?>
        <!-- Update Form -->
        <form method="POST">
            <label for="matric">Matric</label>
            <input type="text" name="matric" id="matric" value="<?= htmlspecialchars($userToEdit['matric']) ?>" readonly>

            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($userToEdit['name']) ?>" required>

            <label for="role">Access Level</label>
            <select name="role" id="role">
                <option value="admin" <?= $userToEdit['role'] === 'admin' ? 'selected' : '' ?>>Lecturer</option>
                <option value="user" <?= $userToEdit['role'] === 'user' ? 'selected' : '' ?>>Student</option>
            </select>

            <button type="submit">Update</button>
            <button type="button" onclick="window.location.href='?';">Cancel</button>
        </form>
    <?php else: ?>
        <!-- Display Users Table -->
        <table>
            <thead>
                <tr>
                    <th>Matric</th>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['matric']) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['role'] === 'admin' ? 'Lecturer' : 'Student') ?></td>
                            <td>
                                <a href="?action=update&matric=<?= urlencode($row['matric']) ?>">Update</a> |
                                <a href="delete_user.php?matric=<?= urlencode($row['matric']) ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
