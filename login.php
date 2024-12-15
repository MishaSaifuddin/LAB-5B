<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('BG.jpg'); /* Path to your background image */
            background-size: cover; /* Make the image cover the entire background */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent tiling/repeating of the image */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: #fff;
            padding: 60px;
            border-radius: 7px;
            box-shadow: 0 2px 30px rgba(0, 0, 0, 0.1);
            width: 600px;
        }

        label, input {
            display: block;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 9px;
            margin-top: 7px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        input[type="submit"] {
            background-color: #b81c8d;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form method="POST" action="login.php">
        <h1>Login Page</h1>
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" name="login" value="Login">
        <p><a href="registration.html">Register</a> here if you have not.</p>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = ""; // Replace with your MySQL root password
            $dbname = "Lab_5b"; // Replace with your database name

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch input values
            $matric = $conn->real_escape_string($_POST['matric']);
            $passwordInput = $conn->real_escape_string($_POST['password']);

            // Query to verify user
            $sql = "SELECT * FROM users WHERE matric='$matric'";
            $result = $conn->query($sql);

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();

                // Verify password
                if ($passwordInput === $row['password']) { // NOTE: Use password hashing for production
                    // Redirect to the users table page (Question 5)
                    header("Location: registration.html");
                    exit();
                } else {
                    echo "<p class='error'>Invalid username or password, try <a href='login.php'>login</a> again.</p>";
                }
            } else {
                echo "<p class='error'>Invalid username or password, try <a href='login.php'>login</a> again.</p>";
            }

            $conn->close();
        }
        ?>
    </form>
</body>
</html>
