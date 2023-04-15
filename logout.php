<!DOCTYPE html>
<?php
// Start the session
//The session_start() function must be the very first thing in your document. Before any HTML tags.
session_start();
session_destroy();
?>
<html lang="en">
<head>
	
	<title>Logout</title>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/logouticon.png"/>
	
	
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
	<input class="home_btn btn btn-warning btn-lg" type="image" src="images/icons/favicon.ico" style="height:50px; width:50px;" onclick="window.location.href='http://localhost/herculeanFit/FinalHome/Home2.html';" value="Home"/>

  <div class="container">
  <div id="imgarmExercises">
  <img src="images/icons/logouticon.png"/ alt="chestLeft" width="200" height="200">
  </div>
  <div id="insideContainer">
  <h1>Logout</h1>
  <div class="Exercises">

You are sucessfully logged out !! <a href="http://localhost/herculeanFit/login.php">Click here to log in </a>
  </div>
</div>

	
</body>
</html>