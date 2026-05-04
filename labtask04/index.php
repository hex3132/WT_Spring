<?php
include 'config.php';

if (isset($_POST['btn_save'])) {
    $s_name = mysqli_real_escape_string($db_link, $_POST['f_name']);
    $s_mail = mysqli_real_escape_string($db_link, $_POST['f_mail']);
    $s_reg  = mysqli_real_escape_string($db_link, $_POST['f_reg']);
    $s_dept = mysqli_real_escape_string($db_link, $_POST['f_dept']);

    $insert_sql = "INSERT INTO students (name, email, registration_no, department) 
                   VALUES ('$s_name', '$s_mail', '$s_reg', '$s_dept')";
    
    if (mysqli_query($db_link, $insert_sql)) {
        header("Location: view_students.php?msg=added");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Student</title>
    <style>
        body { font-family: sans-serif; background: #f0f0f0; padding: 50px; }
        .form-card { background: white; padding: 20px; width: 400px; margin: auto; border-radius: 10px; }
        input, select { width: 100%; padding: 8px; margin-bottom: 15px; box-sizing: border-box; }
    </style>
</head>
<body>
    <div class="form-card">
        <h3>Enrollment Form</h3>
        <form method="POST">
            <label>Name</label><input type="text" name="f_name" required>
            <label>Email</label><input type="email" name="f_mail" required>
            <label>Reg Number</label><input type="text" name="f_reg" required>
            <label>Department</label>
            <select name="f_dept">
                <option value="CSE">CSE</option>
                <option value="BBA">BBA</option>
                <option value="EEE">EEE</option>
            </select>
            <button type="submit" name="btn_save">Save Student</button>
            <a href="view_students.php">Back</a>
        </form>
    </div>
</body>
</html>