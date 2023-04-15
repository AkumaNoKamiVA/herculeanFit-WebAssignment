<head>
<title>progressTracking</title>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/progressTracking.png"/>
	<link rel="stylesheet" href="css/measurementStyle.css"> 
<style>
body {
  font-family: Arial, sans-serif;
  background: #9053c7;
		 background: -webkit-linear-gradient(-135deg, #c850c0, #4158d0);
		 background: -o-linear-gradient(-135deg, #c850c0, #4158d0);
		 background: -moz-linear-gradient(-135deg, #c850c0, #4158d0);
		 background: linear-gradient(-135deg, #c850c0, #4158d0);
		 
}

h1 {
  text-align: center;
}

form {
  display: flex;
  flex-direction: column;
  margin: 0 auto;
  width: 50%;
}

label {
  margin-top: 1rem;
}

input, select {
  margin-bottom: 1rem;
}

button {
  margin-top: 1rem;
}

ul {
  list-style-type: none;
  margin-top: 2rem;
  padding-left: 0;
}

li {
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  padding: 1rem;
}

.container-login100-form-btn {
  width: 100%;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding-top: 20px;
}

.login100-form-btn {
  font-family: Montserrat-Bold;
  font-size: 15px;
  line-height: 1.5;
  color: #fff;
  text-transform: uppercase;

  width: 100%;
  height: 50px;
  border-radius: 25px;
  background: #57b846;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 25px;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.login100-form-btn:hover {
  background: #333333;
}

.container{
		 padding: 50px;
		 max-width: 700px;
		 margin: 0 auto;
		 border-top: 5px solid #435757;
		 background-color: rgba(255, 255, 255, .2);
		 box-shadow: 0 0 20px rgba(0, 0, 0, .1);
		 background: white;
		 border-radius:10px;
	 }
</style>
 <?php
 if (isset($_GET["exercise"])) {
    $exercise = htmlspecialchars($_GET["exercise"]);
    echo '<script>document.getElementById("partExerciseName").value = "' . $exercise . '";</script>';
}
 ?>
</head>


<body>

  
		<input class="home_btn" type = "image" src="images/icons/favicon.ico"/ width="40" height="50" onclick = "window.location.href="#";"class="btn btn-warning btn-lg" value="Home"/>
		<input class="home_btn" type = "button" onclick = "window.location.href="#";"class="btn btn-warning btn-lg" style="width:300px"; value="Measurements"/>
		<input class="home_btn" type = "button" onclick = "window.location.href="#";"class="btn btn-warning btn-lg" style="width:300px"; value="Calorie Tracking"/>

  </ul>
  <div class="container">
  <h1>Exercise Tracker</h1>
  
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="exerciseName">Exercise Name:</label>
    <select id="exerciseName" onchange="goToWorkout()">
		<option value=""></option>
      <option value="http://localhost/herculeanFit/backExercises.php">Back</option>
      <option value="http://localhost/herculeanFit/chestExercises.php">Chest</option>
      <option value="http://localhost/herculeanFit/TryingAnything3.php">Arms</option>
	  <option value="http://localhost/herculeanFit/legExercises.php">Legs</option>
	  <option value="http://localhost/herculeanFit/absAndCardioExercises.php">Abs & Cardio</option>
    </select>
	
    <label for="partExerciseName">Exercise:</label>
    <input type="text" id="partExerciseName">
	
    <label for="sets">Sets:</label>
    <input type="number" id="sets">
    
    <label for="reps">Reps:</label>
    <input type="number" id="reps">
    
    <label for="weight">Weight:</label>
    <input type="number" id="weight">
    
    <button class="login100-form-btn" type="submit" onclick="addExercise()">Add Exercise</button>
    <button class="login100-form-btn" type="button" onclick="saveExercises()">Save Exercises</button>
  </form>
  <script>
    function goToWorkout() {
      const exerciseName = document.getElementById("exerciseName").value;
      if (exerciseName !== "") {
        window.location.href = exerciseName;
      }
	  window.location.href = document.getElementById("exerciseName").value + "?exercise=" + encodeURIComponent(document.getElementById("exerciseName").options[document.getElementById("exerciseName").selectedIndex].text);

    }
  </script>
  <ul id="exercise-list"></ul>
  
  <script src="exercise.js"></script>
  </div>

</body>


<script>
const exerciseList = document.getElementById("exercise-list");
let exercises = [];

function addExercise() {
  const exerciseName = document.getElementById("exerciseName").value;
  document.getElementById("partExerciseName").value = document.getElementById("exerciseName").value;
  const sets = document.getElementById("sets").value;
  const reps = document.getElementById("reps").value;
  const weight = document.getElementById("weight").value;
  
  exercises.push({
    exerciseName: exerciseName,
    sets: sets,
    reps: reps,
    weight: weight
  });
  
  const exercise = document.createElement("li");
  exercise.innerHTML = `
    <strong>${exerciseName}</strong>
    <br>
    Sets: ${sets} Reps: ${reps} Weight: ${weight}
  `;
  
  exerciseList.appendChild(exercise);
  
  // Clear input fields and auto-increment sets
  document.getElementById("sets").value = Number(sets) + 1;
  document.getElementById("reps").value = "";
  document.getElementById("weight").value = "";
}

function saveExercises() {
  if (exercises.length > 0) {
    // Send data to server
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save-exercises.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          alert("Exercises saved successfully!");
          exercises = [];
          exerciseList.innerHTML = "";
        } else {
          alert("Error: " + xhr.status);
        }
      }
    };
    xhr.send(JSON.stringify(exercises));
  }
}

</script>
