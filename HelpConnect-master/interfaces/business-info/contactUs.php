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
    <title>Contact Us</title>
    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/header.css" type="text/css">
    <link rel="stylesheet" href="../../styles/footer.css" type="text/css">
    <link rel="stylesheet" href="../../styles/contactUs.css">

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
                <div id='missionGoal' class='missionGoal' onClick="location.href='missionGoal.php'">Mission & Goal</div>
            </div>
            <div id='frame63' class='frame63'>
                <div id='contactus' class='contactus'>Contact Us</div>
            </div>
        </div>

        <div id='frame7' class='frame7'>
            <!--Breadcrumbs-->
            <div class="breadcrumbs">
                <img id='icon' class='icon' src="../../assets/home-icon.svg" style="background-color: transparent;">
                <strong> / </strong>
                <a href="#" style="color: black; text-decoration: none;">Contact Us</a>
            </div>

            <div id='contactUs3' class='contactUs3'><strong>Contact Us</strong></div><br><br><br>

            <!--Contact us-->
            <div id='frame8' class='frame8'>
                <div id='frame81' class='frame81'>
                    <img id='location' class='location' src="../../assets/location.png"></img>
                    <div id='frame811' class='frame811'>
                        <div id='address' class='address'>Address</div>
                        <div id=fullAddress class="fullAddress">
                            Ground Floor, No.1026,
                            Jalan Perhentian Bas, Pulau Sebang
                            73000, Melaka, Malaysia
                        </div>
                        <div id='number2' class='number2'>
                            +606-4412561
                        </div>
                    </div>
                </div>

                <div id='frame82' class='frame82'>
                    <img id='phone2' class='phone2' src="../../assets/phone.png" /></img>
                    <div id='frame821' class='frame821'>
                        <div id='phone3' class='phone3'>Phone</div>
                        <div id='number' class='number'>
                            +6010-87567803
                        </div>
                    </div>
                </div>

                <div id='frame83' class='frame83'>
                    <img id='email' class='email' src="../../assets/email.png"></img>
                    <div id='frame831' class='frame831'>
                        <div id='email2' class='email2'>Email</div>
                        <div id='email3' class='email3'>
                            customerservice@helpconnect.com
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