<?php
if(isset($_POST['up'])){
    if(file_exists($_FILES['upZip']['tmp_name']) || is_uploaded_file($_FILES['upZip']['tmp_name'])){
        $uploadOk = 1;
        $tail = explode('.', $_FILES['upZip']['name']);
        $tail = strtolower($tail[(count($tail) - 1)]);
        if($tail != "zip") {
          $uploadOk = 0;
          ?>
          <script type="text/javascript">
              alert("Only .Zip file is allowed ! Please zip file to format .zip");
          </script>
          <?php
        }
        if ($uploadOk != 0) {
            $destination = "ctfiles/".$_FILES['upZip']['name'];
            move_uploaded_file($_FILES["upZip"]["tmp_name"], $destination);
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $datetime = date("Y-m-d H:i:s");
            $INSERT = "INSERT INTO `patientfile` (`patient_id`,`date`,`path`) VALUES (?,?,?)";
            $stmt = $connection->prepare($INSERT);
            $stmt->bind_param("sss",$checkpatient,$datetime,$destination);
            $stmt->execute();

            //--unZip file---for loading images

            $zip = new ZipArchive;
            if ($zip->open($destination) === TRUE) {
                $zip->extractTo('ctfiles/extract/');
                $zip->close();
            }
        }
    }
}

?>