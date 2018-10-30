<?php 
    include_once('../db/db_selectors.php');

    if($user = $_GET['id'] > -1){
        // Return user from $id
        echo json_encode(getUserInfo($user));
    }else{
        // Return feed
        echo "no request was found. Try ?id=0";
    }
    
?>