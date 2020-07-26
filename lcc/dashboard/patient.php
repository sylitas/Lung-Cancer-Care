
<?php
    require_once "../vendor/autoload.php";
    use \Firebase\JWT\JWT;
    session_start();
    include("../database_connection.php");

    if(!isset($_COOKIE['lcc'])){
        header('Location: ../../../../../../lungcancer/login');
    }
    if(isset($_GET['id'])){
        $checkpatient = $_GET['id'];
    }else{
        header('Location: ../../../../../../lungcancer/login');
    }
    //decode----------------------------------------------------------take id
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
    //---------------------data form login table --------------------------
    $select = "SELECT username,email FROM doctor WHERE id = '$checkaccount'";
    $result = mysqli_query($connection,$select);
    $u = mysqli_fetch_array($result);
        $username = $u["username"];
        $email = $u["email"];
        if($email == null){$email = "Please Update the Email";} 
    //-----------------------check avatar---------------------------
    $destination = "images/avatar/profile_".$checkaccount.".png";
    if(!file_exists($destination)){
        $path = "images/avatar/profile_0.png";
    }else{
        $path = "images/avatar/profile_".$checkaccount.".png";
    }   
    // --------------------------------end---------------------------------    
    //---------------------data form patientx table -------------------------
    $patientdata = "SELECT * FROM patient WHERE doctor_id = '$checkaccount'";
    $rsdata = mysqli_query($connection,$patientdata);
    $y = mysqli_fetch_array($rsdata);
        $date = $y["date"];
        $id = $y["id-patient"];
        $name = $y["name"];
        $gender = $y["gender"];
        
        if($y["birthday"] == null){
            $birthday = "None";
        }else{
            $birthday = $y["birthday"];
        }

        if($y["address"] == null){
            $address = "None";
        }else{
            $address = $y["address"];
        }
        
        if($y["phone"] == null){
            $phone = "None";
        }else{
            $phone = $y["phone"];
        }

        if($gender == "n"){
            $gender = "Other";
        }elseif($gender == "m"){
            $gender = "Male";
        }else{
            $gender = "Female";
        }
        if($birthday == null){$birthday = "None";}
        if($address == null){$address = "None";}
    // --------------------------------end---------------------------------
        include("uploadZipfile.php");
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <title>Patient Details</title>

    <!-- Fontfaces CSS-->
    <link href="/Git-lcc/internship-project/lcc/dashboard/css/font-face.css" rel="stylesheet" media="all">
    <link href="/Git-lcc/internship-project/lcc/dashboard/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="/Git-lcc/internship-project/lcc/dashboard/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="/Git-lcc/internship-project/lcc/dashboard/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="/Git-lcc/internship-project/lcc/dashboard/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="/Git-lcc/internship-project/lcc/dashboard/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="/Git-lcc/internship-project/lcc/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="/Git-lcc/internship-project/lcc/dashboard/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="/Git-lcc/internship-project/lcc/dashboard/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="/Git-lcc/internship-project/lcc/dashboard/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="/Git-lcc/internship-project/lcc/dashboard/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="/Git-lcc/internship-project/lcc/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="/Git-lcc/internship-project/lcc/dashboard/css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="/Git-lcc/internship-project/lcc/dashboard/css/main.css">
