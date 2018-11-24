<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_selectors.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/api/http_responses.php');

    function handleUserRequest($request, $method) {
        if ($method === "POST") {
            handleUserPostRequest($request);
        } else if ($method === "GET") {
            handleUserGetRequest($request);
        } else if ($method === "PUT") {
            handleUserPutRequest($request);
        } else {
            httpNotFound('request not found');
        }
    }

    function handleUserPostRequest($request) {
        $req = array_shift($request);

        if ($req === "create") {
            api_createUser($_POST['user_username'], 
                           $_POST['user_realname'], 
                           $_POST['user_password'], 
                           $_POST['user_bio']);
        } else {
            httpNotFound('request not found');
        }
    }

    function handleUserGetRequest($request) {
        $req = array_shift($request);

        if ($req === "info" && isset($_GET['id'])) {
            api_getUserInfo($_GET['id']);
        } else if ($req === "points" && isset($_GET['id'])) {
            api_getUserPoints($_GET['id']);
        } else {
            httpNotFound('request not found');
        }
    }

    function handleUserPutRequest($request) {
        $req = array_shift($request);  
        $data = json_decode(file_get_contents("php://input"), true);
        
        if ($req === "updateBio") {
            api_userUpdateBio($data['user_id'], $data['user_bio']);
        } else if ($req === "updatePassword") {
            api_userUpdatePassword($data['user_id'], $data['user_password']);
        } else {
            httpNotFound('request not found');
        }
    }

    function api_getUserInfo($user_id) {
        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else {
            http_response_code(200);
            echo json_encode(getUserInfo($user_id));
        }
    }

    function api_getUserPoints($user_id) {
        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else {
            http_response_code(200);
            echo json_encode(getUserPoints($user_id));
        }
    }

    function api_createUser($user_username, $user_realname, $user_password, $user_bio) {
        if (usernameExists($user_username)){
            httpBadRequest("username already exists");
        } else {
            $comment_id = createUser($user_username, $user_realname, $user_password, $user_bio);
            echo(json_encode(getUserInfo($comment_id)));
            http_response_code(201);
        }
    }

    function api_userUpdateBio($user_id, $user_bio) {
        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else {
            updateUserBio($user_id, $user_bio);
            http_response_code(200);
        }
    }

    function api_userUpdatePassword($user_id, $user_password) {
        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else {
            updateUserPassword($user_id, $user_password);
            http_response_code(200);
        }
    }
?>