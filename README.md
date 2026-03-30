🎓 Automated-Faculty-Evaluation-System:
A lightweight, database-driven web application built using PHP and MySQL to automate faculty evaluation workflows. 
Designed to replace manual feedback collection with a structured, secure, and scalable system.

⚡ Tech Stack:
PHP
MySQL
HTML
CSS
XAMPP

Run with:
git clone https://github.com/your-username/faculty-evaluation-system.git
cd faculty-evaluation-system

🛠️ Environment Setup:
Start Apache and MySQL from XAMPP Control Panel

🗄️ Database Initialization:
http://localhost/phpmyadmin
Run: 
CREATE DATABASE faculty_eval;
USE faculty_eval;
SOURCE faculty_eval.sql;

⚙️ Configuration:
$conn = mysqli_connect("localhost", "root", "", "faculty_eval");

▶️ Run Application:
mv faculty-evaluation-system /xampp/htdocs/
http://localhost/faculty-evaluation-system

🧠 System Flow:
Student → Login → Fill Evaluation Form → Submit
        ↓
     PHP Backend Processing
        ↓
     MySQL Database Storage
        ↓
Admin → Retrieve Data → Analyze Performance

📁 Project Structure:
faculty-evaluation-system/
│
├── admin/          # admin dashboard and controls
├── student/        # student interface and forms
├── config/         # database connection
├── database/       # SQL schema
├── assets/         # css, images
└── index.php       # entry point

🔐 Core Features:
Authentication system
Dynamic evaluation forms
Structured relational database
Session-based access control
Lightweight PHP backend

