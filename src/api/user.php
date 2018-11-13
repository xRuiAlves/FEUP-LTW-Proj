<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_selectors.php');

    function handleUserRequest($request, $method) {
        $req = array_shift($request);

        if ($req === "info" && $method === "GET" && isset($_GET['id'])) {
            api_getUserInfo($_GET['id']);
        } else if ($req === "points" && $method === "GET" && isset($_GET['id'])) {
            api_getUserPoints($_GET['id']);
        } else if ($req === "create" && $method === "POST") {
            api_createUser($_POST);
        } else {
            // Invalid request
            http_response_code(400);
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

    function api_createUser($postData) {
        if (usernameExists($postData['username'])){
            http_response_code(500);
        } else {
            echo json_encode(createUser($postData['username'], 
                                        $postData['realname'], 
                                        $postData['password'], 
                                        $postData['bio']));
            http_response_code(201);
        }
    }
?>