<?php
    require_once "../vendor/autoload.php";
    use \Firebase\JWT\JWT;
    session_start();
    include("../database_connection.php");

    
    if(!isset($_COOKIE['lcc'])){
        header('Location: ../../../../../../lungcancer/login');
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
    $checkpatient = $_GET['id'];
    $file = $_GET['file'];
    
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
 ?>

<!DOCTYPE html>
<html lang="en" style="scroll-behavior: smooth;">

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
    <link href="/Git-lcc/internship-project/lcc/dashboard/css/main.css" rel="stylesheet">
    <!-- ------------------------------------------ -->
    <script src="https://unpkg.com/hammerjs@2.0.8/hammer.js"></script>
    <script src="https://unpkg.com/dicom-parser@1.8.3/dist/dicomParser.min.js"></script>

    <!-- include the cornerstone library -->
    <script src="https://unpkg.com/cornerstone-core"></script>
    <script src="https://unpkg.com/cornerstone-math"></script>
    <script src="https://unpkg.com/cornerstone-wado-image-loader"></script>

    <script src="https://unpkg.com/cornerstone-tools@%5E4"></script>
    <style>

/* The container <div> - needed to position the dropdown content */
.dropbtn {
  border: none;
  cursor: pointer;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  right: 0;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1;}
.dropdown:hover .dropdown-content {display: block;}
.dropdown:hover .dropbtn {background-color: #626562;}

        .overlay {
            /* prevent text selection on overlay */
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;

            /* ignore pointer event on overlay */
            pointer-events: none;
        }
    </style>
</head>

<body class="animsition" >
    <div class="page-wrapper">
       <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="../../../../../../lungcancer/home">
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
                            <a class="js-arrow" href="../../../../../../lungcancer/home"><i class="fas fa-list-alt"></i>Patient's Data</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow open" href="#"><i class="fas fa-paperclip"></i>CT Document</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" style="display: block;">
                                <li>
                                    <a href="#dicom-viewer"><i class="fas fa-caret-right"></i>Dicom Viewer</a>
                                </li>
                                <li>
                                    <a href="#file-details"><i class="fas fa-caret-right"></i>File Details</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="../../../../../../lungcancer/home">
                    <img src="/Git-lcc/internship-project/lcc/dashboard/images/icon/LogoNew-mini.png" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="../../../../../../lungcancer/home"><i class="fas fa-list-alt"></i>Patient's Data</a>
                        </li>
                        <li class="active has-sub">
                            <a class="js-arrow open" href="#"><i class="fas fa-paperclip"></i>CT Document</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" style="display: block;">
                                <li>
                                    <a href="#dicom-viewer"><i class="fas fa-caret-right"></i>Dicom Viewer</a>
                                </li>
                                <li>
                                    <a href="#file-details"><i class="fas fa-caret-right"></i>File Details</a>
                                </li>
                            </ul>
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
                            <h2>CT Document</h2>
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
                                                    <a href="../../../../../../../lungcancer/home/form">
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
            <div class="main-content" id="dicom-viewer">
                <div class="section__content section__content--p30">
                    <div class="row">
                        <div  class="col-md-12" >
                            <div class="row" >
                                <div class="col-md-12" style="background-color: black;">
                                    <div class="row" style="width:100%;height:auto;">
                                        <div class="col-md-4">
                                            <h2 style="color: #B3AFAF;padding-top: 20px;">Dicom Viewer</h2><br>
                                            <button id="x512" class="btn btn-outline-secondary btn-sm" style="margin-bottom: 10px;right: 0px;"><i class="fa fa-expand"></i> 512x512</button><br>
                                            <button id="x256" class="btn btn-outline-secondary btn-sm" style="margin-bottom: 10px;right: 0px;"><i class="fa fa-compress"></i> 256x256</button><br>
                                             <button id="hflip" class="btn btn-outline-secondary btn-sm" style="margin-bottom: 10px;right: 0px;">X-flip</button>
                                            <button id="vflip" class="btn btn-outline-secondary btn-sm" style="margin-bottom: 10px;right: 0px;">Y-flip</button><br>
                                            <button id="rotate" class="btn btn-outline-secondary btn-sm" style="margin-bottom: 10px;right: 0px;"><i class="fa fa-repeat"></i> 90 Rotation</button><br>
                                            <button id="invert" class="btn btn-outline-secondary btn-sm" style="margin-bottom: 10px;right: 0px;"><i class="fa fa-eye-slash"></i> Invert Image</button><br>
                                            <div id="topright" class="overlay" style="left:0px; ">
                                                Render:
                                            </div>
                                            <div id="bottomright" class="overlay" style="left:0px;">
                                                Zoom:
                                            </div>
                                            <div id="bottomleft" class="overlay" style="left:0px;">
                                                WW/WC:
                                            </div>
                                            <div><span id="coord1s"></span></div>
                                            <div><span id="coord2s"></span></div>
                                            <div><span id="coord3s"></span></div>
                                            <div><span id="coord4s"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div 
                                            id="cornerstone-element" 
                                            class="cornerstone-element" 
                                            data-index="0" 
                                            oncontextmenu="return false"
                                            style="width:512px;height:512px; margin: auto;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown" style="right:0px;position: absolute;">
                                  <button class="dropbtn btn btn-secondary btn-lg"><i class="fa fa-bars"></i></button>
                                  <div class="dropdown-content">
                                    <button id="zoomFunc" class="btn btn-outline-secondary btn-sm" style="width: 100%;">Zoom</button>
                                    <button id="panFunc" class="btn btn-outline-secondary btn-sm" style="width: 100%;">Pan</button>
                                    <button id="lengthFunc" class="btn btn-outline-secondary btn-sm" style="width: 100%;">Length</button>
                                    <button id="markerFunc" class="btn btn-outline-secondary btn-sm" style="width: 100%;">Marker</button>
                                    <button id="magnifyFunc" class="btn btn-outline-secondary btn-sm" style="width: 100%;">Magnify</button>
                                    <button id="wwwcFunc" class="btn btn-outline-secondary btn-sm" style="width: 100%;">WWWC</button>
                                    <button id="rotateFunc" class="btn btn-outline-secondary btn-sm" style="width: 100%;">Rotate</button>
                                    <button id="angleFunc" class="btn btn-outline-secondary btn-sm" style="width: 100%;">Angle</button>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 30px;" id = "file-details">
                            <div class="user-data m-b-30">
                                    <dir class="row">
                                        <div class="col-md-3"><h2 style="margin-left: 30px;">File Details</h2></div>
                                        <div class="col-md-9" style="padding-left: 0 !important;">
                                            <i class="fa fa-search"></i>
                                            <input style="width: 500px !important;" class="au-input" type="text" name="" id="myInput" onkeyup="myFunction()" placeholder=" Search filename"  />
                                        </div>
                                    </dir>
                                <div class="table-responsive table-data">
                                    <table class="table" id="myTable">
                                        <thead>
                                            <tr>
                                                <td><h4>Name</h4></td>
                                                <td class="text-center"><h4>Type</h4></td>
                                                <td class="text-center"><h4>Size</h4></td>
                                                <td class="text-center"><h4>Save</h4></td>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
if(isset($_GET['file'])){
    $getfile = $_GET['file'];
    $ctfilepath = "SELECT * FROM patientfile WHERE id = '$getfile'";
    $querydata = mysqli_query($connection,$ctfilepath);
    $row = mysqli_fetch_array($querydata);
    $filenameXX = pathinfo($row['path'],PATHINFO_FILENAME);
    $zip = zip_open($row['path']);
    if ($zip) {
      while ($zip_entry = zip_read($zip)) {
        $zipfilePath = zip_entry_name($zip_entry);
        $zipfilePath_encode = base64_encode($zipfilePath);
        $checkfilepath = pathinfo($zipfilePath."/",PATHINFO_FILENAME);
        $extfile = pathinfo($zipfilePath,PATHINFO_EXTENSION);
        $zipfilesize = number_format(((float)zip_entry_filesize($zip_entry)/1024),3);
        
?>
                                            <tr>
                                                <td>
                                                    <div class="table-data__info ">
                                                        <h6><?php echo $checkfilepath; ?></h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-data__info text-center">
                                                        <h6><?php echo $extfile; ?></h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-data__info text-center">
                                                        <?php echo $zipfilesize." KB"; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-data__info text-center">
<?php
                                                        echo'<h6><a href="'.$zipfilePath.'" target="_blank" download = "'.$zipfilePath.'"><u>Download</u></a></h6>';
?>
                                                    </div>
                                                </td>
                                            </tr>
<?php
        }
    zip_close($zip);
    }
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
    <!-- include the cornerstone library -->

<script>
  const baseUrl = 'http://localhost/git-lcc/internship-project/lcc/dashboard/ctfiles/extract/';

  _initCornerstone();
  _initInterface();

  const element = document.querySelector('.cornerstone-element');

  // Init CornerstoneTools
  cornerstoneTools.init();
  cornerstone.enable(element);
  const toolName = 'StackScrollMouseWheel';
  const imageIds = [];
  var pathImagename = "<?php Print($filenameXX); ?>";

for (let i = 1; i < 200; i++) {
    var y = i.toString();
    if(y.length == 1){
      var filename = '00' + i;
    }
    if(y.length == 2){
      var filename = '0' + i;
    }
    imageIds.push(
      'wadouri:' + baseUrl +pathImagename +'/IMG-0017-00'+ filename +'.dcm'
    );
  }

  const stack = {
    currentImageIdIndex: 0,
    imageIds: imageIds,
  };

  element.tabIndex = 0;
  element.focus();

  cornerstone.loadImage(imageIds[0]).then(function(image) {
    cornerstone.displayImage(element, image);
    cornerstoneTools.addStackStateManager(element, ['stack']);
    cornerstoneTools.addToolState(element, 'stack', stack);
  });

  // Add the tool
  const apiTool = cornerstoneTools[`${toolName}Tool`];
  cornerstoneTools.addTool(apiTool);
  cornerstoneTools.setToolActive(toolName, { mouseButtonMask: 1 });
  const ZoomTool = cornerstoneTools.ZoomTool;

    cornerstoneTools.addTool(cornerstoneTools.ZoomTool, {
      // Optional configuration
      configuration: {
        invert: false,
        preventZoomOutsideImage: false,
        minScale: .1,
        maxScale: 20.0,
      }
    });
    cornerstoneTools.setToolActive('Zoom', { mouseButtonMask: 1 })
    //add more
    const ScaleOverlayTool = cornerstoneTools.ScaleOverlayTool;

    cornerstoneTools.addTool(ScaleOverlayTool)
    cornerstoneTools.setToolActive('ScaleOverlay', { mouseButtonMask: 1 })

  function _initCornerstone() {
    // Externals
    cornerstoneWADOImageLoader.external.cornerstone = cornerstone;
    cornerstoneWADOImageLoader.external.dicomParser = dicomParser;
    cornerstoneTools.external.cornerstoneMath = cornerstoneMath;
    cornerstoneTools.external.cornerstone = cornerstone;
    cornerstoneTools.external.Hammer = Hammer;

    // Image Loader
    const config = {
      webWorkerPath: `${baseUrl}assets/image-loader/cornerstoneWADOImageLoaderWebWorker.js`,
      taskConfiguration: {
        decodeTask: {
          codecsPath: `${baseUrl}assets/image-loader/cornerstoneWADOImageLoaderCodecs.js`,
        },
      },
    };
    cornerstoneWADOImageLoader.webWorkerManager.initialize(config);
  }

  /***
   *
   *
   */
  function _initInterface() {
    const handleClick = function(evt) {
      const action = this.dataset.action;
      const options = {
        mouseButtonMask:
          evt.buttons || convertMouseEventWhichToButtons(evt.which),
      };

      cornerstoneTools[`setTool${action}`](toolName, options);

      // Remove active style from all buttons
      const buttons = document.querySelectorAll('.set-tool-mode');
      buttons.forEach(btn => {
        btn.classList.remove('is-primary');
      });

      // Add active style to this button
      this.classList.add('is-primary');

      evt.preventDefault();
      evt.stopPropagation();
      evt.stopImmediatePropagation();
      return false;
    };

    const buttons = document.querySelectorAll('.set-tool-mode');

    buttons.forEach(btn => {
      btn.addEventListener('contextmenu', handleClick);
      btn.addEventListener('auxclick', handleClick);
      btn.addEventListener('click', handleClick);
    });
  }

  const convertMouseEventWhichToButtons = which => {
    switch (which) {
      // no button
      case 0:
        return 0;
      // left
      case 1:
        return 1;
      // middle
      case 2:
        return 4;
      // right
      case 3:
        return 2;
    }
    return 0;
  };
</script>
<script>
    // setup handlers before we display the image
    function onImageRendered(e) {
        const eventData = e.detail;

        // set the canvas context to the image coordinate system
        cornerstone.setToPixelCoordinateSystem(eventData.enabledElement, eventData.canvasContext);

        // NOTE: The coordinate system of the canvas is in image pixel space.  Drawing
        // to location 0,0 will be the top left of the image and rows,columns is the bottom
        // right.
        const context = eventData.canvasContext;
        context.beginPath();
        context.strokeStyle = 'white';
        context.lineWidth = .5;
        context.rect(128, 90, 50, 60);
        context.stroke();
        context.fillStyle = "white";
        context.font = "6px Arial";
        context.fillText("Tumor Here", 128, 85);

        document.getElementById('topright').textContent = "Render Time:" + eventData.renderTimeInMs + " ms";
        document.getElementById('bottomleft').textContent = "WW/WL:" + Math.round(eventData.viewport.voi.windowWidth) + "/" + Math.round(eventData.viewport.voi.windowCenter);
        document.getElementById('bottomright').textContent = "Zoom:" + eventData.viewport.scale.toFixed(2);


    }
    element.addEventListener('cornerstoneimagerendered', onImageRendered);
    // Add event handler to the ww/wc apply button
        document.getElementById('x256').addEventListener('click', function (e) {
            element.style.width = '256px';
            element.style.height = '256px';
            cornerstone.resize(element);
        });

        document.getElementById('x512').addEventListener('click', function (e) {
            element.style.width = '512px';
            element.style.height = '512px';
            cornerstone.resize(element);
        });

        document.getElementById('invert').addEventListener('click', function (e) {
            const viewport = cornerstone.getViewport(element);
            viewport.invert = !viewport.invert;
            cornerstone.setViewport(element, viewport);
        });

        // document.getElementById('interpolation').addEventListener('click', function (e) {
        //     const viewport = cornerstone.getViewport(element);
        //     viewport.pixelReplication = !viewport.pixelReplication;
        //     cornerstone.setViewport(element, viewport);
        // });
        document.getElementById('hflip').addEventListener('click', function (e) {
            const viewport = cornerstone.getViewport(element);
            viewport.hflip = !viewport.hflip;
            cornerstone.setViewport(element, viewport);
        });
        document.getElementById('vflip').addEventListener('click', function (e) {
            const viewport = cornerstone.getViewport(element);
            viewport.vflip = !viewport.vflip;
            cornerstone.setViewport(element, viewport);
        });
        document.getElementById('rotate').addEventListener('click', function (e) {
            const viewport = cornerstone.getViewport(element);
            viewport.rotation += 90;
            cornerstone.setViewport(element, viewport);
        });
        document.getElementById('lengthFunc').addEventListener('click', function (e) {
            const LengthTool = cornerstoneTools.LengthTool;
            cornerstoneTools.addTool(LengthTool)
            cornerstoneTools.setToolActive('Length', { mouseButtonMask: 1 })
        });
        document.getElementById('markerFunc').addEventListener('click', function (e) {
            const TextMarkerTool = cornerstoneTools.TextMarkerTool
            const configuration = {
              markers: ['F5', 'F4', 'F3', 'F2', 'F1'],
              current: 'F5',
              ascending: true,
              loop: true,
            }
            cornerstoneTools.addTool(TextMarkerTool, { configuration })
            cornerstoneTools.setToolActive('TextMarker', { mouseButtonMask: 1 })
        });
        document.getElementById('magnifyFunc').addEventListener('click', function (e) {
            const MagnifyTool = cornerstoneTools.MagnifyTool;

            cornerstoneTools.addTool(MagnifyTool)
            cornerstoneTools.setToolActive('Magnify', { mouseButtonMask: 1 })
        });
        document.getElementById('panFunc').addEventListener('click', function (e) {
            const PanTool = cornerstoneTools.PanTool;
            cornerstoneTools.addTool(PanTool)
            cornerstoneTools.setToolActive('Pan', { mouseButtonMask: 1 })
        });

        document.getElementById('wwwcFunc').addEventListener('click', function (e) {
            const WwwcTool = cornerstoneTools.WwwcTool;
            cornerstoneTools.addTool(WwwcTool)
            cornerstoneTools.setToolActive('Wwwc', { mouseButtonMask: 1 })
        });
        document.getElementById('rotateFunc').addEventListener('click', function (e) {
            const RotateTool = cornerstoneTools.RotateTool;
            cornerstoneTools.addTool(RotateTool)
            cornerstoneTools.setToolActive('Rotate', { mouseButtonMask: 1 })
        });
        document.getElementById('zoomFunc').addEventListener('click', function (e) {
            const ZoomTool = cornerstoneTools.ZoomTool;

            cornerstoneTools.addTool(cornerstoneTools.ZoomTool, {
              // Optional configuration
              configuration: {
                invert: false,
                preventZoomOutsideImage: false,
                minScale: .1,
                maxScale: 20.0,
              }
            });
            cornerstoneTools.setToolActive('Zoom', { mouseButtonMask: 1 })
        });
        document.getElementById('angleFunc').addEventListener('click', function (e) {
            const AngleTool = cornerstoneTools.AngleTool;
            cornerstoneTools.addTool(AngleTool)
            cornerstoneTools.setToolActive('Angle', { mouseButtonMask: 1 })
        });

        element.addEventListener('mousemove', function(event) {
            const pixelCoords = cornerstone.pageToPixel(element, event.pageX, event.pageY);
            document.getElementById('coord1s').textContent = "PageX= " + event.pageX;
            document.getElementById('coord2s').textContent = "PageY= " + event.pageY;
            document.getElementById('coord3s').textContent = "PixelX= " + pixelCoords.x;
            document.getElementById('coord4s').textContent = "PixelY= " + pixelCoords.y;
        });
</script>
<script></script>

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
<!-- end document-->