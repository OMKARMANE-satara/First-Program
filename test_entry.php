<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "root";
$database = "exam_sys";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch students
$students = $conn->query("SELECT student_id, name, rollno FROM students");

// Fetch subjects
$subjects = $conn->query("SELECT subject_id, subject_name FROM subjects");

// Fetch teachers
$teachers = $conn->query("SELECT t_id, t_name FROM teachers");

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $test_type = $_POST['test_type'];
    $test_date = $_POST['test_date'];
    $marks = $_POST['marks'];
    $teacher_id = $_POST['teacher_id'];

    // Check if the student already has a test entry for the same subject and test type
    $check_query = "SELECT * FROM tests WHERE student_id='$student_id' AND subject_id='$subject_id' AND test_type='$test_type'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        $message = "Error: This student has already taken the $test_type test for this subject!";
    } elseif ($marks < 0 || $marks > 100) {
        $message = "Error: Enter valid marks (0-100)!";
    } else {
        // Insert data if validation passes
        $insert_query = "INSERT INTO tests (student_id, subject_id, test_type, test_date, marks, teacher_id) 
                         VALUES ('$student_id', '$subject_id', '$test_type', '$test_date', '$marks', '$teacher_id')";
        if ($conn->query($insert_query) === TRUE) {
            $message = "Test record saved successfully!";
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
    <title>Test Entry</title>
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
        label {
            display: block;
            text-align: left;
            margin-top: 10px;
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: white;
            cursor: pointer;
            margin-top: 20px;
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
            margin-top: 30px;
            cursor: pointer;
            font-size: 24px;
            color: #007bff;
            text-decoration: none;
        }
        .back-logo:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Test Entry Form</h2>

        <?php if (!empty($message)) { ?>
            <p class="message <?php echo (strpos($message, 'successfully') !== false) ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <form action="" method="POST">
            <!-- Student Dropdown -->
            <label>Student:</label>
            <select name="student_id" required>
                <option value="">Select Student</option>
                <?php while ($row = $students->fetch_assoc()) { ?>
                    <option value="<?= $row['student_id']; ?>">
                        <?= $row['rollno'] . " - " . $row['name']; ?>
                    </option>
                <?php } ?>
            </select>

            <!-- Subject Dropdown -->
            <label>Subject:</label>
            <select name="subject_id" required>
                <option value="">Select Subject</option>
                <?php while ($row = $subjects->fetch_assoc()) { ?>
                    <option value="<?= $row['subject_id']; ?>">
                        <?= $row['subject_name']; ?>
                    </option>
                <?php } ?>
            </select>

            <!-- Test Type Dropdown -->
            <label>Test Type:</label>
            <select name="test_type" required>
                <option value="Internal">Internal</option>
                <option value="External">External</option>
            </select>

            <!-- Test Date -->
            <label>Test Date:</label>
            <input type="date" name="test_date" required>

            <!-- Marks -->
            <label>Marks (0-100):</label>
            <input type="number" name="marks" min="0" max="100" required>

            <!-- Teacher Dropdown -->
            <label>Teacher:</label>
            <select name="teacher_id" required>
                <option value="">Select Teacher</option>
                <?php while ($row = $teachers->fetch_assoc()) { ?>
                    <option value="<?= $row['t_id']; ?>">
                        <?= $row['t_id'] . " - " . $row['t_name']; ?>
                    </option>
                <?php } ?>
            </select>

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
