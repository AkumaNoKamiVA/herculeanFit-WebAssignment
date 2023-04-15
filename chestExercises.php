<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>chestExercises</title>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/chest.png"/>
	
	
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
	 #imgchestExercises{
    width: 300px;
    float:left; /* add this */
}
	</style>
</head>
<body>
<input class="home_btn btn btn-warning btn-lg" type="image" src="images/icons/favicon.ico" style="height:100px; width:300px;" onclick="window.location.href='http://localhost/herculeanFit/FinalHome/Home2.html';" value="Home"/>
<input class="home_btn" type = "button" onclick = "window.location.href='http://localhost/herculeanFit/progressTracking.php';" class="btn btn-warning btn-lg" style="width:300px"; value="Progress Tracking"/>
	 <form action="progressTracking.php">
 
  <div class="container">
  <div id="imgchestExercises">
  <img src="images/chestExercises.png" alt="chestLeft" width="200" height="200">
  </div>
  <div id="insideContainer">
  <h1>Chest Exercises</h1>
  <h3> Select an exercise:</h3> 
  <div class="Exercises">
<?php
// Establish a connection to the database using PDO
 require_once "database/db_connect.php";

// Execute a query to retrieve the exercises
$sql = "SELECT Exercisename FROM exercise WHERE ExerciseType='Chest' ORDER BY Exercisename";
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
</div>
</form>
<input type="submit" value="Ok">
<script>
    document.getElementById("exercise-form").addEventListener("submit", function() {
        var exerciseName = document.querySelector("select[name='exercise']").value;
        var exerciseNameInput = window.opener.document.getElementById("exercise-name");
        exerciseNameInput.value = exerciseName;
    });
</script>
</body>
</html>