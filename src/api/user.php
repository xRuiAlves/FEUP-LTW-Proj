<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_selectors.php');

    function handleUserRequest($request, $method) {
        $req = array_shift($request);

        if ($req === "info" && $method === "GET" && isset($_GET['id'])) {
            api_getUserInfo($_GET['id']);
        } else if ($req === "points" && $method === "GET" && isset($_GET['id'])) {
            api_getUserPoints($_GET['id']);
        } else if ($req === "create" && $method === "POST") {
            api_createUser($_POST['user_username'], 
                           $_POST['user_realname'], 
                           $_POST['user_password'], 
                           $_POST['user_bio']);
        } else {
            // Invalid request
            http_response_code(404);
        }
    }

    function api_getUserInfo($id) {
        if (!userExists($id)) {
            http_response_code(404);
        } else {
            http_response_code(200);
            echo json_encode(getUserInfo($id));
        }
    }

    function api_getUserPoints($id) {
        if (!userExists($id)) {
            http_response_code(404);
        } else {
            http_response_code(200);
            echo json_encode(getUserPoints($id));
        }
    }

    function api_createUser($user_username, $user_realname, $user_password, $user_bio) {
        if (usernameExists($user_username)){
            http_response_code(400);
        } else {
            echo json_encode(createUser($user_username, $user_realname, $user_password, $user_bio));
            http_response_code(201);
        }
    }
?>