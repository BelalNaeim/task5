<?php
$filename = 'personInfo.txt';
$handle = fopen($filename,'r');
$data = fread($handle,filesize($filename));
    # code...
    echo "<h1>Profile Data</h1>";
    if(isset($_COOKIE["cv_file"]) ? $_COOKIE["cv_file"] : ""){
        $cv_file = $_COOKIE['cv_file'];
    echo"<textarea rows='10' cols='22'>
        $data . $cv_file
    </textarea>";
}
fclose($handle);



?>

