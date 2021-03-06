<?php
include 'validate.php';

#//validation processes//#
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name       = clean($_POST['name']);
    $email      = clean($_POST['email']);
    $password   = md5(clean($_POST['password']));
    $address    = clean($_POST['address']);
    $linked     = clean($_POST['linkedinurl']);

    $error_msg = [];

#Name validation
if(!validate($name,1)){
    $error_msg['name'] = '<div class="alert alert-danger" role="alert">
    This Field is required
  </div>';
}

#email validation
if(!validate($email,1)){
    $error_msg['email'] = '<div class="alert alert-danger" role="alert" style="text-align: center;">
    This Field is required
  </div>';
}elseif (!validate($email,2)) {
    $error_msg['email'] = '<div class="alert alert-danger" role="alert" style="text-align: center;">
    Enter valid Email
  </div>';
}

#password validatiom
if(!validate($password,1)){
    $error_msg['password'] = '<div class="alert alert-danger" role="alert" style="text-align: center;">
    This Field is required
  </div>';
}elseif (!validate($password,3)){
    $error_msg['password'] = '<div class="alert alert-danger" role="alert" style="text-align: center;">
    password must be more than 6 characters
  </div>';
}

#linkedin url validation
if(!validate($linked,1)){
    $error_msg['linked'] = '<div class="alert alert-danger" role="alert" style="text-align: center;">
    This Field is required
  </div>';
}elseif(!validate($linked,4)){
    $error_msg['linked'] = '<div class="alert alert-danger" role="alert" style="text-align: center;">
    Enter valid url
  </div>';;
}

#address validation
if(!validate($address,1)){
    $error_msg['address'] = '<div class="alert alert-danger" role="alert" style="text-align: center;">
    This Field is required
  </div>';
}elseif (!validate($address,3,10)){
    $error_msg['address'] = 
    '<div class="alert alert-danger" role="alert" style="text-align: center;">
    address must be more than 10 characters  </div>';
}

#gender validation
if(isset($_POST['gender'])){
    $gender = clean($_POST['gender']);
}else{
    $error_msg['gender'] = '<div class="alert alert-danger" role="alert" style="text-align: center;">
    This Field is required
  </div>';
}

#cv file upload process and validation

if(!empty($_FILES['cv']['name'])){
    $PdfTmp   = $_FILES['cv']['tmp_name'];
    $PdfName  = $_FILES['cv']['name'];
    $PdfType  = $_FILES['cv']['type'];
    $PdfSize  = $_FILES['cv']['size'];
    $PdfError = $_FILES['cv']['error'];
    $allowdEx  = ['pdf'];
    $ExeArray = explode('.',$PdfName);
    echo $ExeArray[1];
    if(in_array($ExeArray[1],$allowdEx)){
        $newName = uniqid('cv_file',False) . '.' . $ExeArray[1];
        $dirPath = './uploads/'.$newName;

        if (move_uploaded_file($PdfTmp,$dirPath)) {
            echo '<div class="alert alert-success" role="alert" style="text-align: center;" style="text-align: center;"> 
            pdf File uploaded successfully
          </div>'. '<br>';
            setcookie('cv_file', $_FILES['cv']['name'] , time() + (86400 * 30), "/");
        }else {
            echo  '<div class="alert alert-danger" role="alert" style="text-align: center;">
            Error while uploading file try again  </div>';
        }
    }else {
        echo '<div class="alert alert-danger" role="alert" style="text-align: center;">
        Not Allowed Extension  </div>';
    }
    
}else {
    echo '<div class="alert alert-danger" role="alert" style="text-align: center;">
    This Field is required
  </div>';
}

if(count($error_msg) > 0){
    foreach($error_msg as $key => $val ){
        echo '* '.$key.' :  '.$val.'<br>';
    }
}else{
    echo '<div class="alert alert-success" role="alert" style="text-align: center;">
    Success Valid Data
  </div>';
   }

$txtFile = fopen('personInfo.txt','w') or die("couldn't open file");
$TextArr = implode('-',$_POST) . "\n";
$txt = fwrite($txtFile,$TextArr);
fclose($txtFile);
}



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
           <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form|Page</title>
    <style>
        * {
            box-sizing: border-box;
        }

        input[type=text], radiobutton, .pass , .email{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        label {
            padding: 12px 12px 12px 0;
            display: inline-block;
        }

        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .col-25 {
            float: left;
            width: 15%;
            margin-top: 6px;
        }

        .col-75 {
            float: left;
            width: 65%;
            margin-top: 6px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        .submit{
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }

        /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 600px) {
            .col-25, .col-75, input[type=submit] {
                width: 100%;
                margin-top: 0;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Register :-</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-25">
                <label for="name"><b>Name : </b></label>
            </div>
            <div class="col-75">
                <input type="text" id="name" name="name" placeholder="Your name..">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="email"><b>Email : </b></label>
            </div>
            <div class="col-75">
                <input type="email" id="email" name="email" class="email" placeholder="Your Email..">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="country"><b>Password : </b></label>
            </div>
            <div class="col-75">
                <input type="password" id="password" name="password" class="pass" placeholder="Your Password..">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="subject"><b>Address : </b></label>
            </div>
            <div class="col-75">
                <input type="text" id="address" name="address" placeholder="Your Address..">
            </div>
        </div>
        <br><div class="row">
            <div class="col-25">
                <label for="subject"><b>Gender : </b></label>
            </div>
            <div class="col-75">
                <input type="radio" name="gender" value="Male"><b>Male</b>
                <input type="radio" name="gender" value="female"><b>Female</b>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-25">
                <label for="subject"><b>Linkedin Url : </b></label>
            </div>
            <div class="col-75">
                <input type="url" id="linkedinurl" name="linkedinurl" placeholder="Your Linkedin Url..">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-25">
                <label for="subject"><b>CV pdf : </b></label>
            </div>
            <div class="col-75">
                <input type="file" id="cv" name="cv" placeholder="upload your cv pdf file Here..">
            </div>
        </div>
        <br>
        <div class="submit">
            <input type="submit" value="Submit">
        </div>
    </form>
</div>

</body>
</html>
