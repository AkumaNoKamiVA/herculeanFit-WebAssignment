<!DOCTYPE html>
<?php
session_start();

require_once "database/db_connect.php";

$loginIdErr = $passwordErr = "";
$loginId = $userpassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["num_loginId"])) {
    $loginIdErr = "User Name is required";
  } else {
    $loginId = $_POST["num_loginId"];
  }
  if (empty($_POST["txt_password"])) {
    $passwordErr = "Password is required";
  } else {
    $userpassword= $_POST["txt_password"];
  }

  if($loginIdErr == "" && $passwordErr == "" ) {
    try {
      $stmt = $conn->prepare("SELECT * FROM users WHERE UserId = :loginId");
      $stmt->bindParam(":loginId", $loginId);
      $stmt->execute();
      $userResults = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if ($userResults && password_verify($userpassword, $userResults['password'])) {
        // Regenerate session ID to prevent session fixation attacks
        session_regenerate_id();
        $_SESSION['loginId'] = $loginId;
        setcookie('last_login', time() , time() + 2 * 24 * 60 * 60);//setcookie(name, value, expire)
        header("Location: Home2.html?referer=login");
        die();
      } else {
        $Msg = "Invalid credentials. Try again or make sure you are a registered user!";
        echo $Msg;
      }
    } catch (PDOException $e) {
      // Log the error instead of showing it to the user
      error_log("Database error: " . $e->getMessage());
      $Msg = "Internal error. Please try again later.";
      echo $Msg;
	  echo $e;
    }
  }
}
?>
<html lang="en">
<head>
	<!--My update-->
	<title>login</title>
	<!-- /My update -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<!--My update-->
	<link rel="icon" type="image/png" href="images/icons/dumbbells.png"/>
	<!-- /My update -->
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
	<!-- My update -->
	 <link rel="stylesheet" href="css/main.css">
	 <!-- /My update -->
	 


</head>
<body>

	<div class="limiter">
	<!-- My update -->
	<input class="home_btn btn btn-warning btn-lg" type="image" src="images/icons/favicon.ico" style="height:50px; width:50px;" onclick="window.location.href='http://localhost/herculeanFit/FinalHome/Home1.html';" value="Home"/>
	<!-- /My update -->
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<span class="login100-form-title">
					<!-- My update-->
						Unleash Your Inner Hercules.
					<!-- /My update -->
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid login Id is required">
						<input class="input100" type="number" name="num_loginId" placeholder="Id">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="txt_password" placeholder="Password"><!--<span class="error"> <?php echo $passwordErr;?></span><br/><br/> 
						--><span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>						
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="http://localhost/herculeanFit/SignUp.php">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>