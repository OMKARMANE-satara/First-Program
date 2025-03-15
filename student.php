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
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $rollno = $_POST['rollno'];
    $class = $_POST['class'];

    // Check if rollno already exists
    $check_query = "SELECT * FROM students WHERE rollno='$rollno'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        $message = "Error: This Roll Number already exists!";
    } else {
        $insert_query = "INSERT INTO students (student_id, name, rollno, class) VALUES ('$student_id', '$name', '$rollno', '$class')";
        if ($conn->query($insert_query) === TRUE) {
            $message = "Data saved successfully!";
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
    <title>Student Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f4f4f4;
            margin: 0;
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
            background: #28a745;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
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
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .back-logo img {
            width: 40px;
            height: 40px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Student Registration</h2>

        <?php if (!empty($message)) { ?>
            <p class="message <?php echo (strpos($message, 'successfully') !== false) ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <form action="" method="POST">
            <input type="number" name="student_id" placeholder="Student ID" required>
            <input type="text" name="name" placeholder="Student Name" required>
            <input type="number" name="rollno" placeholder="Roll Number" required>
            <input type="text" name="class" placeholder="Class" required>
            <button type="submit">Submit</button>
        </form>

        <!-- Back Logo Below Submit Button -->
        <div class="back-logo">
            <a href="index.php">
                <img src="back.png" alt="Back">
            </a>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
