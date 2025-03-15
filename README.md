# First-Program
# Test System for College

## Project Overview
The **Test System for College** is a PHP-based web application that allows students and teachers to manage and evaluate test results efficiently. It provides functionality for user authentication, test management, and performance analysis.

## Features
- **Student Management:** Add, edit, and manage student details.
- **Teacher Management:** Assign teachers to subjects and tests.
- **Subject Management:** Manage available subjects for tests.
- **Test Management:** Create, edit, and manage tests.
- **Result Analysis:** View reports and filter results based on test performance.
- **Navigation Bar:** Provides quick access to `Home` and `Report` pages.

## Technologies Used
- **Backend:** PHP (Procedural or OOP)
- **Database:** MySQL (`exam_system` database)
- **Frontend:** HTML, CSS, Bootstrap (optional for styling)

## Database Schema
Database Name: `exam_system`

### Tables:
1. **students** (`id`, `name`, `email`, `roll_number`)
2. **teachers** (`id`, `name`, `email`)
3. **subjects** (`id`, `subject_name`, `teacher_id`)
4. **tests** (`id`, `subject_id`, `test_name`, `date`)
5. **results** (`id`, `student_id`, `test_id`, `score`)

## Installation Steps
1. Install **XAMPP** (or any Apache + MySQL server).
2. Start **Apache** and **MySQL** from XAMPP Control Panel.
3. Open **phpMyAdmin** and create a database named `exam_system`.
4. Import the provided SQL file into the database.
5. Place the project files inside `htdocs` (if using XAMPP) or the server directory.
6. Open `http://localhost/test-system` in a browser.

## Usage
- **Login as a Student or Teacher** to access relevant features.
- **Admin can create tests and assign subjects.**
- **Students can view test results in the report section.**

## Report Page Filters
The report page includes a navbar with the following filters:
- `Mid-term`
- `Final Exam`
- `Above 60%`
- `Below 60%`

## File Structure
```
/test-system/
│── index.php        # Main Entry Point (Login Page)
│── report.php       # Displays Test Reports
│── config.php       # Database Configuration
│── functions.php    # Common Functions
│── assets/
│   ├── css/        # Stylesheets
│   ├── js/         # JavaScript Files
│── views/
│   ├── home.php    # Dashboard Page
│   ├── test.php    # Manage Tests
│   ├── student.php # Manage Students
```

## Author
Developed by **Aditya Kumar** (or your name)

## License
This project is open-source and can be modified for educational purposes.

---
**Happy Coding! 🚀**

