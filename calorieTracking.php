<?php
	session_start();
// if(!isset($_SESSION['loginId'])){
// 	header('Location:FinalHome/Home1.html'); 
// }
// else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>calorieTracking</title>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/diet.png"/>
	
	
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
	 #imgExercises{
    width: 300px;
    float:left; /* add this */
}
	</style>
	<?php
		$Date = "";
	?>
	<script>
		function showPopup() {
			
			// Create a new pop-up element
			var popup = document.createElement("div");
			popup.classList.add("popup");

			// Create a new content element
			var content = document.createElement("div");
			content.classList.add("popup-content");
            
			// Create a new close button
			var closeButton = document.createElement("span");
			closeButton.classList.add("popup-close");
			closeButton.innerHTML = "&times;";
			closeButton.onclick = function(event) {
                 event.stopPropagation();
                popup.style.display = "none";
            };

			// Populate the content with the query result and close button
			content.innerHTML = "<p>" + nutritionalInfo + "</p>";
			content.appendChild(closeButton);

			// Add the content to the pop-up and show it
			popup.appendChild(content);
			document.body.appendChild(popup);
			popup.style.display = "block";

            var dontUnload = true;

            window.onunload = function() {
                if (dontUnload) {
                    popup.close();
                }
            };

            setTimeout(function() {
                dontUnload = false;
            }, 5000);
		}
	</script>
</head>
<body>
<input class="home_btn btn btn-warning btn-lg" type="image" src="images/icons/favicon.ico" style="height:50px; width:50px;" onclick="window.location.href='http://localhost/herculeanFit/FinalHome/Home2.html';" value="Home"/>
<input class="home_btn" type = "button" onclick = "window.location.href='http://localhost/herculeanFit/progressTracking.php';" class="btn btn-warning btn-lg" style="width:300px"; value="Progress Tracking"/>
	 
 
  <div class="container">
  <div id="imgExercises">
  <img src="images/diet.png" alt="progressImg" width="200" height="200">
  </div>
  <div id="insideContainer">
  <h1>Calorie Log</h1>
	 <div class="DisplayData">
	 <form action=<?php echo $_SERVER['PHP_SELF']; ?> method= POST>

                <div class="wrap-input100" style="padding-top: 0.1vh;padding-bottom: 0.1vh;">

                <?php
                    // Connect to your database using PDO
                    require_once "database/db_connect.php";

                    // Query your database to get the data for the dropdown list
                    $query = "SELECT FoodName FROM Food";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    


                    echo '<input  class="input100" list="Food_Name" id="food" name="FoodName" placeholder="type food name" />';
                    echo '<datalist id="Food_Name" name="Foodname">';
                    foreach ($data as $row) {
                        echo '<option value="' . $row['Foodname'] . '">';
                    }
                    echo '</datalist>';

                 
                    ?>
                    <label class="input100">Serving Size</label>
                
                    <button onclick="showPopup()"> Nutritional Info </button>
                     <!-- Use PHP to retrieve the query result -->
                     
                        
                        <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST")  {
                                if(empty($_POST['Foodname'])){
                                    $foodnameErr="A Food Name should be selected";
                                }
                                    
                                    else{
                                        if(empty ($foodnameErr)){
                                            $_SESSION['Foodname']= $_POST['Foodname'];
                                        }
                                        
                                            try {
                                                require_once "herculeanfit/database/db_connect.php";
    
                                                // Set the PDO error mode to exception
                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
                                                // Prepare and execute the query
                                                $query = " SELECT NutritionalInfo, CaloriePerServing FROM Food WHERE FoodName=:Foodname";
                                                $stmt = $conn->prepare($query);
                                                $stmt->bindParam(':FoodName', $_SESSION['Foodname']);
                                                $stmt->execute();
    
                                                // Fetch the result
                                                $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
                                                // Display the result in the pop-up
                                                echo "var nutritionalInfo = '" . addslashes($data["NutritionalInfo"]) . "';";
                                            } catch(PDOException $e) {
                                                echo "alert('Error retrieving nutritional info.');";
                                                return;
                                            }
                                        }
                             
                        ?>
                        }
                    </script>
                 
                   
                       
                    
                    

                    
                    
                </div>
                <div class="wrap-input100" style="padding-top: 0.1vh;padding-bottom: 0.1vh;">
                    <input class="input100" type="text" id="NoServing" name="NumberServing" placeholder="Number of Servings" required >
                </div>

                <div class ="wrap-input100" style="padding-top: 0.1vh;padding-bottom: 0.1vh;">
                    <label for="LogDate" style="padding-top: 15px;">Calorie Log for Date:</label>
                    <input class="input100" type="date" id="LogDate" name="LogDate" >
                </div>
                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                       Submit
                    </button>
                </div>
             </form>
	</div>
	
  </div>
</div>

	

</body>
</html>
<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // get user input
        $food = $_POST["Foodname"];

        if(empty($_POST["NumberServing"])){
            $NoServingErr="Number of Servings is required";
        }else{
            $NoServing= $_POST["NumberServing"];
        }
        // create a PDO instance
        require_once "herculeanfit/database/db_connect.php";
        $date='now';
        date_create($date);


        // prepare an SQL statement
        $stmt = $conn->prepare('INSERT INTO CalorieTracking (FoodName,NumberServing, Date) VALUES (:FoodName,:NumberServing,:Date) WHERE RUserId=:Userid');

        // bind user input value
        $stmt->bindParam(":Userid",$_SESSION['loginId']);
        $stmt->bindParam(":Date", $date);
        $stmt->bindParam(":FoodName", $food);
        $stmt->bindParam(":NumberServing", $NoServing);

        // execute statement
        if ($stmt->execute()) {
            // display confirmation message
            echo "<p>Data inserted successfully</p>";
        } else {
            // display error message
            echo "<p>Something went wrong</p>";
        }

        //Calculate calorie per NumberServing entered by user
        $stmt= $conn->prepare('SELECT CaloriePerServing * NumberServing AS CaloriesConsumed
        FROM food
        JOIN CalorieTracking ON Food.FoodName = calorietracking.FoodName
        WHERE FoodName=:Foodname');
        $stmt->bindParam(':FoodName', $_SESSION['Foodname']);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        //Store the calorie calculated in the table
        $stmt = $conn->prepare('INSERT INTO CalorieTracking (Calorie) VALUES (:calorie) WHERE RUserId=:Userid AND FoodName=:Foodname');
        $stmt->bindParam(":Userid",$_SESSION['loginId']);
        $stmt->bindParam(':FoodName', $_SESSION['Foodname']);
        $stmt->bindParam(':calorie', $data);


    }
  
    // check if user input is set
    if (isset($_POST["FoodName"])) {
        // get user input
        $food = $_POST["FoodName"];
        //retrieve ServingSize
        $query = "SELECT ServingSize FROM CalorieTracking WHERE FoodName=:FoodName";
        $stmt = $conn->prepare($query);
		$stmt->bindParam(':FoodName', $_SESSION['Foodname']);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // display output

        echo "<p class='input100'> Serving Size is: $data</p> ";
    
    }
} 
?>