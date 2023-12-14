<?php

include('../../database/connect.php');
session_start();

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select_users = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {

        $row = mysqli_fetch_assoc($select_users);

        $_SESSION['id'] = $row['userID'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['name'] = $row['firstname'] . ' ' . $row['lastname'];

        header('Location: ../../interfaces/business-info/aboutUs.php');
    } else {
        $message = 'Incorrect email or password!';
        echo "<script>alert('$message');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/header.css" type="text/css">
    <link rel="stylesheet" href="../../styles/footer.css" type="text/css">
    <link rel="stylesheet" href="../../styles/login.css" type="text/css">

</head>

<body class="login-form">

    <!-- left -> picture -->
    <div class="picture">
        <img src="../../assets/auth-picture.png" alt="hand-pic" height="55px">
    </div>

    <!-- right -> form -->
    <div class="form-container">

        <!-- logo -->
        <img src="../../assets/logo.svg" alt="logo" height="65px">

        <form action="" method="post">
            <h3>LOG IN</h3>
            <p>Do not have an account? <a href="./register.php">Sign Up</a></p>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required><br>

            <div class="button">
                <button type="submit" name="submit">Log In</button>
            </div>
        </form>

    </div>

</body>

</html>