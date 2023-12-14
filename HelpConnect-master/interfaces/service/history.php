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
    <link rel="stylesheet" href="../../styles/history.css" type="text/css">

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

    <div class="history-container">

        <!-- side bar -->
        <div class="sidebar">
            <a href="discover.php">Discover</a>
            <a href="request.php">Service Request</a>
            <a href="#" class="active">History</a>
        </div>

        <!-- history -->
        <div class="history" style="height: 100%; min-height: 83vh;">

            <!-- breadcrumb -->
            <div class="breadcrumb">
                <a href="discover.php">Service</a>
                <strong> / </strong>
                <a href="#">History</a>
            </div>

            <!-- title-->
            <h1>History</h1>

            <div class="content">

                <div class="table-container">

                    <?php
                    // connect db
                    include('../../database/connect.php');

                    if ($this_user_role === "volunteer") {

                        // history-container
                        echo '<table class="history-table">';
                        echo '<thead class="table-head">';
                        echo '<tr>';
                        echo '<th>Request ID</th>';
                        echo '<th>Date</th>';
                        echo ' <th>Duration (hours)</th>';
                        echo '<th>Elderly Name</th>';
                        echo '<th>Service Involved</th>';
                        echo '<th>Status</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody class="table-body">';

                        // fetch data
                        $sql = "SELECT * FROM service_request WHERE volunteer_involved ='$id' AND (service_datetime < CURDATE() OR status = 'Rejected')";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {

                                echo '<tr>';
                                echo '<td>' . $row['requestID'] . '</td>';
                                $serviceDatetime = date('Y-m-d h:i A', strtotime($row['service_datetime']));
                                echo '<td>' . $serviceDatetime . '</td>';
                                echo '<td>' . $row['duration'] . '</td>';

                                // get volunteer name
                                $elderly_involved = $row['elderly_involved'];
                                $sql3 = "SELECT * FROM user WHERE userID = '$elderly_involved'";
                                $result3 = mysqli_query($conn, $sql3);

                                if (mysqli_num_rows($result3) > 0) {
                                    while ($row3 = mysqli_fetch_assoc($result3)) {
                                        echo '<td>' . $row3['firstname'] . ' '. $row3['lastname'] . '</td>';
                                    }
                                } else {
                                    echo '<tr><td colspan="7">No data available</td></tr>';
                                }

                                // fetch service involved
                                $requestID = $row['requestID'];
                                $sql2 = "SELECT companionship,counseling,transportation,respite_care,medical_care,hospice_care,daily_living_assistance FROM service WHERE requestID = '$requestID'";
                                $result2 = mysqli_query($conn, $sql2);

                                if (mysqli_num_rows($result2) > 0) {

                                    echo '<td>';
                                    echo '<div class="service">';
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

                                echo '<td>' . $row['status'] . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="7">No data available</td></tr>';
                        }
                    }

                    if ($this_user_role === "elderly") {

                        // history-container
                        echo '<table class="history-table">';
                        echo '<thead class="table-head">';
                        echo '<tr>';
                        echo '<th>Request ID</th>';
                        echo '<th>Date</th>';
                        echo ' <th>Duration (hours)</th>';
                        echo '<th>Volunteer Name</th>';
                        echo '<th>Service Involved</th>';
                        echo '<th>Status</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody class="table-body">';

                        // fetch data
                        $sql = "SELECT * FROM service_request WHERE elderly_involved ='$id' AND (service_datetime < CURDATE() OR status = 'Rejected')";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {

                                echo '<tr>';
                                echo '<td>' . $row['requestID'] . '</td>';
                                $serviceDatetime = date('Y-m-d h:i A', strtotime($row['service_datetime']));
                                echo '<td>' . $serviceDatetime . '</td>';
                                echo '<td>' . $row['duration'] . '</td>';

                                // get volunteer name
                                $volunteer_involved = $row['volunteer_involved'];
                                $sql3 = "SELECT * FROM user WHERE userID = '$volunteer_involved'";
                                $result3 = mysqli_query($conn, $sql3);

                                if (mysqli_num_rows($result3) > 0) {
                                    while ($row3 = mysqli_fetch_assoc($result3)) {
                                        echo '<td>' . $row3['firstname'] . '</td>';
                                    }
                                } else {
                                    echo '<tr><td colspan="7">No data available</td></tr>';
                                }

                                // fetch service involved
                                $requestID = $row['requestID'];
                                $sql2 = "SELECT companionship,counseling,transportation,respite_care,medical_care,hospice_care,daily_living_assistance FROM service WHERE requestID = '$requestID'";
                                $result2 = mysqli_query($conn, $sql2);

                                if (mysqli_num_rows($result2) > 0) {

                                    echo '<td>';
                                    echo '<div class="service">';
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

                                echo '<td>' . $row['status'] . '</td>';
                                echo '</tr>';
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