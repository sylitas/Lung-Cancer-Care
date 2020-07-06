<?php 
	require_once "vendor/autoload.php";
	use \Firebase\JWT\JWT;
	session_start();
	
	if(!isset($_SESSION["username"])){
		$_SESSION["username"] = "";
	}
	if (isset($_GET["logout"])) {
		session_unset();
		session_destroy();
        setcookie("lcc", "", -1,'/');
        header('Location: login.php');
        exit();
    }

	$message = "";

	$key = "LungCancerCareUSTH";
	$payload = array(
		"iss" => "USTH",
		"aud" => "Duy",
		"iat" => 1356999524, //custom later
    	"nbf" => 1357000000
	);
	//get token then automatically login
	if(isset($_COOKIE["lcc"])){
		header('Location: dashboard/index.php');
	}
	//Login
	if (isset($_POST['login'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			include("database_connection.php");
			//non-injection
			$username = stripcslashes($username);
			$password = stripcslashes($password);
			$username = mysqli_real_escape_string($connection,$username);
			$password = mysqli_real_escape_string($connection,$password);
			if (!empty($username) || !empty($password)){
				//for password encrypt using md5
				$password_encrypted = md5($password);
				$query = "SELECT `id` FROM login WHERE username = '$username' AND password = '$password_encrypted'";
				$result = mysqli_query($connection,$query);
				if (mysqli_num_rows($result) == 1) {
					//divide to row
					$u = mysqli_fetch_array($result);
					//add values to the token
					$payload["id"] = $u["id"];
					//encode
					$jwt = JWT::encode($payload,$key);
					//store to cookie
					setcookie("lcc",$jwt,time()+3600,"/",null,null,true);
					header('Location: dashboard/index.php');
				}else{
					$message = "Invalid Username and Password";
				}
			}else{
				die();
			}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
				<form class="login100-form validate-form flex-sb flex-w" action="" method="POST">
					<span class="login100-form-title p-b-53">
						Sign In With
					</span>
					<div class="w-full text-center">
						<p style="color: red"><?php echo $message; ?></p>
					</div>
					<div class="p-t-31 p-b-9">
						<span class="txt1">
							Username
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Username is required">
						<input class="input100" type="text" name="username" value="<?php echo $_SESSION["username"];?>">
						<span class="focus-input100"></span>
					</div>	
					<div class="p-t-13 p-b-9">
						<span class="txt1">
							Password
						</span>
						<!-- <a href="#" class="txt2 bo1 m-l-5">
							Forgot?
						</a> -->
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" >
						<span class="focus-input100"></span>
					</div>
					<!-- <div class="p-t-31 p-b-9">
						<span class="txt1">
							Kind of Job
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Job is required">
						<select class="input100" required>
							<option selected hidden value="">---</option>
							<option value="Doctor">Doctor</option>
						</select>
						<span class="focus-input100"></span>
					</div> -->
					<div class="container-login100-form-btn m-t-17">
						<button class="login100-form-btn" name="login">
							Sign In
						</button>
					</div>
					<div class="w-full text-center p-t-55">
						<span class="txt2">
							Not a member?
						</span>
						<a href="register.php" class="txt2 bo1">
							Sign up now
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
</body>
</html>