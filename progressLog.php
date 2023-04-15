<?php
// if(!isset($_SESSION['loginId'])){
// 	header('Location:FinalHome/Home1.html'); 
// }
// else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>progressLog</title>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/progressTrackingSearchDate.png"/>
	
	
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
		session_start();
		$Date = "";
	?>
	
</head>
<body>
<input class="home_btn btn btn-warning btn-lg" type="image" src="images/icons/favicon.ico" style="height:50px; width:50px;" onclick="window.location.href='http://localhost/herculeanFit/FinalHome/Home2.html';" value="Home"/>
<input class="home_btn" type = "button" onclick = "window.location.href='http://localhost/herculeanFit/progressTracking.php';" class="btn btn-warning btn-lg" style="width:300px"; value="Progress Tracking"/>
	 
 
  <div class="container">
  <div id="imgExercises">
  <img src="images/progressTrackingSearchDate.png" alt="progressImg" width="200" height="200">
  </div>
  <div id="insideContainer">
  <h1>Log for progress</h1>
	 <div class="DisplayData">
	<form method="post" action="progressLog.php">
		<label for="search-date">Enter a date:</label>
		<input type="date" id="searchDate" name="search-date" value="<?php echo date("Y-m-d")?>">

		<button type="submit" name="submit">Search</button>
	</form>
	</div>
	<?php
		if (isset($_POST['submit'])) {
			$Date = $_POST['search-date'];
			$UserIdSearch = $_SESSION['loginId'];
			
			require_once "database/db_connect.php";
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = "SELECT RUserId, Weight, ExerciseName, Sets, Reps, Date, (Weight * Sets * Reps) AS TotalWeight FROM progressTracking WHERE RUserId= :UserIdSearch AND Date=:date ORDER BY ExerciseName";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':UserIdSearch', $UserIdSearch);
			$stmt->bindParam(':date', $Date);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) > 0) {
				echo '<table>';
				echo '<tr><th>User ID</th><th>Weight</th><th>Exercise Name</th><th>Sets</th><th>Reps</th><th>Date</th><th>Total Weight</th></tr>';
				foreach ($result as $row) {
					echo '<tr>';
					echo '<td>' . $row['RUserId'] . '</td>';
					echo '<td>' . $row['Weight'] . '</td>';
					echo '<td>' . $row['ExerciseName'] . '</td>';
					echo '<td>' . $row['Sets'] . '</td>';
					echo '<td>' . $row['Reps'] . '</td>';
					echo '<td>' . $row['Date'] . '</td>';
					echo '<td>' . $row['TotalWeight'] . '</td>';
					echo '</tr>';
				}
				echo '</table>';
			} else {
				echo 'No records found for the selected date.';
			}

			$conn = null;
		}
	?>
  </div>
</div>

	

</body>
</html>
<?php
// }

?>