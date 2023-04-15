<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>armExercises</title>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/arm.png"/>
	
	
	<link rel="stylesheet" href="css/measurementStyle.css"> 
	 
	<style>

	.container{
		 padding: 120px;
		 max-width: 500px;
		 margin: 0 auto;
		 border-top: 5px solid #435757;
		 background-color: rgba(255, 255, 255, .2);
		 box-shadow: 0 0 20px rgba(0, 0, 0, .1);
		 background: white;
		 border-radius:10px;
	 }
	 #imgarmExercises{
    width: 300px;
    float:left; /* add this */
}
	</style>
</head>
<body>
	<input class="home_btn" type = "image" src="images/icons/favicon.ico"/ style="height=100px width:300px"onclick = "window.location.href="#";"class="btn btn-warning btn-lg" value="Home"/>
	<input class="home_btn" type = "button" onclick = "window.location.href='http://localhost/herculeanFit/progressTracking.php';" class="btn btn-warning btn-lg" style="width:300px"; value="Progress Tracking"/>
	<form action="TryingAnything2.php">
 
  <div class="container">
  <div id="imgarmExercises">
  <img src="images/armExercises.png" alt="chestLeft" width="200" height="200">
  </div>
  <div id="insideContainer">
  <h1>Arm Exercises</h1>
  <h3> Select an exercise:</h3>
  <div class="Exercises">
  <div id="exercise-form">
<?php
// Establish a connection to the database using PDO
 require_once "database/db_connect.php";

// Execute a query to retrieve the exercises
$sql = "SELECT Exercisename FROM exercise WHERE ExerciseType='Arms' ORDER BY Exercisename";
$result = $conn->query($sql);

// Build a select input with the retrieved exercises
echo "<select name='exercise'>";
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<option value='" . $row['Exercisename'] . "'>" . $row['Exercisename'] . "</option>";
}
echo "</select>";

// Close the database connection
$conn = null;
?>
  </div>

  <input type="submit" value="Ok">
</div>
</div>
</form>
<script>
    document.getElementById("exercise-form").addEventListener("submit", function() {
        var exerciseName = document.querySelector("select[name='exercise']").value;
        var exerciseNameInput = window.opener.document.getElementById("exercise-name");
        exerciseNameInput.value = exerciseName;
    });
</script>
</body>
</html>