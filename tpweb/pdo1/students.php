<?php
session_start();
require_once('etudiant.php');
etudiant::getinstance();
$students = etudiant::getEtudiants();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if (isset($_POST['search'])) {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $filteredStudents = [];
        foreach ($students as $student) {
            if (stripos($student['name'], $name) !== false) {
                $filteredStudents[] = $student;
            }
        }
        $students = $filteredStudents;
    } else {
        $students = etudiant::getEtudiants();
    }
}

// Handle filtering functionality
if (isset($_POST['filter'])) {
    $name = trim($_POST['name']);
    $students = etudiant::getEtudiantByName($name);
    if (!empty($students)) {
        if (!isset($students[0])) {
            $students = array($students);
        }
    } else {
        $students = [];
    }
}

if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    if (etudiant::getEtudiant($id)) {
        etudiant::deleteEtudiant($id);
        header("Location: students.php"); 
        exit;
    } else {
        echo "<script>alert('Failed to delete student.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students Management System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
</head>
<body>
<div class="navbar">
    <span><strong>Students Management System</strong></span>
    <a href="/index.php">Home</a>
    <a href="/students.php">Liste des étudiants</a>
    <a href="sections.php">Liste des sections</a>
    <a href="/logout.php">Logout</a>
</div>

<div class="container">
    <h3>Liste des étudiants</h3>
    <form method="post" class="filter-form">
        <input type="text" name="name" placeholder="Rechercher un étudiant par nom">
        <button type="submit" name="filter">Filtrer</button>
    </form>
    <?php if ($_SESSION['role'] === 'admin'): ?>
    <a href="/addStudent.php" class="add-button">Add Student</a>
    <?php endif; ?>
    <form method="post" class="filter-form">
        <input type="text" name="name" placeholder="Rechercher un étudiant par nom">
        <button type="submit" name="search">Rechercher</button>
    </form>
    
    <table id="studentsTable" class="display">
        <thead>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>Name</th>
                <th>Birthday</th>
                <th>Section</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($students)) : ?>
                <tr>
                    <td colspan="6">No students found</td>
                </tr>
            <?php else: ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['id']) ?></td>
                        <td>
                            <img src="<?= htmlspecialchars('images/' . $student['image']) ?>" alt="profile" class="profile-img">
                        </td>
                        <td><?= htmlspecialchars($student['name']) ?></td>
                        <td><?= htmlspecialchars($student['birthday']) ?></td>
                        <td><?= htmlspecialchars($student['section']) ?></td>
                        <td class="action-icons">
                            <a href="/detailsStudent.php?id=<?= $student['id'] ?>"><img src="https://img.icons8.com/ios-glyphs/20/000000/view-file.png" alt="View"/></a>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                            <a href="/updateStudent.php?id=<?= $student['id'] ?>"><img src="https://img.icons8.com/ios-glyphs/20/000000/edit.png" alt="Edit"/></a>
                            <form method="POST" action="" style="display: inline;">
                                <input type="hidden" name="delete_id" value="<?= $student['id'] ?>">
                                <button type="submit" onclick="return confirm('Delete this student?')" style="background: none; border: none; cursor: pointer;">
                                    <img src="https://img.icons8.com/ios-glyphs/20/000000/delete-forever.png" alt="Delete"/>
                                </button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    $.fn.dataTable.ext.errMode = 'none';

    $(document).ready(function () {
        $('#studentsTable').DataTable({
            dom: 'Bfrtip', 
            buttons: ['copy', 'excel', 'csv', 'pdf'] 
        });
    });
</script>
</body>
</html>
