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
    <link rel="stylesheet" href="../../styles/request.css" type="text/css">

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


    <div class="request-container" style="height: 100%; min-height: 86vh;">

        <!-- side bar -->
        <div class="sidebar">
            <a href="discover.php">Discover</a>
            <a href="#" class="active">Service Request</a>
            <a href="history.php">History</a>
        </div>

        <!-- request -->
        <div class="request">

            <!-- breadcrumb -->
            <div class="breadcrumb">
                <a href="discover.php">Service</a>
                <strong> / </strong>
                <a href="#">Service Request</a>
            </div>

            <!-- title-->
            <h1>Service Request</h1>

            <div class="content">

                <!-- request-container -->
                <div class="table-container">

                    <?php

                    // connect db
                    include('../../database/connect.php');

                    if ($this_user_role === "volunteer") {

                        // request table

                        echo '<table class="request-table">';
                        echo '<thead class="table-head">';
                        echo '<tr>';
                        echo '<th>Request ID</th>';
                        echo '<th>Date</th>';
                        echo ' <th>Duration (hours)</th>';
                        echo '<th>Elderly Name</th>';
                        echo '<th>Service Involved</th>';
                        echo '<th>Status</th>';
                        echo '<th>Action</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody class="table-body">';

                        // fetch data
                        $sql = "SELECT * FROM service_request WHERE volunteer_involved ='$id' AND service_datetime > CURDATE() AND status <> 'Rejected'";
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
                                $status = $row['status'];
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

                                echo '<td>' . $row['status'] . '</td>';
                                echo '<td>';
                                echo '<div class="table-button">';
                                echo '<form method="post" action="">';
                                echo '<input type="hidden" name="requestID" value="' . $requestID . '">';
                                if ($status === "Rejected" || $status === "Accepted") {
                                    echo '<button type="submit" name="rejectBtn" style="margin-right: 10px; background-color: #D9D9D9; color: gray; cursor: not-allowed; padding: 3px 10px;" disabled>Reject</button>';
                                    echo '<button type="submit" name="acceptBtn" style="background-color: #D9D9D9; color: gray; cursor: not-allowed; padding: 3px 10px;" disabled>Accept</button>';
                                } else {
                                    echo '<button type="submit" name="rejectBtn" style="margin-right: 10px; background-color: red; padding: 3px 10px;">Reject</button>';
                                    echo '<button type="submit" name="acceptBtn" style="background-color: var(--primary-color); padding: 3px 10px;">Accept</button>';
                                }
                                echo '</form>';
                                echo '</div>';
                                echo '</td>';
                                echo '</tr>';

                                // when "Reject" button click
                                if (isset($_POST['rejectBtn'])) {
                                    $requestID = $_POST['requestID'];

                                    // Update status to "Rejected" in the service_request table
                                    $updateQuery = "UPDATE service_request SET status = 'Rejected' WHERE requestID = '$requestID'";
                                    $updateResult = mysqli_query($conn, $updateQuery);

                                    if ($updateResult) {
                                        header("Location: " . $_SERVER['PHP_SELF']);
                                        exit();
                                    } else {
                                        echo "Error updating status: " . mysqli_error($conn);
                                    }
                                }

                                // when "Accept" button click
                                if (isset($_POST['acceptBtn'])) {
                                    $requestID = $_POST['requestID'];

                                    // Update status to "Accepted" in the service_request table
                                    $updateQuery = "UPDATE service_request SET status = 'Accepted' WHERE requestID = '$requestID'";
                                    $updateResult = mysqli_query($conn, $updateQuery);

                                    if ($updateResult) {
                                        header("Location: " . $_SERVER['PHP_SELF']);
                                        exit();
                                    } else {
                                        echo "Error updating status: " . mysqli_error($conn);
                                    }
                                }
                            }
                        } else {
                            echo '<tr><td colspan="7">No data available</td></tr>';
                        }
                    }

                    if ($this_user_role === "elderly") {

                        // request table
                        echo '<table class="request-table">';
                        echo '<thead class="table-head">';
                        echo '<tr>';
                        echo '<th>Request ID</th>';
                        echo '<th>Date</th>';
                        echo ' <th>Duration (hours)</th>';
                        echo '<th>Volunteer Name</th>';
                        echo '<th>Service Involved</th>';
                        echo '<th>Status</th>';
                        echo '<th>Action</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody class="table-body">';

                        // fetch data
                        $sql = "SELECT * FROM service_request WHERE elderly_involved ='$id' AND service_datetime > CURDATE() AND status <> 'Rejected'";
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

                                echo '<td>' . $row['status'] . '</td>';
                                echo '<td>';
                                echo '<div class="table-button">';
                                echo '<button style="background-color: transparent;"><a href="request-edit.php?requestID=' . $requestID . '"><img src="../../assets/icon-edit.svg" alt="Edit" /></a></button>';
                                echo '<form method="post" action="">';
                                echo '<button type="submit" name="deleteBtn" style="background-color: transparent;"><img src="../../assets/icon-delete.svg" alt="Delete" /></button>';
                                echo '</form>';
                                echo '</div>';
                                echo '</td>';
                                echo '</tr>';

                                // delete request
                                if (isset($_POST['deleteBtn'])) {

                                    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");


                                    // delete service_involved
                                    $deleteServiceQuery = "DELETE FROM service WHERE requestID = '$requestID'";
                                    $deleteServiceResult = mysqli_query($conn, $deleteServiceQuery);

                                    if ($deleteServiceResult) {

                                        // delete service request
                                        $deleteQuery = "DELETE FROM service_request WHERE requestID = '$requestID'";
                                        $deleteResult = mysqli_query($conn, $deleteQuery);

                                        if ($deleteResult) {

                                            header("Location: " . $_SERVER['PHP_SELF']);
                                            exit();
                                        } else {
                                            echo "Error deleting data row: " . mysqli_error($conn);
                                        }
                                    } else {
                                        echo "Error deleting data row: " . mysqli_error($conn);
                                    }

                                    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
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