</head>
<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href= "../../../../lungcancer/home">
                            <img src="/Git-lcc/internship-project/lcc/dashboard/images/icon/LogoNew-mini.png" />
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
                            <a class="js-arrow" href="../../../../lungcancer/home"><i class="fas fa-list-alt"></i>Patient's Data</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="../../../../lungcancer/home">
                    <img src="/Git-lcc/internship-project/lcc/dashboard/images/icon/LogoNew-mini.png" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="../../../../lungcancer/home"><i class="fas fa-list-alt"></i>Patient's Data</a>
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
                            <h2>Patient Details</h2>
                            <div class="header-button">
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
<?php
                                            echo '<img src ="/Git-lcc/internship-project/lcc/dashboard/'.$path.'"/>'
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
                                            echo '<img src ="/Git-lcc/internship-project/lcc/dashboard/'.$path.'"/>'
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
                                                    <a href="../../../../../../lungcancer/home/form">
                                                        <i class="zmdi zmdi-account"></i>Account</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="../../../../../lungcancer/login?logout=1"><i class="zmdi zmdi-power"></i>Logout</a>
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
                    <!--design-->
                    <div class="row">
                       <div class="col-lg-12">
                            <!-- USER DATA-->
                            <div class="header-wrap">
                                <h3 class="title-3 m-b-30">
                                    <i class="zmdi zmdi-account-calendar"></i><?php echo $name; ?>'s information
                                </h3>
                                <!-- <button id="myBtn2" class="btn btn-primary btn-lg">
                                    Edit
                                </button> -->
                            </div>
                            <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Fullname</th>
                                                <th class="text-center">Gender</th>
                                                <th class="text-right">Date Of Birth</th>
                                                <th class="text-right">Phone number</th>
                                                <th class="text-right">Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $id; ?></td>
                                                <td><?php echo $name; ?></td>
                                                <td class="text-center"><?php echo $gender; ?></td>
                                                <td class="text-right"><?php echo $birthday; ?></td>
                                                <td class="text-right"><?php echo $phone; ?></td>
                                                <td class="text-right"><?php echo $address; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <!-- END USER DATA-->
                        </div>
                    </div>
                    <div class="user-data m-b-30">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="header-wrap" style="padding-bottom: 13px;">
                                <h3 class="title-3 m-b-30">CT Files Management</h3>
                                <div>
                                    <i class="fa fa-search"></i>
                                    <input class="au-input" type="text" name="" id="myInput" onkeyup="myFunction()" placeholder=" Search filename" style="width: 400px !important;" />
                                </div>
                                <button id="myBtn" class="btn btn-primary btn-lg" style="margin-right: 20px !important;">
                                    <i class="zmdi zmdi-plus"></i> Upload
                                </button>
                            </div>
                           <div class="table-responsive table-data">
                                    <table class="table" id="myTable">
                                        <thead>
                                            <tr>
                                                <td><h4>File Name</h4></td>
                                                <td class="text-right"><h4>Date Upload</h4></td>
                                                <td class="text-center"><h4>More Detais</h4></td>
                                                <td class="text-center"><h4>Download</h4></td>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$ctfilepath = "SELECT * FROM patientfile WHERE patient_id = '$checkpatient'";
$querydata = mysqli_query($connection,$ctfilepath);
while($row = mysqli_fetch_array($querydata)){
    $link="'../../../../../../../lungcancer/home/patient/".$checkpatient."/presenter/".$row['id']."'";
?>
                                        <tr>
                                            <td>
                                                <div class="table-data__info">
                                                    <p><?php echo substr($row['path'],8); ?></p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="table-data__info">
                                                    <p class="text-right"><?php echo $row['date']; ?></p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="table-data__info" onclick="window.location=<?php echo $link; ?>;" style="cursor: pointer";>
                                                    <p class = "text-center"><u>View</u></p>
                                                </div>
                                            </td>
                                            <td>
                                                <?php          
                                                echo '<div class="table-data__info text-center">
                                                    <a href="'.$row['path'].'" download="'.substr($row['path'],8).'" target = "_blank"><u>Save</u><a/>
                                                </div>';
                                                ?>

                                            </td>
                                        </tr>
<?php
                                            }
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div id="myModal" class="modal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <span class="close">&times;</span>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-center title-2">File Uploader</h3>
                                    </div>
                                    <hr>
                                    <form id="myForm" action="" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <label for="file-input" class=" form-control-label">File input (Zipfile Only)</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="file" id="" name="upZip" class="form-control-file" accept=".zip">
                                            </div>
                                        </div>
                                        <br>
                                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block" name="up">
                                            <span id="payment-button-amount">Submit</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal-Box-1 -->
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
    </script>
    <!--Searchbar-->
    <script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
    </script>
    </script>
    <!-- Jquery JS-->
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/slick/slick.min.js">
    </script>
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/wow/wow.min.js"></script>
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/animsition/animsition.min.js"></script>
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="/Git-lcc/internship-project/lcc/dashboard/vendor/select2/select2.min.js">
    </script>
    <!-- Main JS-->
    <script src="/Git-lcc/internship-project/lcc/dashboard/js/main.js"></script>
</body>
</html>