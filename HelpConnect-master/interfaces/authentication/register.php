<?php

include('../../database/connect.php');

if (isset($_POST['submit'])) {

   $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
   $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
   $gender = mysqli_real_escape_string($conn, $_POST['gender']);
   $dob = mysqli_real_escape_string($conn, $_POST['dob']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $contactno = mysqli_real_escape_string($conn, $_POST['contactno']);
   $address1 = mysqli_real_escape_string($conn, $_POST['address1']);
   $address2 = mysqli_real_escape_string($conn, $_POST['address2']);
   $city = mysqli_real_escape_string($conn, $_POST['city']);
   $state = mysqli_real_escape_string($conn, $_POST['state']);
   $postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
   $country = mysqli_real_escape_string($conn, $_POST['country']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $role = $_POST['role'];

   $select_users = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email'") or die('query failed');

   if (mysqli_num_rows($select_users) > 0) {
      echo "<script>alert('User already exists!');</script>";
   } else {
      if ($pass != $cpass) {
         echo "<script>alert('Confirm password does not match!');</script>";
      } else {

         // register for elderly
         if ($role === "elderly") {

            $health = mysqli_real_escape_string($conn, $_POST['health']);
            $companionship = isset($_POST['companionship']) ? 1 : 0;
            $counseling = isset($_POST['counseling']) ? 1 : 0;
            $transportation = isset($_POST['transportation']) ? 1 : 0;
            $respite_care = isset($_POST['respite_care']) ? 1 : 0;
            $medical_care = isset($_POST['medical_care']) ? 1 : 0;
            $hospice_care = isset($_POST['hospice_care']) ? 1 : 0;
            $daily_living_assistance = isset($_POST['daily_living_assistance']) ? 1 : 0;

            $query = "INSERT INTO `user` (firstname, lastname, gender, birthdate, email, contact, address, address2, city, state, postcode, country, password, role, health_condition) 
               VALUES ('$firstname', '$lastname', '$gender', '$dob', '$email', '$contactno', '$address1', '$address2', '$city', '$state', '$postcode', '$country', '$pass', '$role', '$health')";
            $result = mysqli_query($conn, $query);

            if ($result) {
               $userID = mysqli_insert_id($conn); 

               $serviceNeeded = "INSERT INTO service (companionship, counseling, transportation, respite_care, medical_care, hospice_care, daily_living_assistance, userID)
                           VALUES ('$companionship','$counseling','$transportation','$respite_care','$medical_care','$hospice_care','$daily_living_assistance','$userID')";

               if (mysqli_query($conn, $serviceNeeded)) {
                  echo "<script>alert('Account created.'); window.location.href = 'login.php';</script>";
               } else {
                  echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
               }
            } else {
               echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
         }

         // register for volunteer
         if ($role === "volunteer") {

            $time = mysqli_real_escape_string($conn, $_POST['available-time']);
            $skill = mysqli_real_escape_string($conn, $_POST['skill']);
            $companionship = isset($_POST['companionship2']) ? 1 : 0;
            $counseling = isset($_POST['counseling2']) ? 1 : 0;
            $transportation = isset($_POST['transportation2']) ? 1 : 0;
            $respite_care = isset($_POST['respite_care2']) ? 1 : 0;
            $medical_care = isset($_POST['medical_care2']) ? 1 : 0;
            $hospice_care = isset($_POST['hospice_care2']) ? 1 : 0;
            $daily_living_assistance = isset($_POST['daily_living_assistance2']) ? 1 : 0;

            $query = "INSERT INTO `user` (firstname, lastname, gender, birthdate, email, contact, address, address2, city, state, postcode, country, password, role, available_time, skill) 
               VALUES ('$firstname', '$lastname', '$gender', '$dob', '$email', '$contactno', '$address1', '$address2', '$city', '$state', '$postcode', '$country', '$pass', '$role', '$time' , '$skill')";
            $result = mysqli_query($conn, $query);

            if ($result) {
               $userID = mysqli_insert_id($conn); 

               $serviceNeeded = "INSERT INTO service (companionship, counseling, transportation, respite_care, medical_care, hospice_care, daily_living_assistance, userID)
                           VALUES ('$companionship','$counseling','$transportation','$respite_care','$medical_care','$hospice_care','$daily_living_assistance','$userID')";

               if (mysqli_query($conn, $serviceNeeded)) {
                  echo "<script>alert('Account created.'); window.location.href = 'login.php';</script>";

               } else {
                  echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
               }
            } else {
               echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
         }
      }
   }
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <title>Sign Up</title>

   <!-- import custom css -->
   <link rel="stylesheet" href="../../styles/main.css" type="text/css">
   <link rel="stylesheet" href="../../styles/header.css" type="text/css">
   <link rel="stylesheet" href="../../styles/footer.css" type="text/css">
   <link rel="stylesheet" href="../../styles/register.css" type="text/css">

</head>

<body class="signup-form">

   <!-- left -> picture -->
   <div class="picture">
      <img src="../../assets/auth-picture.png" alt="hand-pic" height="55px">
   </div>

   <!-- right -> form -->
   <div class="form-container">

      <!-- logo -->
      <img src="../../assets/logo.svg" alt="logo" height="65px">

      <form id="signupForm" action="" method="post" onsubmit="submitForm(event)">
         <h3>SIGN UP</h3>
         <p>Already have an account? <a href="./login.php">Login</a></p>

         <div class="basic" style="display: block;">
            <div class="radiobutton">
               <div>
                  <input type="radio" id="elderly" name="role" value="elderly">
                  <label for="elderly">Regsiter as Elderly</label><br>
               </div>
               <div>
                  <input type="radio" id="volunteer" name="role" value="volunteer">
                  <label for="volunteer">Register as Volunteer</label><br>
               </div>
            </div>

            <div class="signup-name">
               <input type="text" name="firstname" placeholder="First Name" required class="box">
               <input type="text" name="lastname" placeholder="Last Name" required class="box">
            </div>
            <div class="radiobutton">
               <p>Gender:</p>
               <div>
                  <input type="radio" id="male" name="gender" value="male">
                  <label for="male">Male</label><br>
               </div>
               <div>
                  <input type="radio" id="female" name="gender" value="female">
                  <label for="female">Female</label><br>
               </div>
            </div>
            <input type="email" name="email" id="email" placeholder="Email Address" required class="box" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
            <input type="number" name="contactno" placeholder="Contact No." required class="box no-spinner">
            <div class="birth-date">
               <p class="birth-date-label">Birth Date:</p>
               <input type="date" name="dob" placeholder="Birth Date" required class="box">
            </div>

            <div class="button">
               <button id="nextButton" disabled onclick="toggleNext()">Next</button>
            </div>
         </div>

         <div class="addr-pass" style="display: none;">
            <input type="text" id="address1" name="address1" placeholder="Street Address" required class="box">
            <input type="text" id="address2" name="address2" placeholder="Street Address Line 2" required class="box">
            <div class="city-state">
               <input type="text" id="city" name="city" placeholder="City" required>
               <input type="text" id="state" name="state" placeholder="State" required>
            </div>
            <input type="number" id="postcode" name="postcode" pattern="\d{5}" title="Password must be 5 digits" placeholder="Postcode" required class="box no-spinner">
            <input type="text" id="country" name="country" placeholder="Country" required class="box">

            <input type="password" id="password" name="password" pattern="(?=.*[a-zA-Z])(?=.*\d).{8,}" title="Password must have at least 8 characters and contain both letters and numbers" placeholder="Password" required class="box">
            <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" required class="box">

            <div class="button">
               <button id="nextButton2" disabled onclick="toggleRoleInput(event)">Next</button>
            </div>
         </div>

         <div class="elderly-input" style="display: none;">
            <p>Health Condition:</p>
            <div class="radiobutton-health">
               <div>
                  <input type="radio" id="healthy" name="health" value="healthy">
                  <label for="healthy">Healthy</label><br>
               </div>
               <div>
                  <input type="radio" id="frail" name="health" value="frail">
                  <label for="frail">Frail</label><br>
               </div>
               <div>
                  <input type="radio" id="disabled" name="health" value="disabled">
                  <label for="disabled">Disabled</label><br>
               </div>
               <div>
                  <input type="radio" id="chronically-ill" name="health" value="chronically-ill">
                  <label for="chronically-ill">Chronically ill</label><br>
               </div>
               <div>
                  <input type="radio" id="terminally-ill" name="health" value="terminally-ill">
                  <label for="terminally-ill">Terminally ill</label><br>
               </div>
            </div>

            <p>Service Type Needed:</p>
            <div class="radiobutton-health">
               <div>
                  <input type="checkbox" id="companionship" name="companionship" value="1">
                  <label for="companionship">Companionship</label><br>
               </div>
               <div>
                  <input type="checkbox" id="daily_living_assistance" name="daily_living_assistance" value="1">
                  <label for="daily_living_assistance">Daily Living Assistance</label><br>
               </div>
               <div>
                  <input type="checkbox" id="medical_care" name="medical_care" value="1">
                  <label for="medical_care">Medical care</label><br>
               </div>
               <div>
                  <input type="checkbox" id="transportation" name="transportation" value="1">
                  <label for="transportation">Transportation</label><br>
               </div>
               <div>
                  <input type="checkbox" id="counseling" name="counseling" value="1">
                  <label for="counseling">Counseling</label><br>
               </div>
               <div>
                  <input type="checkbox" id="hospice_care" name="hospice_care" value="1">
                  <label for="hospice_care">Hospice care</label><br>
               </div>
               <div>
                  <input type="checkbox" id="respite_care" name="respite_care" value="1">
                  <label for="respite_care">Respite care</label><br>
               </div>
            </div>

            <div class="button">
               <button type="submit" id="elderly-submit" name="submit" disabled>Sign Up</button>
            </div>
         </div>

         <div class="volunteer-input" style="display: none;">
            <p>Available Time:</p>
            <div class="radiobutton-health2">
               <div>
                  <input type="radio" id="weekends" name="available-time" value="weekends">
                  <label for="weekends">Weekends</label><br>
               </div>
               <div>
                  <input type="radio" id="weekdays" name="available-time" value="weekdays">
                  <label for="weekdays">Weekdays</label><br>
               </div>
               <div>
                  <input type="radio" id="both" name="available-time" value="both">
                  <label for="both">Both</label><br>
               </div>
            </div>

            <p>Skill/Specialty:</p>
            <textarea id="skill" name="skill" rows="1" cols="50" placeholder="Type here"></textarea>


            <p>Service Offered:</p>
            <div class="radiobutton-health">
               <div>
                  <input type="checkbox" id="companionship2" name="companionship2" value="1">
                  <label for="companionship2">Companionship</label><br>
               </div>
               <div>
                  <input type="checkbox" id="daily_living_assistance2" name="daily_living_assistance2" value="1">
                  <label for="daily_living_assistance2">Daily Living Assistance</label><br>
               </div>
               <div>
                  <input type="checkbox" id="medical_care2" name="medical_care2" value="1">
                  <label for="medical_care2">Medical care</label><br>
               </div>
               <div>
                  <input type="checkbox" id="transportation2" name="transportation2" value="1">
                  <label for="transportation2">Transportation</label><br>
               </div>
               <div>
                  <input type="checkbox" id="counseling2" name="counseling2" value="1">
                  <label for="counseling2">Counseling</label><br>
               </div>
               <div>
                  <input type="checkbox" id="hospice_care2" name="hospice_care2" value="1">
                  <label for="hospice_care2">Hospice care</label><br>
               </div>
               <div>
                  <input type="checkbox" id="respite_care2" name="respite_care2" value="1">
                  <label for="respite_care2">Respite care</label><br>
               </div>
            </div>

            <div class="button">
               <button type="submit" id="volunteer-submit" name="submit" disabled>Sign Up</button>
            </div>
         </div>



      </form>
   </div>

   </div>
</body>

<script>
   function submitForm(event) {
      var role = document.querySelector('input[name="role"]:checked').value;

      if (role === "elderly") {
         var health = document.querySelector('input[name="health"]:checked');
         var companionship = document.querySelector('input[name="companionship"]:checked');
         var daily_living_assistance = document.querySelector('input[name="daily_living_assistance"]:checked');
         var medical_care = document.querySelector('input[name="medical_care"]:checked');
         var transportation = document.querySelector('input[name="transportation"]:checked');
         var counseling = document.querySelector('input[name="counseling"]:checked');
         var hospice_care = document.querySelector('input[name="hospice_care"]:checked');
         var respite_care = document.querySelector('input[name="respite_care"]:checked');

         var isHealthSelected = health !== null;
         var isServiceSelected = companionship !== null || daily_living_assistance !== null || medical_care !== null || transportation !== null ||
                                 counseling !== null || hospice_care !== null || respite_care !== null ;

         var isValid = isHealthSelected && isServiceSelected;
         document.getElementById('elderly-submit').disabled = !isValid;

         if (isValid) {
            document.getElementById('signupForm').submit(event);
         }
      }

      if (role === "volunteer") {
         var time = document.querySelector('input[name="available-time"]:checked');
         var companionship = document.querySelector('input[name="companionship2"]:checked');
         var daily_living_assistance = document.querySelector('input[name="daily_living_assistance2"]:checked');
         var medical_care = document.querySelector('input[name="medical_care2"]:checked');
         var transportation = document.querySelector('input[name="transportation2"]:checked');
         var counseling = document.querySelector('input[name="counseling2"]:checked');
         var hospice_care = document.querySelector('input[name="hospice_care2"]:checked');
         var respite_care = document.querySelector('input[name="respite_care2"]:checked');
         
         var isTimeSelected = time !== null;
         var isServiceSelected = companionship !== null || daily_living_assistance !== null || medical_care !== null || transportation !== null ||
                                 counseling !== null || hospice_care !== null || respite_care !== null ;
                                 
         var isValid = isTimeSelected && isServiceSelected;
         document.getElementById('volunteer-submit').disabled = !isValid;

         if (isValid) {
            document.getElementById('signupForm').submit(event);
         }
      }

   }

   var formElementElderly = document.querySelectorAll('input[type="radio"], input[type="checkbox"]');
   formElementElderly.forEach(function(element) {
      element.addEventListener('input', submitForm);
   });

   function validateForm() {
      var firstName = document.getElementsByName('firstname')[0].value;
      var lastName = document.getElementsByName('lastname')[0].value;
      var role = document.querySelector('input[name="role"]:checked');
      var gender = document.querySelector('input[name="gender"]:checked');
      var email = document.getElementById('email').value;
      var contactNo = document.getElementsByName('contactno')[0].value;
      var dob = document.getElementsByName('dob')[0].value;

      var isFirstNameValid = firstName.trim() !== '';
      var isLastNameValid = lastName.trim() !== '';
      var isRoleSelected = role !== null;
      var isGenderSelected = gender !== null;
      var isEmailValid = email !== '';
      var isContactNoValid = contactNo !== '';
      var isDobValid = dob !== '';

      var isValid = isFirstNameValid && isLastNameValid && isRoleSelected && isGenderSelected && isEmailValid && isContactNoValid && isDobValid;

      document.getElementById('nextButton').disabled = !isValid;
   }

   function toggleNext() {

      var email = document.getElementById('email').value;
      var isEmailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

      if (!isEmailValid) {
         alert("Invalid email address");
         document.getElementById("email").value = "";
      } else {

         event.preventDefault();

         const basicSection = document.querySelector('.basic');
         const addrPassSection = document.querySelector('.addr-pass');
         const role = document.querySelector('input[name="role"]:checked').value;
         console.log(role);
         const elderlyInputSection = document.querySelector('.elderly-input');
         const volunteerInputSection = document.querySelector('.volunteer-input');

         basicSection.style.display = 'none';
         addrPassSection.style.display = 'block';
         elderlyInputSection.style.display = 'none';
         volunteerInputSection.style.display = 'none';
      }
   }

   var formElements = document.querySelectorAll('input[type="text"], input[type="email"], input[type="number"], input[type="date"], input[type="radio"]');
   formElements.forEach(function(element) {
      element.addEventListener('input', validateForm);
   });

   function validateAddrPassForm() {
      var address1 = document.getElementById('address1').value;
      var address2 = document.getElementById('address2').value;
      var city = document.getElementById('city').value;
      var state = document.getElementById('state').value;
      var postcode = document.getElementById('postcode').value;
      var country = document.getElementById('country').value;
      var password = document.getElementById('password').value;
      var cpassword = document.getElementById('cpassword').value;

      var isAddressValid = address1 !== '';
      var isAddress2Valid = address2 !== '';
      var isCityValid = city !== '';
      var isStateValid = state !== '';
      var isPostcodeValid = postcode !== '';
      var isCountryValid = country !== '';
      var isPasswordValid = password !== '';
      var isCPasswordValid = cpassword !== '';

      var isValid = isAddressValid && isAddress2Valid && isCityValid && isStateValid && isPostcodeValid && isCountryValid && isPasswordValid && isCPasswordValid;

      document.getElementById('nextButton2').disabled = !isValid;
   }

   var formElementsAddrPass = document.querySelectorAll('input[type="text"], input[type="password"]');
   formElementsAddrPass.forEach(function(element) {
      element.addEventListener('input', validateAddrPassForm);
   });

   function toggleRoleInput(event) {

      var passwordField = document.getElementById('password');
      var cpasswordField = document.getElementById('cpassword');
      var postcodeField = document.getElementById('postcode');

      var password = passwordField.value;
      var cpassword = cpasswordField.value;
      var postcode = postcodeField.value;

      var isPasswordValid = password.length >= 8 && /^(?=.*[a-zA-Z])(?=.*\d).*$/.test(password);
      var isCPasswordValid = cpassword === password;
      var isPostcodeValid = /^\d{5}$/.test(postcode);


      if (!isPostcodeValid) {
         alert("Password must be 5 digits");
         document.getElementById("postcode").value = "";
      } else if (!isPasswordValid) {
         alert("Password must have at least 8 characters and contain both letters and numbers");

      } else if (!isCPasswordValid) {
         alert("Passwords do not match");
         document.getElementById("password").value = "";
         document.getElementById("cpassword").value = "";
      } else {

         event.preventDefault();

         const basicSection = document.querySelector('.basic');
         const addrPassSection = document.querySelector('.addr-pass');
         const role = document.querySelector('input[name="role"]:checked').value;
         const elderlyInputSection = document.querySelector('.elderly-input');
         const volunteerInputSection = document.querySelector('.volunteer-input');

         basicSection.style.display = 'none';
         addrPassSection.style.display = 'none';

         if (role === 'elderly') {
            elderlyInputSection.style.display = 'block';
            volunteerInputSection.style.display = 'none';
         } else if (role === 'volunteer') {
            elderlyInputSection.style.display = 'none';
            volunteerInputSection.style.display = 'block';
         }
      }
   }
</script>

</html>