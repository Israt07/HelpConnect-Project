<!DOCTYPE html>
<html lang="en">

<head>
    <title>Help Connect</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/header.css" type="text/css">

</head>

<body>
    <header>
        <div class="header">
            <img src="../../assets/logo.svg" alt="logo" height="55px">

            <!-- menu -->
            <nav class="menu">
                <a href="../business-info/aboutUs.php">Home</a>
                <a href="#" class="active">Service</a>
                <a href="">Community</a>
                <a href="">Profile</a>
            </nav>

            <button class="avatar-button fas" type="button" onclick="toggleAvatar()">
                <span class="avatar-text">DJ</span>
            </button>

            <!-- User Details Box -->
            <div id="userDetails" class="user-box">
                <p class="role">Elderly</p>
                <p><strong>Username: </strong> John Doe</p>
                <p><strong>Email: </strong> johndoe@example.com</p>
                <button><a href="./authentication/logout.php"></a>Logout</button>
            </div>
        </div>

    </header>
</body>

<script>
    function toggleAvatar() {
        var userDetails = document.getElementById("userDetails");
        userDetails.style.display = (userDetails.style.display === "block") ? "none" : "block";
    }
</script>

</html>