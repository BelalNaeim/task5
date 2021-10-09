<?php

$filename = "personInfo.txt";
$handle = fopen($filename,'r') or die ("can't open file");
$data = fread($handle,filesize($filename));
    # code...
    echo "<h1>Profile Data</h1>".'<br>';
    if ($cv_file = isset($_COOKIE["cvfileName"]) ? $_COOKIE["cvfileName"] : "") {
        echo"<textarea cols='25' rows='10'>$data.$cv_file
        </textarea>";
    }
    fclose($handle);



?>

