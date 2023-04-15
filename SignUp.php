<?php
session_start();

        
       
        $fnameErr = $lnameErr= $emailErr=$phonenoErr = $genderErr= $dobErr=$addErr=$pwdErr=$cpwdErr=" ";
        $fname = $lname= $email=$phoneno = $gender= $dob = $add = $pwd =$cpwd=$age=$userid=$loginid=$age=" ";
        
		//Database connection
        require_once 'database/db_connect.php';
		
        function test_input($data) {
            $data= trim($data);
            $data= stripslashes($data);
            $data= htmlspecialchars($data);
            return $data;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST")  {
            if(empty($_POST["FirstName"])){
                $fnameErr="First Name is required";
            }else{
                $fname= test_input($_POST["FirstName"]);
                if (!preg_match('/^[a-zA-Z]+$/',$fname)){
                    echo "Invalid First Name";
                    exit();
                }
            }

            if(empty($_POST["LastName"])){
                $lnameErr="Last Name is required";
            }else{
                $lname=test_input($_POST["LastName"]);
                if (!preg_match('/^[a-zA-Z]+$/',$lname)){
                    echo "Invalid Last Name";
                    exit();
                }
    
            }

            if(empty($_POST["Email"])){
                $emailErr="Email is required";
            }else{
                $email=test_input($_POST["Email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                  }                  
            }

            if(empty($_POST["PhoneNumber"])){
                $phonenoErr="Phone Number is required";
            }else{
                $phoneno=($_POST["PhoneNumber"]);
                if (!preg_match("/^5[0-9]{7}$/",$phoneno,)){
                    echo "Invalid Phone Number";
                    exit();
                }
    
            }

            if(empty($_POST["Gender"])){
                $genderErr="Gender is required";
            }else{
				($gender=$_POST["Gender"]);
			}
				

            if(empty($_POST["DoB"])){
                $dobErr="Date of Birth is required";
            }else{
                $dob = $_POST["DoB"];
                $min_date = "1933-01-01"; // Minimum allowed date
                $max_date = "2013-12-31"; // Maximum allowed date

                // Check if the date is within the allowed period
                if (strtotime($dob) !== false && $dob >= $min_date && $dob <= $max_date) {
                echo "Date is within the allowed period!";
                } else {
                echo "Date is outside the allowed period.";
                }
            }

            if(empty($_POST["Address"])){
                $addErr="Address is required";
            }else{
                $add=test_input($_POST["Address"]);
            }

            if(empty($_POST["Password"])){
                $pwdErr="Password is required";
            }else{
                $pwd=($_POST["Password"]);
                if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $pwd)){
                    echo "Invalid Password";
                    exit();
                }else{
                    $pwd = $_POST['Password'];
                }
            }

            if(empty($_POST["Confirm_password"])){
                $cpwdErr="Please confirm the password";
            }else{
                $cpwd=($_POST["Confirm_password"]);
                if (!($pwd==$cpwd)){
                    $cpwdErr="Password does not match";
                }else{
                    echo "Password  match";
                    $passwordHash= password_hash($pwd, PASSWORD_DEFAULT); 
                }
            }
            
            
            if (empty($fnameErr) && empty($lnameErr) && empty( $emailErr)&& empty($phonenoErr) && empty($genderErr)&& empty($dobErr)&& empty($addErr)){
                $_SESSION['FirstName'] = $_POST['FirstName'];
                $_SESSION['LastName'] = $_POST['LastName'];
                $_SESSION['Email'] = $_POST['Email'];
                $_SESSION['Phone_No'] = $_POST['Phone_No'];
                $_SESSION['Gender'] = $_POST['Gender'];
                $_SESSION['DoB'] = $_POST['DoB'];
                $_SESSION['Address'] = $_POST['Address'];
    
            }
    

    
                //calculate age of user
               $today = date("Y-m-d");
               $diff = date_diff(date_create($dob), date_create($today));
               $age = $diff->format('%y');
            
                //generate UserId
                function generateUserId($conn) {
                    $stmt = $conn->prepare("SELECT MAX(UserId) AS max_id FROM users");
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($row==null){
                        $max_id=1;
                    }else{
                        $max_id = $row['max_id'];
                    }
                    return ($max_id + 1);
                }
        
               
                    $userid = generateUserId($conn);
                    // $_SESSION[$userid];
                
                

                //insert data into users table
                $stmt= $conn->prepare("INSERT INTO users(UserId,PhoneNumber,Email,Address,password_hash) VALUES (:UserId,:PhoneNumber,:Email,:Address,:Password)");
                 $stmt->bindParam(":UserId", $userid);
                $stmt->bindParam(":PhoneNumber",$phoneno);
                $stmt->bindParam(":Email",$email);
                $stmt->bindParam(":Address",$add);
                $stmt->bindParam(":Password",$passwordHash);
                $stmt->execute();
                if($stmt){
                    echo "successful";
                }else{
                    echo"Not successful";
                }
                
                //Insert user data into registereduser table
                $stmt= $conn->prepare("INSERT INTO registereduser(RUserId,FirstName,LastName,Age,DoB,Gender) VALUES (:UserId,:FirstName,:LastName,:Age,:DoB,:Gender) ");
                $stmt->bindParam(":UserId",$userid);
                $stmt->bindParam(":FirstName",$fname);
                $stmt->bindParam(":LastName",$lname);
                $stmt->bindParam(":Age",$age);
                $stmt->bindParam(":DoB",$dob);
                $stmt->bindParam(":Gender",$gender);
                $stmt->execute();
            
			$success="Registration successful";

            if(!empty($success))
            {
                header("Location:login.php");
            }
            
            echo "Registration successful";
            $conn=null;
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>SignUp</title>
    <link rel="icon" type="image/png" href="images/icons/dumbbells.png"/>
    <link rel="stylesheet" href="SignUp.css">
    <link rel="stylesheet" href="main.css">
		 
</head>
<body>
    <div class="limiter">
    <input class="home_btn" type = "image" src="images/icons/favicon.ico"/ style="height=100px width:300px"onclick = "window.location.href='http://localhost/herculeanFit/FinalHome/Home1.html';"class="btn btn-warning btn-lg" value="Home"/>
	
        <div class="container" >


            <div class="wrap">
           
                <form action=<?php echo $_SERVER['PHP_SELF']; ?> method= "POST"> 
                <h1>Sign Up</h1>
                    <div class="wrap-input100" style="padding-top: 20px;">
                        <input  class="input100" type="text" autocapitalize="word" id="First_Name" name="FirstName" placeholder="First Name" required>
                         <input  class="input100" type="text" id="Last_Name" name="LastName" placeholder="Last Name" required>
                    </div>
                    <div class="wrap-input100" >
                        <input  class="input100" type="email" id="Email" name="Email" placeholder="Email" required>
                        <input  class="input100" type="text" id="Phone_No" name="PhoneNumber" placeholder="Phone number" required>

                    </div>
                   
                    <div class="wrap-input101">
                        <label>Gender: </label>

                        <input  type="radio" id="Male" name="Gender" placeholder="Male" <?php echo $gender=="M" ? "checked" : ""; ?>>
                        <label class="input101" for="Male">Male</label>
                        
                        <input  type="radio" id="Female" name="Gender" placeholder="Female" <?php echo $gender=="F" ? "checked" : ""; ?>>
                        <label class="input101" for="Female">Female</label>
                        
                        <input type="radio" id="Other" name="Gender"  placeholder="Other" <?php echo $gender=="O" ? "checked" : ""; ?>>
                        <label class="input101" for="Other">Other</label>
                    </div>

                    <div class="wrap-input100" >
                        <label for="Dob" style="padding-top: 20px">Date of Birth: </label>
                        <input class="input100" type="date" id="Dob" name="DoB" value="1993-12-01" min="1933-12-01" max="2013-12-01" required>
                    </div>
                    <div class="wrap-input100" style="padding-top: 20px;">
                        <input class="input100" type="text" id="Address" name="Address" placeholder="Address" value="Port-Louis">
                    </div>
                    <div class="wrap-input100">
                        <input class="input100" type="password" id="Password" name="Password" minlength="8"  placeholder="Password"required>
                        <input class="input100" type="password" id="Confirm_password" name="Confirm_password" minlength="8" placeholder="Confirm Password" required>
                    </div>  

                    <div class="container-login100-form-btn">
                    <input type="submit" name="SignUp" value="SignUP">
						<!-- <button class="login100-form-btn">
							Sign Up
						</button> -->
					</div>
                    
                    <div class="text-center p-t-136">
						<a class="txt2" href="http://localhost/herculeanFit/login.php">
							Already have an account?
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
                </form>
            </div>
        </div>
    </div>
   
<body>
</html>

        
       
       
        
