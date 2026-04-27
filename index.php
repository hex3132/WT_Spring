<?php

$errors = [];
$success_message = "";
$user_data = [];

if (isset($_POST['register'])) {
    // 1. Sanitize and collect inputs
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $course = $_POST['course'] ?? '';
    $terms = isset($_POST['terms']);


    // 1. Check for empty fields
    if (empty($full_name) || empty($email) || empty($username) || empty($password) || empty($age) || empty($gender) || empty($course)) {
        $errors[] = "All fields are required.";
    }

    // 2. Full Name validation (Letters and spaces only)
    if (!empty($full_name) && !preg_match("/^[a-zA-Z ]*$/", $full_name)) {
        $errors[] = "Full Name must contain only letters and spaces.";
    }

    // 3. Email format validation
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // 4. Username length (min 5 characters)
    if (!empty($username) && strlen($username) < 5) {
        $errors[] = "Username must be at least 5 characters long.";
    }

    // 5. Password length (min 6 characters)
    if (!empty($password) && strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // 6. Password and Confirm Password match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // 7. Age validation (18 or above)
    if (!empty($age) && (int)$age < 18) {
        $errors[] = "You must be 18 years or older to register.";
    }

    // 8. Gender selection
    if (empty($gender)) {
        $errors[] = "Please select your gender.";
    }

    // 9. Course selection (assuming first option is "Select Course")
    if ($course === "none") {
        $errors[] = "Please select a course.";
    }

    // 10. Terms and Conditions
    if (!$terms) {
        $errors[] = "You must accept the Terms & Conditions.";
    }

    // --- OUTPUT LOGIC ---
    if (empty($errors)) {
        $success_message = "Registration Successful!";
        $user_data = [
            "Full Name" => htmlspecialchars($full_name),
            "Email" => htmlspecialchars($email),
            "Username" => htmlspecialchars($username),
            "Age" => htmlspecialchars($age),
            "Gender" => htmlspecialchars($gender),
            "Course" => htmlspecialchars($course)
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>University Registration</title>
    <style>
        body { font-family: sans-serif; margin: 20px; line-height: 1.6; }
        .error { color: #d9534f; background: #f2dede; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .success { color: #3c763d; background: #dff0d8; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .user-details { background: #f9f9f9; border: 1px solid #ddd; padding: 15px; margin-top: 10px; }
        form div { margin-bottom: 15px; }
        label { display: block; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"], input[type="number"], select { width: 300px; padding: 8px; }
    </style>
</head>
<body>

    <h2>Student Registration Form</h2>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success_message): ?>
        <div class="success">
            <h3><?php echo $success_message; ?></h3>
            <div class="user-details">
                <strong>Submitted Details:</strong><br>
                <?php foreach ($user_data as $key => $value): ?>
                    <?php echo "<strong>$key:</strong> $value <br>"; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div>
            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($full_name ?? ''); ?>">
        </div>

        <div>
            <label>Email Address:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
        </div>

        <div>
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>">
        </div>

        <div>
            <label>Password:</label>
            <input type="password" name="password">
        </div>

        <div>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password">
        </div>

        <div>
            <label>Age:</label>
            <input type="number" name="age" value="<?php echo htmlspecialchars($age ?? ''); ?>">
        </div>

        <div>
            <label>Gender:</label>
            <input type="radio" name="gender" value="Male" <?php if(isset($gender) && $gender=="Male") echo "checked";?>> Male
            <input type="radio" name="gender" value="Female" <?php if(isset($gender) && $gender=="Female") echo "checked";?>> Female
        </div>

        <div>
            <label>Course Selection:</label>
            <select name="course">
                <option value="none">-- Select Course --</option>
                <option value="Computer Science" <?php if(isset($course) && $course=="Computer Science") echo "selected";?>>Computer Science</option>
                <option value="Business" <?php if(isset($course) && $course=="Business") echo "selected";?>>Business</option>
                <option value="Engineering" <?php if(isset($course) && $course=="Engineering") echo "selected";?>>Engineering</option>
            </select>
        </div>

        <div>
            <input type="checkbox" name="terms"> I agree to the Terms & Conditions
        </div>

        <button type="submit" name="register">Register</button>
    </form>

</body>
</html>