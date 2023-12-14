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

// retrieve request based on the ID from the URL parameter
if (isset($_GET['requestID'])) {
    $requestID = $_GET['requestID'];

    // retrieve request data
    $query = "SELECT * FROM service_request WHERE requestID = '$requestID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);
            $elderlyID = $id;
            $volunteerID = $row['volunteer_involved'];
            $service_datetime = $row['service_datetime'];
            $duration = $row['duration'];
            $description = $row['description'];

            // get user name
            $query = "SELECT * FROM user WHERE userID = '$elderlyID'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {

                    $row = mysqli_fetch_assoc($result);
                    $user_firstname = $row['firstname'];
                    $user_lastname = $row['lastname'];
                } else {
                    echo "User not found";
                }
                mysqli_free_result($result);
            } else {
                echo "Error executing query: " . mysqli_error($conn);
            }

            // get volunteer name
            $query = "SELECT * FROM user WHERE userID = '$volunteerID'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {

                    $row = mysqli_fetch_assoc($result);
                    $volunteer_firstname = $row['firstname'];
                    $volunteer_lastname = $row['lastname'];
                } else {
                    echo "User not found";
                }
                mysqli_free_result($result);
            } else {
                echo "Error executing query: " . mysqli_error($conn);
            }

            // retrieve service involved
            $query = "SELECT * FROM service WHERE requestID = '$requestID'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {

                    $row = mysqli_fetch_assoc($result);
                    $companionship = $row['companionship'];
                    $counseling = $row['counseling'];
                    $transportation = $row['transportation'];
                    $respite_care = $row['respite_care'];
                    $medical_care = $row['medical_care'];
                    $hospice_care = $row['hospice_care'];
                    $daily_living_assistance = $row['daily_living_assistance'];
                } else {
                    echo "User not found";
                }

                mysqli_free_result($result);
            } else {
                echo "Error executing query: " . mysqli_error($conn);
            }
        } else {
            echo "User not found";
        }

    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}

