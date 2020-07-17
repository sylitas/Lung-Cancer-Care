<?php 
	//Register
	session_start();
	$message = "";
	if (isset($_POST['register'])) {
			$username 	= $_POST['username'];
			$password 	= $_POST['password'];
			$passwordagain 	= $_POST['passwordagain'];
			include("database_connection.php");
			//non-injection
			$username = stripcslashes($username);
			$password = stripcslashes($password);
			$username = mysqli_real_escape_string($connection,$username);
			$password = mysqli_real_escape_string($connection,$password);
				if (!empty($username) || !empty($password) || !empty($passwordagain)){
					if($passwordagain !== $password){
?>
						<script type="text/javascript">
							alert("Both Password are not the same");
						</script>
<?php

					}else{
						//for password encrypt using md5
						$password_encrypted = md5($password);
						if (mysqli_connect_error())
						{
							die('Connect Error('. mysqli_connect_error().')'.mysqli_connect_error());
						}else{
							$SELECT = "SELECT username FROM `doctor` WHERE username = ? LIMIT 1";
							$INSERT = "INSERT Into `doctor` (username,password) values (?,?)";
							//check
							$stmt = $connection->prepare($SELECT);
							$stmt->bind_param("s",$username);
							$stmt->execute();
							$stmt->bind_result($username);
							$stmt->store_result();
							$rnum = $stmt->num_rows;
							if ($rnum == 0) {
								$stmt->close();
								$stmt = $connection->prepare($INSERT);
								$stmt->bind_param("ss",$username,$password_encrypted);
								$stmt->execute();
								$_SESSION["username"] = $username;
								header('Location: login.php');
							}else{
								$message = "The Username has been taken. Please try again !";
							}
							$stmt->close();
							$connection->close();
						}
					}
				}else{
					die();
				}
		}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="/Git-lcc/internship-project/lcc/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/Git-lcc/internship-project/lcc/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/Git-lcc/internship-project/lcc/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/Git-lcc/internship-project/lcc/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/Git-lcc/internship-project/lcc/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/Git-lcc/internship-project/lcc/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/Git-lcc/internship-project/lcc/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/Git-lcc/internship-project/lcc/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/Git-lcc/internship-project/lcc/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/Git-lcc/internship-project/lcc/css/util.css">
	<link rel="stylesheet" type="text/css" href="/Git-lcc/internship-project/lcc/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('/Git-lcc/internship-project/lcc/images/bg-01.jpg');">
			<div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
				<form class="login100-form validate-form flex-sb flex-w" action="" method="POST" >
					<span class="login100-form-title p-b-53">
						Register
					</span>
					<div class="w-full text-center">
						<p style="color: red"><?php echo $message; ?></p>
					</div>
					<div class="p-t-31 p-b-9">
						<span class="txt1">
							Username
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Username must under 20 characters">
						<input class="input100" type="text" name="username" maxlength="20" pattern="[A-Za-z\d]{1,20}" oninvalid="setCustomValidity('Username must be normal number or word and under 20 characters')" onchange="try{setCustomValidity('')}catch(e){}" />
						<span class="focus-input100"></span>
					</div>
					<div class="p-t-31 p-b-9">
						<span class="txt1">
							Password
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Password must contain a capital letter, a number and at least 8 characters">
						<input class="input100" type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" oninvalid="setCustomValidity('Password must contain a capital letter, a number and at least 8 characters')" onchange="try{setCustomValidity('')}catch(e){}" />
						<span class="focus-input100"></span>
					</div>
					<div class="p-t-31 p-b-9">
						<span class="txt1">
							Input password again
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Password must contain a capital letter, a number and at least 8 characters">
						<input class="input100" type="password" name="passwordagain" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" oninvalid="setCustomValidity('Password must contain a capital letter, a number and at least 8 characters')" onchange="try{setCustomValidity('')}catch(e){}" />
						<span class="focus-input100"></span>
					</div>
					<div class="container-login100-form-btn m-t-17">
						<button class="login100-form-btn" name="register">
							Register
						</button>
						<!-- <input type="submit" class="login100-form-btn m-t-17" name="register" value="Register"> -->
					</div>
					<div class="w-full text-center p-t-55">
						<span class="txt2">
							Already a member?
						</span>

						<a href="login" class="txt2 bo1">
							Sign in now
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="/Git-lcc/internship-project/lcc/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="/Git-lcc/internship-project/lcc/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="/Git-lcc/internship-project/lcc/vendor/bootstrap/js/popper.js"></script>
	<script src="/Git-lcc/internship-project/lcc/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="/Git-lcc/internship-project/lcc/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="/Git-lcc/internship-project/lcc/vendor/daterangepicker/moment.min.js"></script>
	<script src="/Git-lcc/internship-project/lcc/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="/Git-lcc/internship-project/lcc/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="/Git-lcc/internship-project/lcc/js/main.js"></script>

</body>
</html>



