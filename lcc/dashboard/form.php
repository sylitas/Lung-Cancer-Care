<?php
    require_once "../vendor/autoload.php";
    use \Firebase\JWT\JWT;
    session_start();
    include("../database_connection.php");

    if(!isset($_COOKIE['lcc'])){
        header('Location: ../login.php');
    }
    //decode---------------------------------------------------------------take id
    $jwt = $_COOKIE['lcc'];
    $key = "LungCancerCareUSTH";
    try{
        $jwt_decode = JWT::decode($jwt, $key, array('HS256'));
        //object to array
        $array = (array)$jwt_decode;
        $checkaccount = $array["id"];
    }catch(Exception $e){
        echo $e->getMessage();
    }
    

    // --------------------------------------------------------------------
    $select = "SELECT * FROM login WHERE id = '$checkaccount'";
    $result = mysqli_query($connection,$select);
    $u = mysqli_fetch_array($result);
        $username = $u["username"];
        $path = $u["path"];
        $firstname = $u["firstname"];
        $lastname = $u["lastname"];
        $birthday = $u["birthday"];
        $email = $u["email"];
        if($path == null){$path = "images\avatar\profile_0.png";}
        if($firstname == null){$firstname = "Please Update the Firstname";}
        if($lastname == null){$lastname = "Please Update the Lastname";}
        if($birthday == null){$birthday = "Please Update the Birthday";}
        if($email == null){$email = "Please Update the Email";}        

        

	if(isset($_POST['update'])){
		if ($_POST['firstname'] == null && $_POST['lastname'] == null && $_POST['email'] == null && $_POST['birthday'] == null && ((!file_exists($_FILES['fileToUpload']['tmp_name']) || !is_uploaded_file($_FILES['fileToUpload']['tmp_name'])))) {
?>
    <script type="text/javascript">
        alert("Missing Information");
    </script>
<?php
		}else{
            // --------upload avatar------------
            
            if((file_exists($_FILES['fileToUpload']['tmp_name']) || is_uploaded_file($_FILES['fileToUpload']['tmp_name']))){
                $uploadOk = 1;
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                  } else {
                    $uploadOk = 0;
                  }
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    ?>
                        <script type="text/javascript">
                            alert("Your file is too big");
                        </script>
                    <?php
                  $uploadOk = 0;
                }
                // Allow certain file formats
                $tail = explode('.', $_FILES['fileToUpload']['name']);
                $tail = strtolower($tail[(count($tail) - 1)]);
                if($tail != "jpg" && $tail != "png" && $tail != "jpeg") {
                  $uploadOk = 0;
                }
                if ($uploadOk != 0) {
                    $destination = "images/avatar/profile_".$checkaccount.".png";
                    if(file_exists($destination)){unlink($destination);}
                    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $destination);
                    $update = "UPDATE `login` SET `path` = '$destination' WHERE id = '$checkaccount'";
                    mysqli_query($connection, $update);
                }
            }
            // --------end upload avatar------------
			if($_POST['firstname'] != null){
				$firstnameNew = $_POST['firstname'];
                $firstnameNew = stripcslashes($firstnameNew);
                $firstnameNew = mysqli_real_escape_string($connection,$firstnameNew);
				$update = "UPDATE `login` SET firstname = ? WHERE id = '$checkaccount'";
                $stmt = $connection->prepare($update);
                $stmt->bind_param("s",$firstnameNew);
                $stmt->execute();
			}
			if($_POST['lastname'] != null){
				$lastnameNew = $_POST['lastname'];
                $lastnameNew = stripcslashes($lastnameNew);
                $lastnameNew = mysqli_real_escape_string($connection,$lastnameNew);
				$update = "UPDATE `login` SET lastname = ? WHERE id = '$checkaccount'";
				$stmt = $connection->prepare($update);
                $stmt->bind_param("s",$lastnameNew);
                $stmt->execute();
			}
			if($_POST['email'] != null){
				$emailNew = $_POST['email'];
                $emailNew = stripcslashes($emailNew);
                $emailNew = mysqli_real_escape_string($connection,$emailNew);
				$update = "UPDATE `login` SET email = ? WHERE id = '$checkaccount'";
				$stmt = $connection->prepare($update);
                $stmt->bind_param("s",$emailNew);
                $stmt->execute();
			}
			if($_POST['birthday'] != null){
				$birthdayNew = $_POST['birthday'];
				$update = "UPDATE `login` SET birthday = '$birthdayNew' WHERE id = '$checkaccount'";
				mysqli_query($connection, $update);
			}
		}
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Forms</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.php">
                            <img src="images/icon/LogoNew-mini.png"/>
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <a class="js-arrow" href="index.php"><i class="fas fa-tachometer-alt"></i>Data</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="index.php">
                    <img src="images/icon/LogoNew-mini.png"/>
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="index.php"><i class="fas fa-tachometer-alt"></i>Data</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <h2>Account</h2>
                            <div class="header-button">
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
<?php
                                            echo '<img src ="' .$path. '"/>'
?>
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#"><?php echo $username;?></a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="">
<?php
                                                        echo '<img src ="' .$path. '"/>'
?>                                                  </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href=""><?php echo $username;?></a>
                                                    </h5>
                                                    <span class="email"><?php echo $email;?></span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="">
                                                        <i class="zmdi zmdi-account"></i>Account</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="../login.php?logout=1"><i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Information</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="" method="" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col-md-4">
                                                    <label for="file-input" class=" form-control-label">Avatar</label>
                                                </div>
                                                <div class="col-md-3">
<?php
                                                        echo '<img src ="' .$path. '"/>'
?> 
                                            	</div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label class=" form-control-label">Username</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <p class="form-control-static"><?php echo $username;?></p>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="text-input" class=" form-control-label">First Name</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <p class="form-control-static"><?php echo $firstname;?></p>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="text-input" class=" form-control-label">Last Name</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <p class="form-control-static"><?php echo $lastname;?></p>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="email-input" class=" form-control-label">Email</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <p class="form-control-static"><?php echo $email;?></p>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="password-input" class=" form-control-label">Date of Birth</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <p class="form-control-static"><?php echo $birthday;?></p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                 <div class="card">
                                    <div class="card-header">
                                        <strong>Update Your Information</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col-md-4">
                                                    <label for="file-input" class=" form-control-label">Avatar</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <img id="avatar" src="https://via.placeholder.com/150" alt="Your Avatar" >
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-7">
                                                    <input type="file" id="fileToUpload" name="fileToUpload" class="form-control-file" accept="image/*" onchange="readURL(this);">
                                                </div>
                                                <div class="col-md-3"></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="text-input" class=" form-control-label">First Name</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" id="text-input" name="firstname" placeholder="first name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="text-input" class=" form-control-label">Last Name</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" id="text-input" name="lastname" placeholder="last name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="email-input" class=" form-control-label">Email</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="email" id="email" name="email" placeholder="name@example.com" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="password-input" class=" form-control-label">Date of Birth</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="date" name="birthday" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-5"></div>
                                            <div class="col-md-7">
                                                <button id="upload" name="update" type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-dot-circle-o"></i> Update
                                                </button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                    <div class="card-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script>
		function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#avatar')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
	</script>
    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->