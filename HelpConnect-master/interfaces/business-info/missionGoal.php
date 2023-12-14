<?php

include('../../database/connect.php');

session_start();

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];
$name = $_SESSION['name'];

?>

<!DOCTYPE html>
<html>

<head>
    <title>Mission & Goal</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/header.css" type="text/css">
    <link rel="stylesheet" href="../../styles/footer.css" type="text/css">
    <link rel="stylesheet" href="../../styles/missionGoal.css" type="text/css">

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
                <a href="#" class="active">Home</a>
                <a href="../../interfaces/service/discover.php">Service</a>
                <a href="../../interfaces/community/community.php">Community</a>
                <a href="../../interfaces/profile/user-profile.php">Profile</a>
            </nav>

            <button class="avatar-button fas" type="button" onclick="toggleAvatar()">
                <img src="../../assets/profile-icon.svg" alt="profile" class="avatar-text">
            </button>

            <!-- User Details Box -->
            <div id="userDetails" class="user-box" style="z-index: 999;">
                <p class="role" style="text-transform: capitalize;"><?php echo $role; ?></p>
                <p><strong>Username: </strong><?php echo $name; ?></p>
                <p><strong>Email: </strong><?php echo $email; ?></p>
                <button><a href="../authentication/logout.php" style="text-decoration: none; color: white;">Logout</a></button>
            </div>
        </div>

    </header>

    <!--Side Nav-->
    <div id='frame5' class='frame5'>
        <div id='frame6' class='frame6'>
            <div id='frame61' class='frame61'>
                <div id='aboutus' class='aboutus' onClick="location.href='aboutUs.php'">About Us</div>
            </div>
            <div id='frame62' class='frame62'>
                <div id='missionGoal' class='missionGoal'>Mission & Goal</div>
            </div>
            <div id='frame63' class='frame63'>
                <div id='contactus' class='contactus' onClick="location.href='contactUs.php'">Contact Us</div>
            </div>
        </div>

        <div id='frame7' class='frame7'>
            <!--Breadcrumbs-->
            <div class="breadcrumbs">
                <img id='icon' class='icon' src="../../assets/home-icon.svg" style="background-color: transparent;">
                <strong> / </strong>
                <a href="#" style="color: black; text-decoration: none;">Mission & Goal</a>
            </div>

            <div id='missionGoal3' class='missionGoal3'><strong>Mission & Goal</strong></div>

            <div id='frame8' class='frame8'>
                <div id='frame81' class='frame81'>
                    <div id='frame811' class='frame811'>
                        <div id='title' class='title' style="color: var(--primary-color);">Vision</div>
                        <div id='text1' class='text1'>
                            To create a connected and compassionate community where guardians,
                            elderly individuals, and caretakers can easily find volunteers to
                            provide help, companionship, and support.
                        </div>
                    </div>
                </div>
                <div id='frame82' class='frame82'>
                    <div id='frame821' class='frame821'>
                        <div id='title2' class='title2' style="color: var(--primary-color);">Mission</div>
                        <div id='text2' class='text2'>
                            Our mission is to establish HelpConnect as a reliable and user-friendly platform
                            that bridges the gap between those in need and compassionate volunteers. We aim to
                            facilitate meaningful connections, improve the well-being of guardians, elderly
                            individuals, and caretakers, and foster a sense of purpose and fulfillment through
                            acts of kindness and companionship.
                        </div>
                    </div>
                </div>
                <div id='frame83' class='frame83'>
                    <div id='frame831' class='frame831'>
                        <div id='title3' class='title3' style="color: var(--primary-color);">Goals</div>
                        <div id='text3' class='text3'>
                            Connect Guardians, Elderly Individuals, and Caretakers: Our primary goal is to connect
                            guardians, elderly individuals, and caretakers with dedicated volunteers who can
                            provide assistance, company, and support. We strive to make the process seamless,
                            efficient, and personalized to meet the unique needs and preferences of each
                            individual.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Footer-->
    <div style="z-index: 999; position: relative;">
        <?php include('../authentication/footer.php') ?>
    </div>

</body>

</html>