<?php
session_start();
require_once('section.php');
Section::getinstance();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    http_response_code(403); 
    die("Access Denied: You don't have permission to view this page.");
}
$designation = isset($_GET['designation']) ? $_GET['designation'] : null;
$students=Section::getInscrit($designation);
if (!empty($students)) {
    $i = 1;
    echo'<h1> inlisted students to '. $designation .' </h1>';
    foreach ($students as $student) {
        echo $i . '. ' . htmlspecialchars($student) . '<br>'; // Display student name with escaping for safety
        $i++;
    }
} else {
    echo 'No students found for this section.';
}


?>