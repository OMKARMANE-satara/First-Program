<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$database = "exam_sys";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $t_id = $_POST['teacher_id'];
    $t_name = $_POST['teacher_name'];
    $dept = $_POST['department'];
    $designation = $_POST['designation'];

    // Check if teacher name already exists
    $check_query = "SELECT * FROM teachers WHERE t_name='$t_name' AND dept='$dept'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        $message = "Error: This teacher already exists!";
    } else {
        $insert_query = "INSERT INTO teachers (t_id, t_name, dept, designation) 
                         VALUES ('$t_id', '$t_name', '$dept', '$designation')";
        if ($conn->query($insert_query) === TRUE) {
            $message = "Teacher saved successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f4f4f4;
            margin: 0;
            flex-direction: column;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .message {
            font-weight: bold;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .back-logo {
            margin-top: 20px;
            cursor: pointer;
            font-size: 24px;
            color: #007bff;
        }
        .back-logo:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Teacher Registration</h2>

        <?php if (!empty($message)) { ?>
            <p class="message <?php echo (strpos($message, 'successfully') !== false) ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <form action="" method="POST">
            <input type="number" name="teacher_id" placeholder="Teacher ID" required>
            <input type="text" name="teacher_name" placeholder="Teacher Name" required>
            <input type="text" name="department" placeholder="Department" required>
            <input type="text" name="designation" placeholder="Designation" required>
            <button type="submit">Submit</button>
        </form>

        <!-- Back Logo -->
        <a href="index.php" class="back-logo">&#8592; Back</a> <!-- Back arrow logo linking to index.php -->

    </div>

</body>
</html>

<?php
$conn->close();
?>
