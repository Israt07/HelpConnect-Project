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
    <title>About Us</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/header.css" type="text/css">
    <link rel="stylesheet" href="../../styles/footer.css" type="text/css">
    <link rel="stylesheet" href="../../styles/aboutUs.css" type="text/css">

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
                <div id='aboutus' class='aboutus'>About Us</div>
            </div>
            <div id='frame62' class='frame62'>
                <div id='missionGoal' class='missionGoal' onClick="location.href='missionGoal.php'">Mission & Goal</div>
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
                <a href="#" style="color: black; text-decoration: none;">About Us</a>
            </div>

            <!--About us-->
            <div id='aboutUs3' class='aboutUs3'><strong>About Us</strong></div>
            <div id='frame8' class='frame8' style="top: 50px !important;">
                <!--About us-->
                <div id='text2' class='text2'>
                    Who Are We?
                </div>
                <div id='text3' class='text3'>
                    Founded in 2020, HelpConnect is a organisation that helps senior citizens, caretakers, guardians and volunteers
                    to communicate with each other. First started as an offline facility and with only 30 staffs. Now, HelpConnect have
                    widen their platform to online service. In addition to the expansion, HelpConnect has now crossed over with <span><a href="https://rumahkasih.org/">Rumah Kasih</a></span>, another organization with a similar mission.
                </div>

                <div class="rectangle">
                    <img src="../../assets/about-us-volunteer.png" alt="volunteer" height="200px" width="900px">
                </div>
                <div id='text5' class='text5'>
                    Why HelpConnect?
                </div>
                <div id='text4' class='text4'>
                    HelpConnect is a web application that helps senior citizens, caretakers, and guardians find volunteer
                    or paid helpers. The platform allows users to post requests for help with tasks such as transportation,
                    companionship, and homemaking. Volunteers and paid helpers can then browse these requests and offer their
                    services. HelpConnect is a free service that is available to anyone in the United States.
                </div>
                <div id='rectangle' class='rectangle'></div>
            </div>
        </div>
    </div>

    <!--Footer-->
    <?php include('../authentication/footer.php') ?>

</body>

</html>