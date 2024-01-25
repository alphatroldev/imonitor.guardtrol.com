<!DOCTYPE>
<html>
  <head>
    <title>Guardtrol APP Download</title>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <!--<a href="/home/guardtro/imonitor.guardtrol.com/public/uploads/apkVersion/<?=$v_file_name;?>" download>Download Here</a>-->
    
    
    <?php
        // echo $fileSizeInBytes=filesize("/home/guardtro/imonitor.guardtrol.com/public/uploads/apkVersion/".$v_file_name);
        // echo '<a href="/home/guardtro/imonitor.guardtrol.com/public/uploads/apkVersion/'.$v_file_name.'" download>Download Here</a>';
        
        // Remote download URL
        $remoteURL = '/home/guardtro/imonitor.guardtrol.com/public/uploads/apkVersion/'.$v_file_name;
        
        // Force download
        header("Content-type: application/apk"); 
        header("Content-Disposition: attachment; filename=".basename($remoteURL));
        ob_end_clean();
        readfile($remoteURL);
        exit;
    ?>
  </body>
</html>