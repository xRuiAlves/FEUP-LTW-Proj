<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_selectors.php');

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        if (!userExists($id)) {
            http_response_code(404);
            echo json_encode(json_decode ("{}"));
        } else {
            http_response_code(200);
            echo json_encode(getUserInfo($id));
        }
    } else {
        http_response_code(400);
        echo "Invalid Request";
    } 
?>