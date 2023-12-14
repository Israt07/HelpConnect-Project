<?php

include('../../database/connect.php');

session_start();

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$this_user_role = $_SESSION['role'];
$name = $_SESSION['name'];

if (!isset($id)) {
    header('location:../authentication/login.php');
}

?>

<?php
// connect db
include('../../database/connect.php');

// Query to retrieve user data
$query = "SELECT * FROM user WHERE userID = '$id'";
$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {

        // retrieve user data
        $row = mysqli_fetch_assoc($result);
        $password = $row['password'];
    } else {
        // No user found with the provided ID
        echo "User not found";
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Query execution failed
    echo "Error executing query: " . mysqli_error($conn);
}

// update password
if (isset($_POST['submit'])) {
    $oldPassword = mysqli_real_escape_string($conn, md5($_POST['oldPassword']));
    $newPassword = mysqli_real_escape_string($conn, md5($_POST['newPassword']));
    $confirmPassword = mysqli_real_escape_string($conn, md5($_POST['renewPassword']));

    if ($oldPassword === $password) {
        if ($newPassword === $confirmPassword) {
            $query = "UPDATE user SET 
            password='$newPassword'
            WHERE userID='$id'";

            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Data updated successfully!');</script>";
            } else {
                echo "Error updating data: " . mysqli_error($conn);
            }
        } else {
            // new password and confirm password don't match
            echo "<script>alert('New password and confirm password do not match.');</script>";
        }
    } else {
        // old password is incorrect
        echo "<script>alert('Old password is incorrect.');</script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Service</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/header.css" type="text/css">
    <link rel="stylesheet" href="../../styles/footer.css" type="text/css">
    <link rel="stylesheet" href="../../styles/privacy-setting.css" type="text/css">

    <script>
        function toggleAvatar() {
            var userDetails = document.getElementById("userDetails");
            userDetails.style.display = (userDetails.style.display === "block") ? "none" : "block";
        }
    </script>
</head>

<body>

    <!-- header -->
    <header>
        <div class="header">
            <img src="../../assets/logo.svg" alt="logo" height="55px">

            <!-- menu -->
            <nav class="menu">
                <a href="../../interfaces/business-info/aboutUs.php">Home</a>
                <a href="../../interfaces/service/discover.php">Service</a>
                <a href="../../interfaces/community/community.php">Community</a>
                <a href="#" class="active">Profile</a>
            </nav>

            <button class="avatar-button fas" type="button" onclick="toggleAvatar()">
                <img src="../../assets/profile-icon.svg" alt="profile" class="avatar-text">
            </button>

            <!-- User Details Box -->
            <div id="userDetails" class="user-box">
                <p class="role" style="text-transform: capitalize;">
                    <?php echo $this_user_role; ?>
                </p>
                <p><strong>Username: </strong>
                    <?php echo $name; ?>
                </p>
                <p><strong>Email: </strong>
                    <?php echo $email; ?>
                </p>
                <button><a href="../authentication/logout.php" style="text-decoration: none; color: white;">Logout</a></button>

            </div>
        </div>

    </header>

    <div class="profile-container">

        <!-- side bar -->
        <div class="sidebar">
            <a href="user-profile.php">Information Setting</a>
            <a href="privacy-setting.php" class="active">Privacy Setting</a>
        </div>

        <!-- profile -->
        <div class="profile">


            <!-- breadcrumb -->
            <div class="breadcrumb">
                <a href="user-profile.php">Profile</a>
                <strong> / </strong>
                <a href="privacy-setting.php">Privacy Setting</a>
            </div>

            <!-- title-->
            <h1>Information Setting</h1>

            <div class="content">

                <form id="updateForm" action="" method="post">

                    <h3>Change Password</h3>

                    <p class="input-label">Old Password:</p>
                    <input type="password" name="oldPassword" placeholder="Old Password" required class="box">
                    <p class="input-label">New Password:</p>
                    <input type="password" name="newPassword" placeholder="New Password" required class="box">
                    <p class="input-label">Confirm New Password:</p>
                    <input type="password" name="renewPassword" placeholder="Confirm New Password" required class="box">

                    <div class="button">
                        <button type="submit" id="elderly-submit" name="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('../authentication/footer.php') ?>

</body>

</html>