// Check if submit button is clicked
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $companionship = isset($_POST['companionship']) ? 1 : 0;
    $counseling = isset($_POST['counseling']) ? 1 : 0;
    $transportation = isset($_POST['transportation']) ? 1 : 0;
    $respite_care = isset($_POST['respite_care']) ? 1 : 0;
    $medical_care = isset($_POST['medical_care']) ? 1 : 0;
    $hospice_care = isset($_POST['hospice_care']) ? 1 : 0;
    $daily_living_assistance = isset($_POST['daily_living_assistance']) ? 1 : 0;

    $date = $_POST["service_datetime"];
    $duration = $_POST["duration"];
    $description = $_POST["description"];

    // Update service request
    $updateServiceRequest = "UPDATE service_request 
                            SET service_datetime = '$date', duration = '$duration', description = '$description'
                            WHERE requestID = '$requestID'";

    if (mysqli_query($conn, $updateServiceRequest)) {

        // Update service involved
        $updateServiceInvolved = "UPDATE service
                                SET companionship = '$companionship', counseling = '$counseling', transportation = '$transportation' , 
                                respite_care = '$respite_care', medical_care = '$medical_care', hospice_care = '$hospice_care', daily_living_assistance = '$daily_living_assistance'
                                WHERE requestID = '$requestID'";

        if (mysqli_query($conn, $updateServiceInvolved)) {

            echo '<script>alert("Request updated.");</script>';
            echo '<script>window.location.href = "request.php";</script>';
            exit;
        } else {
            echo "Error storing service request: " . mysqli_error($conn);
        }
    } else {
        echo "Error storing service request: " . mysqli_error($conn);
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
    <link rel="stylesheet" href="../../styles/create.css" type="text/css">

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

    <div class="create-request-container">

        <!-- side bar -->
        <div class="sidebar">
            <a href="discover.php">Discover</a>
            <a href="request.php" class="active">Service Request</a>
            <a href="history.php">History</a>
        </div>

        <!-- create request -->
        <div class="create-request">

            <!-- back button -->
            <a href="request.php" class="back-button">
                <span>
                    < Back</span>
            </a>

            <!-- breadcrumb -->
            <div class="breadcrumb">
                <a href="discover.php">Service</a>
                <strong> / </strong>
                <a href="request.php">Service Request</a>
                <strong> / </strong>
                <a href="#">Edit Service Request</a>
            </div>

            <!-- title-->
            <h1>Edit Service Request</h1>

            <div class="content">

                <form id="serviceRequestForm" method="POST" oninput="toggleSubmitButton()">

                    <!-- request by -->
                    <label>Request by:</label><br>
                    <div class="by">
                        <input type="text" placeholder="<?php echo $user_firstname; ?>" disabled><br>
                        <input type="text" placeholder="<?php echo $user_lastname; ?>" disabled><br>
                    </div>

                    <!-- request to -->
                    <label>Request to:</label><br>
                    <div class="to">
                        <input type="text" placeholder="<?php echo $volunteer_firstname; ?>" disabled><br>
                        <input type="text" placeholder="<?php echo $volunteer_lastname; ?>" disabled><br>
                    </div>

                    <!-- date -->
                    <label for="service_datetime">Date:</label>
                    <input type="datetime-local" id="service_datetime" name="service_datetime" value="<?php echo $service_datetime; ?>" style="width: 95%; margin-left: 7px;">

                    <!-- duration -->
                    <label for="duration">Duration(hours): </label>
                    <input  type="number" id="duration" name="duration" value="<?php echo $duration; ?>" >

                    <!-- service type -->
                    <label for="service_involved ">Service Type: </label>
                    <div class="checkbox">
                        <input type="checkbox" id="companionship" name="companionship" value="1" <?php if ($companionship == 1) echo "checked"; ?>>
                        <label for="companionship">Companionship</label><br>

                        <input type="checkbox" id="daily_living_assistance" name="daily_living_assistance" value="1" <?php if ($daily_living_assistance == 1) echo "checked"; ?>>
                        <label for="daily_living_assistance">Daily Living Assistance</label><br>

                        <input type="checkbox" id="medical_care" name="medical_care" value="1" <?php if ($medical_care == 1) echo "checked"; ?>>
                        <label for="medical_care">Medical care</label><br>

                        <input type="checkbox" id="transportation" name="transportation" value="1" <?php if ($transportation == 1) echo "checked"; ?>>
                        <label for="transportation">Transportation</label><br>

                        <input type="checkbox" id="counseling" name="counseling" value="1" <?php if ($counseling == 1) echo "checked"; ?>>
                        <label for="counseling">Counseling</label><br>

                        <input type="checkbox" id="hospice_care" name="hospice_care" value="1" <?php if ($hospice_care == 1) echo "checked"; ?>>
                        <label for=" hospice_care">Hospice care</label><br>

                        <input type="checkbox" id="respite_care" name="respite_care" value="1" <?php if ($respite_care == 1) echo "checked"; ?>>
                        <label for="respite_care">Respite care</label><br>
                    </div>

                    <!-- decription -->
                    <label for="description">Description</label><br>
                    <textarea id="description" name="description" rows="4" cols="50"><?php echo $description; ?></textarea>
                    
                    <!-- btn -->
                    <div class="button">
                        <button type="submit" id="submitButton" class="send" form="serviceRequestForm" disabled>Save</button>
                        <button type="button" class="cancel" onclick="goBack()">Cancel</button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <?php include('../authentication/footer.php') ?>
</body>

<script>
    function goBack() {
        window.location.href = "request.php";
    }

    function toggleSubmitButton() {
        var submitButton = document.getElementById('submitButton');
        submitButton.disabled = false;

        var formInputs = document.querySelectorAll('#serviceRequestForm input, #serviceRequestForm textarea');
        for (var i = 0; i < formInputs.length; i++) {
            if (formInputs[i].defaultValue !== formInputs[i].value) {
                return;
            }
        }

        submitButton.disabled = true;
    }
</script>

</html>