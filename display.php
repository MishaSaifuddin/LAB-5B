<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Table</title>
    <style>
        /* General styling for the page */
        body {
            font-family: Arial, sans-serif;
            background-image: url('BG.jpg'); /* Path to your background image */
            background-size: cover; /* Make the image cover the entire background */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent tiling/repeating of the image */
            margin: 0;
            padding: 30px;
        }

        /* Styling for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            border: 2px solid #ddd;
        }

        table th, table td {
            padding: 12px 15px;
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
    </style>
</head>
<body>
    <h1>Users Table</h1>
    <table>
        <thead>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Data to display
            $insertData = [
                ["02000", "NUR ARIFFIN MOHD ZIN", "admin"],
                ["A100", "AHMAD", "user"],
                ["A101", "ABU", "user"],
                ["A103", "AHMAD BIN ABU", "user"]
            ];

            // Loop through the data and display in the table
            foreach ($insertData as $data) {
                $matric = htmlspecialchars($data[0]);
                $name = htmlspecialchars($data[1]);
                $role = $data[2] === "admin" ? "LECTURER" : "STUDENT";

                echo "<tr>";
                echo "<td>$matric</td>";
                echo "<td>$name</td>";
                echo "<td>$role</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
