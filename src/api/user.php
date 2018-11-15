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
        } else if ($req === "updateBio" && $method === "PUT") {
            $data = json_decode(file_get_contents("php://input"), true);
            api_userUpdateBio($data['user_id'], $data['user_bio']);
        } else if ($req === "updatePassword" && $method === "PUT") {
            $data = json_decode(file_get_contents("php://input"), true);
            api_userUpdatePassword($data['user_id'], $data['user_password']);
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
            echo(json_encode(array(
                'error:' => "username already exists"
            )));
            http_response_code(400);
        } else {
            $comment_id = createUser($user_username, $user_realname, $user_password, $user_bio);
            echo(json_encode(getUserInfo($comment_id)));
            http_response_code(201);
        }
    }

    function api_userUpdateBio($user_id, $user_bio) {
        if (!userExists($user_id)) {
            http_response_code(404);
        } else {
            updateUserBio($user_id, $user_bio);
            http_response_code(200);
        }
    }

    function api_userUpdatePassword($user_id, $user_password) {
        if (!userExists($user_id)) {
            http_response_code(404);
        } else {
            updateUserPassword($user_id, $user_password);
            http_response_code(200);
        }
    }
?>