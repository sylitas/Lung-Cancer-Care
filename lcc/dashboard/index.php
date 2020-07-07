<?php
    require_once "../vendor/autoload.php";
    use \Firebase\JWT\JWT;
    session_start();
    include("../database_connection.php");

    
    if(!isset($_COOKIE['lcc'])){
        header('Location: ../login.php');
    }


    //decode
    $jwt = $_COOKIE['lcc'];
    $key = "LungCancerCareUSTH";
    try{
        $jwt_decode = JWT::decode($jwt, $key, array('HS256'));
        $array = (array)$jwt_decode;
        $checkaccount = $array["id"];
    }catch(Exception $e){   
        echo $e->getMessage();
    }
    
    $select = "SELECT username,email,`path` FROM login WHERE id = '$checkaccount'";
    $result = mysqli_query($connection,$select);
    $u = mysqli_fetch_array($result);
        $username = $u["username"];
        $email = $u["email"];
        if($email == null){$email = "Please Update the Email";}
        $path = $u["path"];
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
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
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
    <link href="css/main.css" rel="stylesheet">

</head>

<body class="animsition">
    <div class="page-wrapper">
       <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="indexphp">
                            <img src="images/icon/LogoNew-mini.png" />
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
                            <a class="js-arrow" href="#"><i class="fas fa-list-alt"></i>Data</a>
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
                    <img src="images/icon/LogoNew-mini.png" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="#"><i class="fas fa-list-alt"></i>Data</a>
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
                            <form class="form-header" action="" method="POST">
                                <input class="au-input au-input--xl" type="text" name="inputsearch" placeholder="Search for ID, Phonenumber or Name of Patient" />
                                <button class="au-btn--submit" type="submit" name="search">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                            <div class="header-button">
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
<?php
                                            echo '<img src ="'.$path.'"/>'
?>
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#"><?php echo $username;?></a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
<?php
                                            echo '<img src ="'.$path.'"/>'
?>
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#"><?php echo $username;?></a>
                                                    </h5>
                                                    <span class="email"><?php echo $email;?></span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="form.php">
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
                    <!--<div class="container-fluid">
                         <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1"><b>Overview</b></h2>
                                </div>
                            </div>
                        </div> 
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                <h2>0</h2>
                                                <span>#text</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-shopping-cart"></i>
                                            </div>
                                            <div class="text">
                                                <h2>0</h2>
                                                <span>#text</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-calendar-note"></i>
                                            </div>
                                            <div class="text">
                                                <h2>0</h2>
                                                <span>#text</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-money"></i>
                                            </div>
                                            <div class="text">
                                                <h2>0</h2>
                                                <span>#text</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="overview-wrap">
                                            <h2 class="title-1"><b>Data</b></h2>
                                            <button id="myBtn" class="btn btn-primary btn-lg">
                                                <i class="zmdi zmdi-plus"></i>Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal-Box -->
                            <div id="myModal" class="modal">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close">&times;</span>
                                    </div>
                                    <div class="card">
                                            <div class="card-body">
                                            <div class="card-title">
                                                <h3 class="text-center title-2">Patient Details</h3>
                                            </div>
                                            <hr>
                                            <form id="myForm" action="" method="POST" novalidate="novalidate">
                                                <div class="form-group">
                                                    <label for="cc-payment" class="control-label mb-1">ID patient</label>
                                                    <input id="cc-pament" name="idpatient" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="cc-name" class="control-label mb-1">Full Name</label>
                                                    <input id="cc-name" name="namepatient" type="text" class="form-control cc-name valid" data-val="true"
                                                        autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error" required>
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label class="control-label mb-1">Phone Number</label>
                                                    <input name="phonepatient" type="text" class="form-control cc-name valid" data-val="true"
                                                        autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error" required>
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label class="control-label mb-1">Address</label>
                                                    <input name="addresspatient" type="text" class="form-control cc-name valid" data-val="true"
                                                        autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error" required>
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col col-md-3">
                                                        <label for="select" class=" form-control-label">Gender</label>
                                                    </div>
                                                    <div class="col-12 col-md-9">
                                                        <select name="genderpatient" id="select" class="form-control" required>
                                                            <option value="null" selected>None</option>
                                                            <option value="m">Male</option>
                                                            <option value="f">Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col col-md-3">
                                                        <label for="select" class=" form-control-label">Birthday</label>
                                                    </div>
                                                    <div class="col-12 col-md-9">
                                                        <input id="" name="birthdaypatient" type="date" class="form-control cc-name valid" data-val="true"
                                                        autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error" required>
                                                    </div>
                                                </div>
                                                <!-- <div class="row form-group">
                                                    <div class="col col-md-3">
                                                        <label for="file-input" class=" form-control-label">File input (Zipfile Only)</label>
                                                    </div>
                                                    <div class="col-12 col-md-9">
                                                        <input type="file" id="zipfile" name="filepatient" class="form-control-file" accept=".zip,.rar,.7zip">
                                                    </div>
                                                </div> -->

                                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block" name="uploadfile">
                                                    <span id="payment-button-amount">Submit</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-card m-b-40" style="margin-top: 10px;">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th>Date Uploaded</th>
                                                <th>ID Patient</th>
                                                <th>Name</th>
                                                <th class="text-right">Gender</th>
                                                <th class="text-right">Birthday</th>
                                                <th class="text-right">Phone Number</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
