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

// Query to retrieve user data
$query = "SELECT * FROM user WHERE userID = '$id'";
$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        // retrieve user data
        $row = mysqli_fetch_assoc($result);
        $name = $row['firstname'] . ' ' . $row['lastname'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $birthdate = $row['birthdate'];
        $gender = $row['gender'];
        $contact = $row['contact'];
        $address = $row['address'];
        $address2 = $row['address2'];
        $city = $row['city'];
        $state = $row['state'];
        $postcode = $row['postcode'];
        $country = $row['country'];
        $skills = $row['skill'];
        $health_condition = $row['health_condition'];
        $available_time = $row['available_time'];
    } else {
        // No user found with the provided ID
        echo "User not found";
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Query execution failed
    echo "Error executing query: " . mysqli_error($conn);
}

// Retrieve service data
$serviceQuery = "SELECT * FROM service WHERE userID = '$id'";
$serviceResult = mysqli_query($conn, $serviceQuery);
$serviceRow = mysqli_fetch_assoc($serviceResult);

$services = [
    'companionship' => $serviceRow['companionship'],
    'daily_living_assistance' => $serviceRow['daily_living_assistance'],
    'medical_care' => $serviceRow['medical_care'],
    'transportation' => $serviceRow['transportation'],
    'counseling' => $serviceRow['counseling'],
    'hospice_care' => $serviceRow['hospice_care'],
    'respite_care' => $serviceRow['respite_care']
];

