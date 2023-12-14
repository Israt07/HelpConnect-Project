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

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Service</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/header.css" type="text/css">
    <link rel="stylesheet" href="../../styles/footer.css" type="text/css">
    <link rel="stylesheet" href="../../styles/discover.css" type="text/css">

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
                <a href="#" class="active">Service</a>
                <a href="../../interfaces/community/community.php">Community</a>
                <a href="../../interfaces/profile/user-profile.php">Profile</a>
            </nav>

            <button class="avatar-button fas" type="button" onclick="toggleAvatar()">
                <img src="../../assets/profile-icon.svg" alt="profile" class="avatar-text">
            </button>

            <!-- User Details Box -->
            <div id="userDetails" class="user-box">
                <p class="role" style="text-transform: capitalize;"><?php echo $this_user_role; ?></p>
                <p><strong>Username: </strong><?php echo $name; ?></p>
                <p><strong>Email: </strong><?php echo $email; ?></p>
                <button><a href="../authentication/logout.php" style="text-decoration: none; color: white;">Logout</a></button>

            </div>
        </div>

    </header>

    <div class="discover-container">

        <!-- side bar -->
        <div class="sidebar">
            <a href="#" class="active">Discover</a>
            <a href="request.php">Service Request</a>
            <a href="history.php">History</a>
        </div>

        <!-- discover -->
        <div class="discover" style="height: 100%; min-height: 83vh;">

            <!-- breadcrumb -->
            <div class="breadcrumb">
                <a href="#">Service</a>
                <strong> / </strong>
                <a href="#">Discover</a>
            </div>

            <!-- title-->
            <h1>Discover</h1>

            <div class="content">

                <!-- profile-container -->
                <div class="profile-container">

                    <?php
                    // calculate age
                    function calculateAge($dateString)
                    {
                        $today = new DateTime();
                        $birthDate = new DateTime($dateString);
                        $age = $today->diff($birthDate)->y;
                        return $age;
                    }

                    // connect db
                    include('../../database/connect.php');

                    // fetch user data
                    $users = array();

                    if ($this_user_role === "elderly") {
                        $sql = "SELECT * FROM user WHERE role = 'volunteer'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $user = array();
                                $user['userID'] = $row['userID'];
                                $user['name'] = $row['firstname'] . ' ' . $row['lastname'];
                                $user['birthdate'] = $row['birthdate'];
                                $user['age'] = calculateAge($row['birthdate']);
                                $user['gender'] = $row['gender'];
                                $users[] = $user;
                            }
                        }
                    }

                    if ($this_user_role === "volunteer") {
                        $sql = "SELECT * FROM user WHERE role = 'elderly'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $user = array();
                                $user['userID'] = $row['userID'];
                                $user['name'] = $row['firstname'] . ' ' . $row['lastname'];
                                $user['birthdate'] = $row['birthdate'];
                                $user['age'] = calculateAge($row['birthdate']);
                                $user['gender'] = $row['gender'];
                                $users[] = $user; 
                            }
                        }
                    }

                    ?>

                    <?php
                    // Display user profiles
                    foreach ($users as $user) {
                        $userID = $user['userID'];
                        $name = $user['name'];
                        $birthdate = $user['birthdate'];
                        $age = $user['age'];
                        $gender = $user['gender'];
                    ?>
                        <!-- profile -->
                        <div class="profile" style="min-width: 200px; background-color: white; justify-content: space-between;">
                            <div>
                                <div class="profile-block">
                                    <h3>Name: </h3>
                                    <h4><?php echo $name; ?></h4>
                                </div>
                                <div class="profile-block">
                                    <h3>Age: </h3>
                                    <h4><?php echo $age; ?></h4>
                                </div>
                                <div class="profile-block">
                                    <h3>Gender: </h3>
                                    <h4><?php echo $gender; ?></h4>
                                </div>

                                <div class="profile-block">
                                    <h3>Service: </h3>
                                </div>

                                <!-- retrieve service -->
                                <?php

                                // connect db
                                include('../../database/connect.php');

                                // fetch data
                                $serviceQuery = "SELECT companionship,counseling,transportation,respite_care,medical_care,hospice_care,daily_living_assistance FROM service WHERE userID ='$userID'";

                                $serviceResult = mysqli_query($conn, $serviceQuery);

                                echo '<div class="service-container">';
                                $colors = array('#FAD2E1', '#FFD8B5', '#FFEFD1', '#D4F1F4', '#B5EAD7', '#F3D6E4', '#C7E9FF');
                                shuffle($colors);

                                while ($row = mysqli_fetch_assoc($serviceResult)) {
                                    foreach ($row as $columnName => $value) {
                                        if ($value == 1) {
                                            $randomColor = array_shift($colors);
                                            echo '<p style="background-color: ' . $randomColor . ';">';
                                            echo $columnName;
                                            echo '</p>';
                                        }
                                    }
                                }
                                echo '</div>';

                                echo '</div>';
                                echo '<a class="view-profile" href="discover-profile.php?userID=' . $userID . '">View Profile</a>';
                                ?>
                            </div>

                        <?php
                    }

                    // close connection
                    mysqli_free_result($result);
                    mysqli_close($conn);
                        ?>
                        </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include('../authentication/footer.php') ?>
</body>

</html>