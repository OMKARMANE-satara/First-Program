<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('https://www.example.com/your-image.jpg') no-repeat center center fixed; /* Replace with your image URL */
            background-size: cover; /* Ensures the background image covers the entire viewport */
            background-attachment: fixed; /* Keeps the background image fixed while scrolling */
            background-position: center center; /* Centers the background image */
            text-align: center;
            color: white;
            padding: 20px;
            flex-direction: column;
            overflow: hidden;
        }

        /* Container Styling */
        .container {
            background: rgba(0, 0, 0, 0.6); /* Semi-transparent black background for better contrast */
            border-radius: 10px;
            padding: 40px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5); /* Adds shadow for better separation */
        }

        /* Header Styling */
        h1 {
            font-size: 40px;
            margin-bottom: 30px;
            color: #f4f4f4;
        }

        /* List and Button Styling */
        .options {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .options li {
            margin: 15px 0;
        }

        .options a {
            text-decoration: none;
            color: #007bff;
            font-size: 20px;
            padding: 15px;
            background-color: white;
            border-radius: 5px;
            display: inline-block;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s;
        }

        .options a:hover {
            background-color: #0056b3;
            color: white;
        }

        /* Button Container Styling */
        .button-container {
            display: flex;
            justify-content: center;
            flex-direction: column;
        }

        /* Report Button Highlight */
        .report-btn {
            background-color: #ffcc00 !important; /* Highlight Report Button */
            color: black !important;
            font-weight: bold;
        }

        .report-btn:hover {
            background-color: #e6b800 !important;
            color: white !important;
        }

    </style>
</head>
<body>

    <!-- Main Container -->
    <div class="container">
        <h1>TEST SYSTEM FOR COLLEGE</h1>

        <div class="button-container">
            <ul class="options">
                <li><a href="student.php">Add Student</a></li>
                <li><a href="subject.php">Add Subject</a></li>
                <li><a href="teacher.php">Add Teacher</a></li>
                <li><a href="test_entry.php">Tests Data</a></li>
                <li><a href="report.php" class="report-btn">Report</a></li>  <!-- Report Button Added -->
            </ul>
        </div>
    </div>

</body>
</html>
