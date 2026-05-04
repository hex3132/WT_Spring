<?php 
include 'config.php'; 

if (isset($_GET['remove_id'])) {
    $target = $_GET['remove_id'];
    mysqli_query($db_link, "DELETE FROM students WHERE id = $target");
    header("Location: view_students.php?msg=deleted");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>University Student Portal</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #eef2f3; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 25px; border-top: 5px solid #007bff; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #343a40; color: #fff; padding: 10px; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        .btn-add { background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 3px; }
        .action-link { font-weight: bold; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-flex">
        <h2>Student Directory</h2>
        <a href="add_student.php" class="btn-add">+ New Student</a>
    </div>

    <?php if(isset($_GET['msg'])) echo "<p style='color:green'>Operation Successful!</p>"; ?>

    <table>
        <thead>
            <tr>
                <th>Reg No</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Dept</th>
                <th>Manage</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM students ORDER BY id DESC";
            $data = mysqli_query($db_link, $query);
            while ($row = mysqli_fetch_array($data)) {
                echo "<tr>";
                echo "<td>".$row['registration_no']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td>".$row['department']."</td>";
                echo "<td>
                        <a class='action-link' style='color:orange' href='edit_record.php?sid=".$row['id']."'>Modify</a> | 
                        <a class='action-link' style='color:red' href='view_students.php?remove_id=".$row['id']."' onclick='return confirm(\"Delete student?\")'>Remove</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>