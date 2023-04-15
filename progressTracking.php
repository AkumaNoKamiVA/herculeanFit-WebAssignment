<?php
session_start();

        
       
         $exerciseNameErr = $setsErr = $repsErr = $weightErr =" ";
        $exerciseName = $sets= $reps = $weight =" ";
        //Database connection

        require_once 'database/db_connect.php';
        function test_input($data) {
            $data= trim($data);
            $data= stripslashes($data);
            $data= htmlspecialchars($data);
            return $data;
        }

                      

        if ($_SERVER["REQUEST_METHOD"] == "POST")  {
            if(empty($_POST["exercise-Name"])){
                $exerciseNameErr="Exercise Name is required";
            }else{
                $exerciseName= test_input($_POST["exercise-Name"]);
                if (!preg_match('/^[a-zA-Z]+$/',$exerciseName)){
                    echo "Invalid Exercise Name";
                    exit();
                }
            } 
			
        if ($_SERVER["REQUEST_METHOD"] == "POST")  {
            if(empty($_POST["Sets"])){
                $setsErr="Set is required";
            }else{
                $sets=($_POST["Sets"]);               
            }  
		}
		
		if ($_SERVER["REQUEST_METHOD"] == "POST")  {
            if(empty($_POST["Reps"])){
                $repsErr="Rep is required";
            }else{
                $reps=($_POST["Reps"]);               
            }  
		}
           
		if ($_SERVER["REQUEST_METHOD"] == "POST")  {
            if(empty($_POST["Weight"])){
                $weightErr="Weight is required";
            }else{
                $weight=($_POST["Weight"]);               
            }  
		}
          
		
            if (empty($weightErr) && empty($repsErr) && empty( $setsErr)&& empty($exerciseNameErr)){
                $_SESSION['exercise-Name'] = $_POST['exercise-Name'];
                $_SESSION['Sets'] = $_POST['Sets'];
                $_SESSION['Reps'] = $_POST['Reps'];
                $_SESSION['Weight'] = $_POST['Weight'];
    
            }
			$Date = date("Y-m-d");
			$UserIdSearch = $_SESSION['loginId'];
                //insert data into users table
                $stmt= $conn->prepare("INSERT INTO progresstracking(RUserId,Weight,ExerciseName,Sets,Reps,Date) VALUES (:RUserId,:Weight,:ExerciseName,:Sets,:Reps,:Date)");
                 $stmt->bindParam(":RUserId", $UserIdSearch);
                $stmt->bindParam(":Weight",$weight);
                $stmt->bindParam(":ExerciseName",$exerciseName);
                $stmt->bindParam(":Sets",$sets);
                $stmt->bindParam(":Reps",$reps);
				$stmt->bindParam(":Date",$Date);
                $stmt->execute();
                if($stmt){
                    echo "successful";
                }else{
                    echo"Not successful";
                }
                
                //Insert user data into registereduser table
                
            
            
            echo "Saving successful";
            $conn=null;
        }
?>
<!DOCTYPE html>
<html lang="en">
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



</head>


<body>

  
<input class="home_btn btn btn-warning btn-lg" type="image" src="images/icons/favicon.ico" style="height:50px; width:50px;" onclick="window.location.href='http://localhost/herculeanFit/FinalHome/Home2.html';" value="Home"/>
<input class="home_btn" type = "button" onclick = "window.location.href='http://localhost/herculeanFit/measurement.php';"class="btn btn-warning btn-lg" style="width:300px"; value="Measurements"/>
		<input class="home_btn" type = "button" onclick = "window.location.href='http://localhost/herculeanFit/calorieTracking.php';"class="btn btn-warning btn-lg" style="width:300px"; value="Calorie Tracking"/>
		<input class="home_btn" type = "button" onclick = "window.location.href='http://localhost/herculeanFit/progressLog.php';"class="btn btn-warning btn-lg" style="width:300px"; value="Exercise Log"/>
		
  </ul>
  <div class="container">
  <h1>Exercise Tracker</h1>
  
  <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>>
    <label for="exerciseName">Exercise Name:</label>
    <select id="exerciseName" onchange="goToWorkout()">
		<option value=""></option>
      <option value="http://localhost/herculeanFit/backExercises.php">Back</option>
      <option value="http://localhost/herculeanFit/chestExercises.php">Chest</option>
      <option value="http://localhost/herculeanFit/armExercises.php">Arms</option>
	  <option value="http://localhost/herculeanFit/legExercises.php">Legs</option>
	  <option value="http://localhost/herculeanFit/absAndCardioExercises.php">Abs & Cardio</option>
    </select>

    <input type="text" id="exercise-Name" name="exercise-Name" value="<?php if(isset($_GET['exercise'])){echo $_GET['exercise'];}else{echo" ";}?>">
	
    <label for="sets">Sets:</label>
    <input type="number" min="0" id="sets" name="Sets">
    
    <label for="reps">Reps:</label>
    <input type="number" min="0" id="reps" name="Reps">
    
    <label for="weight">Weight:</label>
    <input type="number" min="0" id="weight" name="Weight">
    
    <button class="login100-form-btn" type="button" onclick="addExercise()">Add Exercise</button>
    
  </form>
  <!-- <input type="submit" Value="Add Exercise"> -->
  <script>
    function goToWorkout() {
      const exerciseName = document.getElementById("exerciseName").value;
      if (exerciseName !== "") {
        window.location.href = exerciseName;
      }
    }
  </script>
  <ul id="exercise-list"></ul>
  
  <script src="exercise.js"></script>
   
  </div>

</script>

	
</body>

<script>
const exerciseList = document.getElementById("exercise-list");
let exercises = [];

function addExercise() {
  const exerciseName = document.getElementById("exercise-Name").value;
  const sets = document.getElementById("sets").value;
  const reps = document.getElementById("reps").value;
  const weight = document.getElementById("weight").value;
  /*<?php
	// need to set $_ 
  ?>*/
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

</script>
</html>