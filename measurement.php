<!DOCTYPE html>
<?php
 session_start();
	$user_id = $_SESSION['loginId'];
?>
<html lang="en">
<head>
	
	<title>measurement</title>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/measuring-tape.png"/>
	
	
	<link rel="stylesheet" href="css/measurementStyle.css"> 
	 
<script>
function calBMI() {
  const weightInput = document.getElementById('weightMeasurement');
  const heightInput = document.getElementById('heightMeasurement');
  const bmiResult = document.getElementById('bmi-result');

  const weight = parseFloat(weightInput.value);
  const height = parseFloat(heightInput.value) / 100; // convert to meters

  if (isNaN(weight) || isNaN(height) || height === 0) {
    bmiResult.innerText = 'Invalid input';
  } else {
    const bmi = weight / (height * height);
    bmiResult.innerText = bmi.toFixed(2);
  }
}
</script>
	<style>
	.measurementSize{
	float: left;
    width: 20%;
    padding: 0px;
	flex-direction: column;
	position: relative;
	}
	
	</style>
</head>
<body>
    <input class="home_btn btn btn-warning btn-lg" type="image" src="images/icons/favicon.ico" style="height:50px; width:50px;" onclick="window.location.href='http://localhost/herculeanFit/FinalHome/Home2.html';" value="Home"/>
    <form>
 
  <div class="container">
  <div id="imgMeasuringLeft">
  <img src="images/measurementMainLeft.png" alt="MeasuringLeft" width="200" height="300">
  </div>
  <div id="insideContainer">
  <h1>Hercules Measurements</h1>
  <h3> Select Body Parts and Add Measurement:</h3>
  <div class="bodypartsCheckbox">
  <ul style="list-style-type: none;">
	<li>
    <input id="back" type="checkbox">
    <label for="back">Back</label>
	<input class="measurementSize" id= "backMeasurement" type="number" min="0" placeholder="value in cm">
	</li>
    
	<li>
    <input id="chest" type="checkbox">
    <label for="chest">Chest</label>
	<input class="measurementSize" id= "chestMeasurement" type="number"  min="0" placeholder="value in cm">
	</li>
	
	<li>
    <input id="waist" type="checkbox">
    <label for="waist">Waist</label>
	<input class="measurementSize" id= "waistMeasurement" type="number" min="0" placeholder="value in cm">
	</li>
	
	<li>
    <input id="hips" type="checkbox">
    <label for="hips">Hips</label>
	<input class="measurementSize" id= "hipsMeasurement" type="number" min="0" placeholder="value in cm">
	</li>
	
	<li>
    <input id="rightLeg" type="checkbox">
    <label for="rightLeg">Right-leg</label>
	<input class="measurementSize" id= "rightLegMeasurement" type="number" min="0" placeholder="value in cm">
	</li>
	
	<li>
	<input id="left-Leg" type="checkbox">
    <label for="leftLeg">Left-leg</label>
	<input class="measurementSize" id= "leftLegMeasurement" type="number" min="0" placeholder="value in cm">
	</li>
	
	<li>
    <input id="rightArm" type="checkbox">
    <label for="rightArm">Right-Arm</label>
	<input class="measurementSize" id= "rightArmMeasurement" type="number" min="0" placeholder="value in cm">
	</li>
	
	<li>
	<input id="left-Arm" type="checkbox" >
    <label for="leftArm">Left-leg</label>
	<input class="measurementSize" id= "leftArmMeasurement" type="number" min="0" placeholder="value in cm">
	</li>
	
	<br>
	<br>
	
	<li>
    <input id="height" type="checkbox">
    <label for="height">Height</label>
	<input class="measurementSize" id= "heightMeasurement" type="number" min="0" placeholder="value in cm">
	</li>
	<li>
    <input id="weight" type="checkbox">
    <label for="weight">Weight</label>
	<input class="measurementSize" id= "weightMeasurement" type="number" min="0" placeholder="value in cm">
	</li>
	</ul>

	<button type="button" onclick="calBMI()">Calculate BMI</button>

	<p>Your BMI is: <span id="bmi-result"></span></p>
  </div>

  <input type="submit" value="Save">

</form>
<br>
<br>
<div>
<?php
require_once "database/db_connect.php";

function displayBodyPartSize($user_id, $body_part) {
    global $conn;
	
    /* Validate user ID
    if ((!is_numeric($user_id)) && ($user_id !== $UserIdSearch)) {
        echo "Error: Invalid user ID<br>";
        return;
    }*/

    // Validate body part
    if (empty($body_part)) {
        echo "Error: Body part not selected<br>";
        return;
    }

    // Execute a query to retrieve the size for the given body part
    $sql = "SELECT RUserId, BPartName, Size FROM bodypart WHERE RUserId = :user_id AND BPartName = :body_part";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':body_part', $body_part);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Display the results
    if ($result) {
        echo "User ID: " . $result['RUserId'] . "<br>";
        echo "Body Part: " . $result['BPartName'] . "<br>";
        echo "Size: " . $result['Size'] . "<br>";
    } else {
        echo "No size found for user ID $user_id and body part $body_part";
    }
}
?><form method="POST">
    <!--    <label for="user_id">User ID:</label>
            <input type="text" name="user_id" id="user_id">
    -->
    <label for="body_part">Body Part:</label>
    <select name="body_part" id="body_part">
	    <option value=""></option>
        <option value="Chest">Chest</option>
        <option value="Arms">Arms</option>
        <option value="Legs">Legs</option>
        <option value="Back">Back</option>
    </select>

    <button type="submit" name="submit">Get Size</button>
</form>

<?php
// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the user ID and body part from the form
    $user_id = $_POST['user_id'];
    $body_part = $_POST['body_part'];

    // Call the displayBodyPartSize function with the user ID and body part as parameters
    displayBodyPartSize($user_id, $body_part);
}
?>
</div>
</div>
</body>
</html>