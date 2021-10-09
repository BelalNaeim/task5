<?php
//function to clean and trim input 
function clean($input){

    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    $input = trim($input);

    return $input;

}
function validate($input,$flag,$length = 6){
   
    $status = true;

    switch ($flag) {
        case 1:
            # code...
            if(empty($input)){
                $status = false;
            }
            break;

        case 2: 
            # code ... 
             if(!filter_var($input,FILTER_VALIDATE_EMAIL)){
                $status = false;
             }
            break;
        
        case 3: 
            #code ... 
            if(strlen($input) < $length){
                $status = false;
            }    
            break;

        case 4: 
            #code ... 
            if(!filter_var($input,FILTER_VALIDATE_URL)){
                $status = false;
            }    
            break;
    }
    return $status;

}


?>