// update data
if (isset($_POST['submit'])) {

    // register for elderly
    if ($this_user_role === "elderly") {

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $contactno = $_POST['contactno'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $postcode = $_POST['postcode'];
        $country = $_POST['country'];

        $query = "UPDATE user SET 
        firstname='$firstname', 
        lastname='$lastname', 
        gender='$gender', 
        contact='$contactno', 
        address='$address1', 
        address2='$address2', 
        city='$city', 
        state='$state', 
        postcode='$postcode', 
        country='$country', 
        health_condition='$health_condition' 
        WHERE userID='$id'";

        if (mysqli_query($conn, $query)) {

            $companionship = isset($_POST['companionship']) ? 1 : 0;
            $counseling = isset($_POST['counseling']) ? 1 : 0;
            $transportation = isset($_POST['transportation']) ? 1 : 0;
            $respite_care = isset($_POST['respite_care']) ? 1 : 0;
            $medical_care = isset($_POST['medical_care']) ? 1 : 0;
            $hospice_care = isset($_POST['hospice_care']) ? 1 : 0;
            $daily_living_assistance = isset($_POST['daily_living_assistance']) ? 1 : 0;

            $query = "UPDATE service SET 
        companionship='$companionship', 
        counseling='$counseling', 
        transportation='$transportation', 
        respite_care='$respite_care', 
        medical_care='$medical_care', 
        hospice_care='$hospice_care', 
        daily_living_assistance='$daily_living_assistance'
        WHERE userID='$id'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('Data updated successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "Error updating data: " . mysqli_error($conn);
        }
    }

    // register for volunteer
    if ($this_user_role === "volunteer") {

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $contactno = $_POST['contactno'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $postcode = $_POST['postcode'];
        $country = $_POST['country'];
        $available_time = $_POST['available-time'];
        $skill = $_POST['skill'];

        $query = "UPDATE user SET 
        firstname='$firstname', 
        lastname='$lastname', 
        gender='$gender', 
        contact='$contactno', 
        address='$address1', 
        address2='$address2', 
        city='$city', 
        state='$state', 
        postcode='$postcode', 
        country='$country', 
        available_time='$available_time', 
        skill='$skill'
        WHERE userID='$id'";

        if (mysqli_query($conn, $query)) {

            $companionship = isset($_POST['companionship2']) ? 1 : 0;
            $counseling = isset($_POST['counseling2']) ? 1 : 0;
            $transportation = isset($_POST['transportation2']) ? 1 : 0;
            $respite_care = isset($_POST['respite_care2']) ? 1 : 0;
            $medical_care = isset($_POST['medical_care2']) ? 1 : 0;
            $hospice_care = isset($_POST['hospice_care2']) ? 1 : 0;
            $daily_living_assistance = isset($_POST['daily_living_assistance2']) ? 1 : 0;

            $query = "UPDATE service SET 
        companionship='$companionship', 
        counseling='$counseling', 
        transportation='$transportation', 
        respite_care='$respite_care', 
        medical_care='$medical_care', 
        hospice_care='$hospice_care', 
        daily_living_assistance='$daily_living_assistance'
        WHERE userID='$id'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('Data updated successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "Error updating data: " . mysqli_error($conn);
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
    <link rel="stylesheet" href="../../styles/user-profile.css" type="text/css">

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
                <a href="../../interfaces/service/discover.php">Service</a>
                <a href="../../interfaces/community/community.php">Community</a>
                <a href="#" class="active">Profile</a>
            </nav>

            <button class="avatar-button fas" type="button" onclick="toggleAvatar()">
                <img src="../../assets/profile-icon.svg" alt="profile" class="avatar-text">
            </button>

            <!-- User Details Box -->
            <div id="userDetails" class="user-box">
                <p class="role" style="text-transform: capitalize;">
                    <?php echo $this_user_role; ?>
                </p>
                <p><strong>Username: </strong>
                    <?php echo $name; ?>
                </p>
                <p><strong>Email: </strong>
                    <?php echo $email; ?>
                </p>
                <button><a href="../authentication/logout.php" style="text-decoration: none; color: white;">Logout</a></button>

            </div>
        </div>

    </header>

    <div class="profile-container">

        <!-- side bar -->
        <div class="sidebar">
            <a href="user-profile.php" class="active">Information Setting</a>
            <a href="privacy-setting.php">Privacy Setting</a>
        </div>

        <!-- profile -->
        <div class="profile">


            <!-- breadcrumb -->
            <div class="breadcrumb">
                <a href="user-profile.php">Profile</a>
                <strong> / </strong>
                <a href="user-profile.php">Information Setting</a>
            </div>

            <!-- title-->
            <h1>Information Setting</h1>

            <div class="content">

                <form id="updateForm" action="" method="post">

                    <!-- basic information -->
                    <div>

                        <h3>Basic Information</h3>

                        <div class="basic">
                            <div class="signup-name">
                                <p class="input-label">First Name:</p>
                                <input type="text" name="firstname" placeholder="First Name" required class="box" value="<?php echo $firstname; ?>">
                                <p class="input-label">Last Name:</p>
                                <input type="text" name="lastname" placeholder="Last Name" required class="box" value="<?php echo $lastname; ?>">
                            </div>
                            <div class="radiobutton">
                                <p>Gender:</p>
                                <div>
                                    <input type="radio" id="male" name="gender" value="male" <?php if ($gender === 'male') echo 'checked'; ?>>
                                    <label for="male">Male</label><br>
                                </div>
                                <div>
                                    <input type="radio" id="female" name="gender" value="female" <?php if ($gender === 'female') echo 'checked'; ?>>
                                    <label for="female">Female</label><br>
                                </div>
                            </div>
                            <p class="input-label">Email:</p>
                            <input type="email" name="email" id="email" placeholder="Email Address" required class="box" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" value="<?php echo $email; ?>" readonly>
                            <p class="input-label">Contact No.:</p>
                            <input type="number" name="contactno" placeholder="Contact No." required class="box no-spinner" value="<?php echo $contact; ?>">
                            <div class="birth-date">
                                <p class="birth-date-label">Birth Date:</p>
                                <input type="date" name="dob" placeholder="Birth Date" required class="box" value="<?php echo $birthdate; ?>">
                            </div>
                        </div>

                        <div class="addr-pass">
                            <p class="input-label">Address:</p>
                            <input type="text" id="address1" name="address1" placeholder="Street Address" required class="box" value="<?php echo $address; ?>">
                            <input type="text" id="address2" name="address2" placeholder="Street Address Line 2" required class="box" value="<?php echo $address2; ?>">
                            <div class="city-state">
                                <input type="text" id="city" name="city" placeholder="City" required value="<?php echo $city; ?>">
                                <input type="text" id="state" name="state" placeholder="State" required value="<?php echo $state; ?>">
                            </div>
                            <input type="number" id="postcode" name="postcode" pattern="\d{5}" title="Postcode must be 5 digits" placeholder="Postcode" required class="box no-spinner" value="<?php echo $postcode; ?>">
                            <input type="text" id="country" name="country" placeholder="Country" required class="box" value="<?php echo $country; ?>">

                        </div>
                    </div>

                    <!-- personal information -->
                    <div>
                        <h3>Personal Information</h3>

                        <?php if ($this_user_role === 'elderly') { ?>

                            <div class="elderly-input">
                                <p>Health Condition:</p>
                                <div class="radiobutton-health">
                                    <div>
                                        <input type="radio" id="healthy" name="health" value="healthy" <?php if ($health_condition === 'healthy') echo 'checked'; ?>>
                                        <label for="healthy">Healthy</label><br>
                                    </div>
                                    <div>
                                        <input type="radio" id="frail" name="health" value="frail" <?php if ($health_condition === 'frail') echo 'checked'; ?>>
                                        <label for="frail">Frail</label><br>
                                    </div>
                                    <div>
                                        <input type="radio" id="disabled" name="health" value="disabled" <?php if ($health_condition === 'disabled') echo 'checked'; ?>>
                                        <label for="disabled">Disabled</label><br>
                                    </div>
                                    <div>
                                        <input type="radio" id="chronically-ill" name="health" value="chronically-ill" <?php if ($health_condition === 'chronically-ill') echo 'checked'; ?>>
                                        <label for="chronically-ill">Chronically ill</label><br>
                                    </div>
                                    <div>
                                        <input type="radio" id="terminally-ill" name="health" value="terminally-ill" <?php if ($health_condition === 'terminally-ill') echo 'checked'; ?>>
                                        <label for="terminally-ill">Terminally ill</label><br>
                                    </div>
                                </div>

                                <p>Service Type Needed:</p>
                                <div class="radiobutton-health">
                                    <div>
                                        <input type="checkbox" id="companionship" name="companionship" value="1" <?php if ($services['companionship']) echo 'checked'; ?>>
                                        <label for="companionship">Companionship</label><br>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="daily_living_assistance" name="daily_living_assistance" value="1" <?php if ($services['daily_living_assistance']) echo 'checked'; ?>>
                                        <label for="daily_living_assistance">Daily Living Assistance</label><br>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="medical_care" name="medical_care" value="1" <?php if ($services['medical_care']) echo 'checked'; ?>>
                                        <label for="medical_care">Medical care</label><br>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="transportation" name="transportation" value="1" <?php if ($services['transportation']) echo 'checked'; ?>>
                                        <label for="transportation">Transportation</label><br>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="counseling" name="counseling" value="1" <?php if ($services['counseling']) echo 'checked'; ?>>
                                        <label for="counseling">Counseling</label><br>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="hospice_care" name="hospice_care" value="1" <?php if ($services['hospice_care']) echo 'checked'; ?>>
                                        <label for="hospice_care">Hospice care</label><br>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="respite_care" name="respite_care" value="1" <?php if ($services['respite_care']) echo 'checked'; ?>>
                                        <label for="respite_care">Respite care</label><br>
                                    </div>
                                </div>

                                <div class="button">
                                    <button type="submit" id="elderly-submit" name="submit">Save Changes</button>
                                </div>
                            </div>

                            </```php <!-- <div class="volunteer-input" style="display: none;"> -->
                        <?php } elseif ($this_user_role === 'volunteer') { ?>

                            <div class="volunteer-input">
                                <p>Available Time:</p>
                                <div class="radiobutton-health2">
                                    <div>
                                        <input type="radio" id="weekends" name="available-time" value="weekends" <?php if ($available_time === 'weekends') echo 'checked'; ?>>
                                        <label for="weekends">Weekends</label><br>
                                    </div>
                                    <div>
                                        <input type="radio" id="weekdays" name="available-time" value="weekdays" <?php if ($available_time === 'weekdays') echo 'checked'; ?>>
                                        <label for="weekdays">Weekdays</label><br>
                                    </div>
                                    <div>
                                        <input type="radio" id="both" name="available-time" value="both" <?php if ($available_time === 'both') echo 'checked'; ?>>
                                        <label for="both">Both</label><br>
                                    </div>
                                </div>

                                <p>Skill/Specialty:</p>
                                <textarea id="skill" name="skill" rows="1" cols="50" placeholder="Type here"><?php echo $skills; ?></textarea>


                                <p>Service Offered:</p>
                                <div class="radiobutton-health">
                                    <div>
                                        <input type="checkbox" id="companionship2" name="companionship2" value="1" <?php if ($services['companionship']) echo 'checked'; ?>>
                                        <label for="companionship2">Companionship</label><br>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="daily_living_assistance2" name="daily_living_assistance2" value="1" <?php if ($services['daily_living_assistance']) echo 'checked'; ?>>
                                        <label for="daily_living_assistance2">Daily Living Assistance</label><br>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="medical_care2" name="medical_care2" value="1" <?php if ($services['medical_care']) echo 'checked'; ?>>
                                        <label for="medical_care2">Medical care</label><br>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="transportation2" name="transportation2" value="1" <?php if ($services['transportation']) echo 'checked'; ?>>
                                        <label for="transportation2">Transportation</label><br>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="counseling2" name="counseling2" value="1" <?php if ($services['counseling']) echo 'checked'; ?>>
                                        <label for="counseling2">Counseling</label><br>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="hospice_care2" name="hospice_care2" value="1" <?php if ($services['hospice_care']) echo 'checked'; ?>>
                                        <label for="hospice_care2">Hospice care</label><br>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="respite_care2" name="respite_care2" value="1" <?php if ($services['respite_care']) echo 'checked'; ?>>
                                        <label for="respite_care2">Respite care</label><br>
                                    </div>
                                </div>

                                <div class="button">
                                    <button type="submit" id="volunteer-submit" name="submit">Save Changes</button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('../authentication/footer.php') ?>

</body>

</html>