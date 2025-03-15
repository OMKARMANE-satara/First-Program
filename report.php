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

// Fetch subjects
$subjects = $conn->query("SELECT subject_id, subject_name FROM subjects");

// Default Query
$query = "SELECT s.name, s.rollno, sub.subject_name, t.t_name, te.test_type, te.marks
          FROM tests te
          JOIN students s ON s.student_id = te.student_id
          JOIN subjects sub ON sub.subject_id = te.subject_id
          JOIN teachers t ON t.t_id = te.teacher_id";

// Handle form submission
$selected_subject = "";
$selected_subject_name = "All Subjects";
$selected_marks_range = "";
$selected_test_type = "";
$user_selection = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conditions = [];

    if (!empty($_POST['subject_id'])) {
        $selected_subject = $_POST['subject_id'];
        $subject_query = $conn->query("SELECT subject_name FROM subjects WHERE subject_id = '$selected_subject'");
        if ($subject_row = $subject_query->fetch_assoc()) {
            $selected_subject_name = $subject_row['subject_name'];
        }
        $conditions[] = "te.subject_id = '$selected_subject'";
    }

    if (!empty($_POST['marks_range'])) {
        $selected_marks_range = $_POST['marks_range'];
        if ($selected_marks_range == "below50") {
            $conditions[] = "te.marks < 50";
            $user_selection = "Below 50 Marks";
        } elseif ($selected_marks_range == "50_70") {
            $conditions[] = "te.marks BETWEEN 50 AND 70";
            $user_selection = "Marks between 50 and 70";
        } elseif ($selected_marks_range == "70_90") {
            $conditions[] = "te.marks BETWEEN 70 AND 90";
            $user_selection = "Marks between 70 and 90";
        } elseif ($selected_marks_range == "above90") {
            $conditions[] = "te.marks > 90";
            $user_selection = "Above 90 Marks";
        }
    }

    if (!empty($_POST['test_type'])) {
        $selected_test_type = $_POST['test_type'];
        if ($selected_test_type == "Internal") {
            $conditions[] = "te.test_type = 'Internal'";
            $user_selection = "Internal Tests";
        } elseif ($selected_test_type == "External") {
            $conditions[] = "te.test_type = 'External'";
            $user_selection = "External Tests";
        }
    }

    // Add conditions to query
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }
}

$results = $conn->query($query);
$student_count = $results->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
            background: #f4f4f4;
        }
        .navbar {
            width: 250px;
            background: #007bff;
            color: white;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }
        .navbar a, .navbar button {
            text-decoration: none;
            color: white;
            padding: 10px;
            margin-bottom: 10px;
            background: #0056b3;
            text-align: center;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .navbar a:hover, .navbar button:hover {
            background: #004085;
        }
        .container {
            flex-grow: 1;
            padding: 20px;
            background: white;
            margin-left: 270px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }
        select, button {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .count {
            margin-top: 20px;
            font-weight: bold;
            font-size: 18px;
            text-align: center;
        }
        .selection-box {
            margin-top: 20px;
            padding: 15px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="index.php">Home</a>

        <form action="" method="POST">
            <label>Select Subject:</label>
            <select name="subject_id">
                <option value="">All Subjects</option>
                <?php while ($row = $subjects->fetch_assoc()) { ?>
                    <option value="<?= $row['subject_id']; ?>" <?= ($selected_subject == $row['subject_id']) ? 'selected' : '' ?>>
                        <?= $row['subject_name']; ?>
                    </option>
                <?php } ?>
            </select>

            <label>Select Marks Range:</label>
            <select name="marks_range">
                <option value="">All Marks</option>
                <option value="below50" <?= ($selected_marks_range == "below50") ? 'selected' : '' ?>>Below 50</option>
                <option value="50_70" <?= ($selected_marks_range == "50_70") ? 'selected' : '' ?>>50-70</option>
                <option value="70_90" <?= ($selected_marks_range == "70_90") ? 'selected' : '' ?>>70-90</option>
                <option value="above90" <?= ($selected_marks_range == "above90") ? 'selected' : '' ?>>Above 90</option>
            </select>

            <button type="submit">Submit</button>
        </form>

        <form action="" method="POST">
            <input type="hidden" name="test_type" value="Internal">
            <button type="submit">Internal</button>
        </form>

        <form action="" method="POST">
            <input type="hidden" name="test_type" value="External">
            <button type="submit">External</button>
        </form>

        <form action="" method="POST">
            <button type="submit">All Reports</button>
        </form>
    </div>

    <!-- Container -->
    <div class="container">
        <h1>Report Page</h1>

        <!-- Display selected filters -->
        <?php if (!empty($user_selection)) { ?>
            <div class="selection-box">
                <p>Showing results for: <strong><?= $user_selection ?></strong></p>
                <?php if ($selected_subject != "") { ?>
                    <p>Subject: <strong><?= $selected_subject_name ?></strong></p>
                <?php } ?>
            </div>
        <?php } ?>

        <!-- Display results in table format -->
        <?php if ($results->num_rows > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Roll No</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Test Type</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $results->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['rollno']; ?></td>
                            <td><?= $row['subject_name']; ?></td>
                            <td><?= $row['t_name']; ?></td>
                            <td><?= $row['test_type']; ?></td>
                            <td><?= $row['marks']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="count">
                Total Students: <?= $student_count; ?>
            </div>
        <?php } else { ?>
            <p>No records found.</p>
        <?php } ?>

    </div>

</body>
</html>

<?php
$conn->close();
?>
