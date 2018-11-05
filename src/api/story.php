<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_selectors.php');

    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];

        if (!userExists($user_id)) {
            http_response_code(404);
            echo json_encode(json_decode ("{}"));
        } else {
            http_response_code(200);
            echo json_encode(getUserStories($user_id));
        }
    } else if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $story = getStory($id);

        if(count($story) == 0) {
            http_response_code(404);
            echo json_encode(json_decode ("{}"));
        } else {
            http_response_code(200);
            echo json_encode($story);
        }
    } else {
        http_response_code(400);
        echo "Invalid Request";
    }
    
?>