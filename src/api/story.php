<?php 
    include_once('../db/db_selectors.php');

    if($user_id = $_GET['user_id'] > -1){
        // Return $user stories
        echo json_encode(getUserStories($user_id));
    }else if($id = $_GET['id'] > -1){
        // Return story $id
        echo json_encode(getStory($id));
    }else{
        // Return feed
        echo "no request was found. //TODO return feed";
    }
    
?>