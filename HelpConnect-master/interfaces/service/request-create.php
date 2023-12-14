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

// retrieve user data based on the user ID from the URL parameter
if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    // retrieve volunteer data
    $query = "SELECT * FROM user WHERE userID = '$userID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);
            $name = $row['firstname'] . ' ' . $row['lastname'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];

            // get user name
            $query = "SELECT * FROM user WHERE userID = '$id'";
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
    $createDate = date("Y-m-d");
    $duration = $_POST["duration"];
    $description = $_POST["description"];
    $status = 'In Process';

    // Create service request
    $createServiceRequest = "INSERT INTO service_request (elderly_involved, volunteer_involved, create_datetime, service_datetime, duration, description, status)
                    VALUES ('$id', '$userID', '$createDate', '$date', '$duration', '$description', '$status')";

    if (mysqli_query($conn, $createServiceRequest)) {

        $serviceRequestId = mysqli_insert_id($conn);

        // Create service involved
        $createServiceInvolved = "INSERT INTO service (companionship, counseling, transportation, respite_care, medical_care, hospice_care, daily_living_assistance, requestID)
    VALUES ('$companionship','$counseling','$transportation','$respite_care','$medical_care','$hospice_care','$daily_living_assistance','$serviceRequestId')";

        if (mysqli_query($conn, $createServiceInvolved)) {

            $serviceId = mysqli_insert_id($conn);

            // Update data in service_request table
            $updateServiceRequest = "UPDATE service_request SET service_involved = '$serviceId' WHERE requestID = '$serviceRequestId'";

            if (mysqli_query($conn, $updateServiceRequest)) {

                echo "Service request updated in the database.";
            } else {
                echo "Error updating service request: " . mysqli_error($conn);
            }

            echo '<script>alert("Request created.");</script>';
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
            <a href="discover.php" class="active">Discover</a>
            <a href="request.php">Service Request</a>
            <a href="history.php">History</a>
        </div>

        <!-- create request -->
        <div class="create-request">

            <!-- back button -->
            <a href="discover-profile.php?userID=<?php echo $userID; ?>" class="back-button">
                <span>
                    < Back</span>
            </a>

            <!-- breadcrumb -->
            <div class="breadcrumb">
                <a href="discover.php">Service</a>
                <strong> / </strong>
                <a href="discover.php">Discover</a>
                <strong> / </strong>
                <a href="discover-profile.php?userID=<?php echo $userID; ?>">
                    <?php echo $name; ?>
                </a>
                <strong> / </strong>
                <a href="#">Create Service Request</a>
            </div>

            <!-- title-->
            <h1>Create Service Request</h1>

            <div class="content">

                <form id="serviceRequestForm" method="POST" onsubmit="return validateForm()">

                    <!-- request by -->
                    <label>Request by:</label><br>
                    <div class="by">
                        <input type="text" placeholder="<?php echo $user_firstname; ?>" disabled><br>
                        <input type="text" placeholder="<?php echo $user_lastname; ?>" disabled><br>
                    </div>

                    <!-- request to -->
                    <label>Request to:</label><br>
                    <div class="to">
                        <input type="text" placeholder="<?php echo $firstname; ?>" disabled><br>
                        <input type="text" placeholder="<?php echo $lastname; ?>" disabled><br>
                    </div>

                    <!-- date -->
                    <label for="service_datetime">Date:</label>
                    <input type="datetime-local" id="service_datetime" name="service_datetime" placeholder="Date" style="width: 95%; margin-left: 7px;">

                    <!-- duration -->
                    <label for="duration">Duration(hours): </label>
                    <input type="number" id="duration" name="duration" placeholder="Duration">

                    <!-- service type -->
                    <label for="service_involved ">Service Type: </label>
                    <div class="checkbox">
                        <input type="checkbox" id="companionship" name="companionship" value="1">
                        <label for="companionship">Companionship</label><br>

                        <input type="checkbox" id="daily_living_assistance" name="daily_living_assistance" value="1">
                        <label for="daily_living_assistance">Daily Living Assistance</label><br>

                        <input type="checkbox" id="medical_care" name="medical_care" value="1">
                        <label for="medical_care">Medical care</label><br>

                        <input type="checkbox" id="transportation" name="transportation" value="1">
                        <label for="transportation">Transportation</label><br>

                        <input type="checkbox" id="counseling" name="counseling" value="1">
                        <label for="counseling">Counseling</label><br>

                        <input type="checkbox" id="hospice_care" name="hospice_care" value="1"">
                        <label for=" hospice_care">Hospice care</label><br>

                        <input type="checkbox" id="respite_care" name="respite_care" value="1">
                        <label for="respite_care">Respite care</label><br>
                    </div>

                    <!-- decription -->
                    <label for="description">Description</label><br>
                    <textarea id="description" name="description" rows="4" cols="50"></textarea>

                    <!-- btn -->
                    <div class="button">
                        <button type="submit" id="submitButton" class="send" form="serviceRequestForm" disabled>Send</button>
                        <button type="button" class="cancel" onclick="goBack()">Cancel</button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        <p>©2023 HelpConnect. All right reserved.</p>
    </div>
</body>

<script>
    // event listeners for form inputs
    document.getElementById('duration').addEventListener('input', validateForm);
    document.getElementById('service_datetime').addEventListener('input', validateForm);
    document.getElementById('description').addEventListener('input', validateForm);
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', validateForm);
    });

    validateForm();

    function goBack() {
        var userID = <?php echo $userID; ?>;
        window.location.href = "discover-profile.php?userID=" + userID;
    }

    function validateForm() {
        var duration = document.getElementById('duration').value;
        var service_datetime = document.getElementById('service_datetime').value;
        var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        var description = document.getElementById('description').value;

        var isValid = duration !== "" && service_datetime !== "" && checkboxes.length > 0 && description !== "";

        document.getElementById('submitButton').disabled = !isValid;

        return isValid;
    }
</script>

</html>