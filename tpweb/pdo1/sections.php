<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once('section.php');
Section::getinstance();
$sections = Section::getsections();

if (isset($_POST['search'])) {
    $designation = trim($_POST['designation']); 
    if (!empty($designation)) {
        $filteredsections = [];
        foreach ($sections as $section) {
            if (stripos($section['designation'], $designation) !== false) {
                $filteredsections[] = $section;
            }
        }
        $sections = $filteredsections;
    } else {
        $sections = Section::getsections();
    }
}

if (isset($_POST['filter'])) {
    $designation = trim($_POST['designation']);
    $sections = Section::getSection($designation);
    if (!empty($sections)) {
        if (!isset($sections[0])) {
            $sections = array($sections);
        }
    } else {
        $sections = [];
    }
}

if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    if (Section::getSectionById($id)) {
        Section::deleteSection($id);
        header("Location: sections.php"); 
        exit;
    } else {
        echo "<script>alert('Failed to delete section.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sections Management System</title>
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
    <span><strong>Sections Management System</strong></span>
    <a href="/index.php">Home</a>
    <a href="/students.php">Liste des étudiants</a>
    <a href="sections.php">Liste des sections</a>
    <a href="/logout.php">Logout</a>
</div>

<div class="container">
    <h3>Liste des sections</h3>
    
    <form method="post" class="filter-form">
        <input type="text" name="designation" placeholder="Rechercher une section par nom">
        <button type="submit" name="filter">Filtrer</button>
    </form>
    <?php if ($_SESSION['role'] === 'admin'): ?>

    <a href="/addSection.php" class="add-button">Add Section</a>
    <?php endif; ?>

    <form method="post" class="filter-form">
        <input type="text" name="designation" placeholder="Rechercher une section par nom">
        <button type="submit" name="search">Rechercher</button>
    </form>
    
    <table id="sectionsTable" class="display">
        <thead>
            <tr>
                <th>Id</th>
                <th>Designation</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($sections)) : ?>
                <tr>
                    <td colspan="4">No sections found</td>
                </tr>
            <?php else: ?>
                <?php foreach ($sections as $section): ?>
                    <tr>
                        <td><?= htmlspecialchars($section['id']) ?></td>
                        <td><?= htmlspecialchars($section['designation']) ?></td>
                        <td><?= htmlspecialchars($section['description']) ?></td>
                        <td class="action-icons">
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <a href="/updatesection.php?id=<?= $section['id'] ?>"><img src="https://img.icons8.com/ios-glyphs/20/000000/edit.png" alt="Edit"/></a>
                            <?php endif; ?>
                            <a href="/inlisted.php?designation=<?= urlencode($section['designation']) ?>"><img src="https://img.icons8.com/ios-glyphs/20/000000/details.png" alt="View"/></a>
                            <form method="POST" action="" style="display: inline;">
                                <input type="hidden" name="delete_id" value="<?= $section['id'] ?>">
                                <button type="submit" onclick="return confirm('Delete this section?')" style="background: none; border: none; cursor: pointer;">
                                    <img src="https://img.icons8.com/ios-glyphs/20/000000/delete-forever.png" alt="Delete"/>
                                </button>
                            </form>
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
        $('#sectionsTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'excel', 'csv', 'pdf'] 
        });
    });
</script>
</body>
</html>