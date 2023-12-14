<?php

include('../../database/connect.php');

session_start();

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$this_user_role = $_SESSION['role'];
$name = $_SESSION['name'];

?>

<?php
// connect db
include('../../database/connect.php');

// retrieve user data based on the user ID from the URL parameter
if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    // Query to retrieve user data
    $query = "SELECT * FROM user WHERE userID = '$userID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username = $row['firstname'] . ' ' . $row['lastname'];
            $birthdate = $row['birthdate'];
            $gender = $row['gender'];
            $location = $row['city'] . ', ' . $row['state'];
            $skills = $row['skill'];
        } else {
            echo "User not found";
        }

        // Free the result set
        mysqli_free_result($result);
    } else {
        // Query execution failed
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['follow'])) {
    $followerID = mysqli_real_escape_string($conn, $_POST['followerID']);
    $userID = mysqli_real_escape_string($conn, $_POST['userID']);

    // Check if the pair already exists in the follow table
    $checkQuery = "SELECT * FROM follower WHERE followerID = '$followerID' AND userID = '$userID'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('You are already following this user.');</script>";
    } else {
        $insertQuery = "INSERT INTO follower (followerID, userID) VALUES ('$followerID', '$userID')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo "<script>alert('You are now following this user.'); window.location.href = 'discover.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
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
    <link rel="stylesheet" href="../../styles/profile.css" type="text/css">

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
                <a href="../../interfaces/profile/userProfile.php">Profile</a>
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

    <div class="profile-container" style="min-height: 86vh;">

        <!-- side bar -->
        <div class="sidebar">
            <a href="discover.php" class="active">Discover</a>
            <a href="request.php">Service Request</a>
            <a href="history.php">History</a>
        </div>

        <!-- profile -->
        <div class="profile">

            <!-- back button -->
            <a href="discover.php" class="back-button">
                <span>
                    < Back</span>
            </a>

            <!-- breadcrumb -->
            <div class="breadcrumb">
                <a href="discover.php">Service</a>
                <strong> / </strong>
                <a href="discover.php">Discover</a>
                <strong> / </strong>
                <a href="#"><strong><?php echo $username; ?></strong></a>
            </div>

            <div class="content">

                <!-- basic info -->
                <div class="basic-info">

                    <!-- info -->
                    <div class="info">

                        <div class="name">
                            <!-- title-->
                            <h1><?php echo $username; ?></h1>

                        </div>

                        <h3><strong>Age: </strong> <?php echo $birthdate; ?></h3>
                        <h3><strong>Gender: </strong> <?php echo $gender; ?></h3>
                        <h3><strong>Location: </strong><?php echo $location; ?></h3>
                        <h3><strong>Skills/Specialty: </strong><?php echo $skills; ?></h3>

                        <!-- service list -->
                        <div class="service-list">
                            <h3><strong>Service Offered: </strong></h3>

                            <!-- retrieve service -->
                            <?php

                            // connect db
                            include('../../database/connect.php');

                            // fetch data
                            $serviceQuery = "SELECT companionship,counseling,transportation,respite_care,medical_care,hospice_care,daily_living_assistance FROM service WHERE userID =$userID";

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
                            ?>
                        </div>

                    </div>

                    <!-- img, btn -->
                    <div class="action-btn">
                        <?php
                        // Check if the user is already being followed
                        $followQuery = "SELECT * FROM follower WHERE followerID = '$id' AND userID = '$userID'";
                        $followResult = mysqli_query($conn, $followQuery);

                        if ($followResult && mysqli_num_rows($followResult) > 0) {
                            echo '<button disabled style="background-color: #D9D9D9; color: gray;">Follow</button>';
                        } else {
                            echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
                            echo '<input type="hidden" name="followerID" value="' . $id . '">';
                            echo '<input type="hidden" name="userID" value="' . $userID . '">';
                            echo '<button type="submit" name="follow" style="cursor: pointer; background-color: var(--secondary-color); color: black; cursor: pointer;">Follow</button>';
                            echo '</form>';
                        }
                        ?>
                        <?php if ($this_user_role !== "volunteer") : ?>
                            <a href="request-create.php?userID=<?php echo $userID; ?>">
                                <button class="book">Book Service</button>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>

                <!-- service experience -->
                <div class="experience">
                    <h3>Recent Service Experience:</h3>

                    <!-- experience table-->
                    <table class="experience-table">
                        <thead class="table-head">
                            <tr>
                                <th>Date</th>
                                <th>Duration (hours)</th>
                                <th>Service Involved</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">

                            <?php
                            // connect db
                            include('../../database/connect.php');

                            if ($this_user_role === "elderly") {
                                // fetch data
                                $sql = "SELECT * FROM service_request WHERE volunteer_involved = '$userID' AND status = 'Accepted'";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>';
                                        $serviceDatetime = date('Y-m-d h:i A', strtotime($row['service_datetime']));
                                        echo '<td>' . $serviceDatetime . '</td>';
                                        echo '<td>' . $row['duration'] . '</td>';
                                        $requestID = $row['requestID'];

                                        // fetch service involved
                                        $sql2 = "SELECT companionship,counseling,transportation,respite_care,medical_care,hospice_care,daily_living_assistance FROM service WHERE requestID = '$requestID'";
                                        $result2 = mysqli_query($conn, $sql2);

                                        if (mysqli_num_rows($result2) > 0) {

                                            echo '<td>';
                                            echo '<div class="service-expereince">';
                                            $colors = array('#FAD2E1', '#FFD8B5', '#FFEFD1', '#D4F1F4', '#B5EAD7', '#F3D6E4', '#C7E9FF');
                                            shuffle($colors);

                                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                                foreach ($row2 as $columnName => $value) {
                                                    if ($value == 1) {
                                                        $randomColor = array_shift($colors);
                                                        echo '<p style="background-color: ' . $randomColor . ';">';
                                                        echo $columnName;
                                                        echo '</p>';
                                                    }
                                                }
                                            }
                                            echo '</div>';
                                            echo '</td>';
                                        } else {
                                            echo '<tr><td colspan="7">No data available</td></tr>';
                                        }
                                    }
                                } else {
                                    echo '<tr><td colspan="7">No data available</td></tr>';
                                }
                            }

                            if ($this_user_role === "volunteer") {
                                // fetch data
                                $sql = "SELECT * FROM service_request WHERE elderly_involved = '$userID' AND status = 'Accepted'";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>';
                                        $serviceDatetime = date('Y-m-d h:i A', strtotime($row['service_datetime']));
                                        echo '<td>' . $serviceDatetime . '</td>';
                                        echo '<td>' . $row['duration'] . '</td>';
                                        $requestID = $row['requestID'];

                                        // fetch service involved
                                        $sql2 = "SELECT companionship,counseling,transportation,respite_care,medical_care,hospice_care,daily_living_assistance FROM service WHERE requestID = '$requestID'";
                                        $result2 = mysqli_query($conn, $sql2);

                                        if (mysqli_num_rows($result2) > 0) {

                                            echo '<td>';
                                            echo '<div class="service-expereince">';
                                            $colors = array('#FAD2E1', '#FFD8B5', '#FFEFD1', '#D4F1F4', '#B5EAD7', '#F3D6E4', '#C7E9FF');
                                            shuffle($colors);

                                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                                foreach ($row2 as $columnName => $value) {
                                                    if ($value == 1) {
                                                        $randomColor = array_shift($colors);
                                                        echo '<p style="background-color: ' . $randomColor . ';">';
                                                        echo $columnName;
                                                        echo '</p>';
                                                    }
                                                }
                                            }
                                            echo '</div>';
                                            echo '</td>';
                                        } else {
                                            echo '<tr><td colspan="7">No data available</td></tr>';
                                        }
                                    }
                                } else {
                                    echo '<tr><td colspan="7">No data available</td></tr>';
                                }
                            }


                            // close connection
                            mysqli_free_result($result);
                            mysqli_close($conn);
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('../authentication/footer.php') ?>

</body>


</html>