<?php
    

    if(isset($_POST['uploadfile'])){
        if ($_POST['idpatient'] == null ||
            $_POST['namepatient'] == null ||
            $_POST['genderpatient'] == null ) {
?>
    <script type="text/javascript">
        alert("Missing Information");
    </script>
<?php
        }else{
            $id = $_POST['idpatient'];
            $name = $_POST['namepatient'];
            $gender = $_POST['genderpatient'];

            if($_POST['phonepatient'] == null){
                $phone = null;
            }else{
                $phone = $_POST['phonepatient'];
            }

            if($_POST['birthdaypatient'] == null){
                $birthday = null;
            }else{
                $birthday = $_POST['birthdaypatient'];
            }

            if($_POST['addresspatient'] == null){
                $address = null;
            }else{
                $address = $_POST['addresspatient'];
            }

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date("Y-m-d H:i:s");
            $INSERT = "INSERT Into `ctdata` (`date`,`id-patient`,checkaccount,name,gender,birthday,address,phonenumber) values (?,?,?,?,?,?,?,?)";
            $stmt = $connection->prepare($INSERT);
            $stmt->bind_param("ssssssss",$date,$id,$checkaccount,$name,$gender,$birthday,$address,$phone);
            $stmt->execute();
            $query = "SELECT * FROM ctdata WHERE checkaccount = '$checkaccount'";
        }
    }

    if(isset($_POST['search'])){
        $search = $_POST['inputsearch'];
        //non-injection
        $search = stripcslashes($search);
        $search = mysqli_real_escape_string($connection,$search);
        
        if($_POST['inputsearch'] == ""){
            $query = "SELECT * FROM ctdata WHERE checkaccount = '$checkaccount'";
        }else{
            $query = "SELECT * FROM ctdata WHERE checkaccount = '$checkaccount' AND (name = '$search' OR `id-patient` = '$search' OR `phonenumber` = '$search')";
        }
    }else{
        $query = "SELECT * FROM ctdata WHERE checkaccount = '$checkaccount'";
    }
    $result = mysqli_query($connection,$query);
    while($row = mysqli_fetch_array($result)){
        
        if ($row['gender']=="m") {
            $row['gender'] = "Male";
        }elseif($row['gender']=="n"){
            $row['gender'] = "Other";
        }else{
            $row['gender'] = "Female";
        }

        if($row['phonenumber'] == null){
            $row['phonenumber'] = "None";
        }
        if($row['birthday'] == null){
            $row['birthday'] = "None";
        }
        $link="'patient.php?id=".$row['id']."'";
    echo'                                       <tr onclick="window.location='.$link.';">
                                                <td>'.$row['date'].'</td>
                                                <td>'.$row['id-patient'].'</td>
                                                <td>'.$row['name'].'</td>
                                                <td class="text-right">'.$row['gender'].'</td>
                                                <td class="text-right">'.$row['birthday'].'</td>
                                                <td class="text-right">'.$row['phonenumber'].'</td>
                                                </tr>
            ';
                                             }
?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
    <script>
        $(document).ready(function() {
            $('#example tr').click(function() {
                var href = $(this).find("a").attr("href");
                if(href) {
                    window.location = href;
                }
            });

        });
    </script>
    <script>
        function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };
        $(document).on("keydown", disableF5);
    </script>
    <!-- Modal-Box -->
    <script>
    // Get the modal
    var modal = document.getElementById("myModal");
    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    // When the user clicks the button, open the modal 
    btn.onclick = function() {
      modal.style.display = "block";
    }
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
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