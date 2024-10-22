<?php 
    include_once("../db/db_selectors.php");
    include_once("./http_responses.php");
    include_once("./images.php");
    include_once("./auth.php");

    function handleUserRequest($request, $method) {
        if ($method === "POST") {
            handleUserPostRequest($request);
        } else if ($method === "GET") {
            handleUserGetRequest($request);
        } else if ($method === "PUT") {
            handleUserPutRequest($request);
        } else if ($method === "DELETE") {
            handleUserDeleteRequest($request);
        } else {
            httpNotFound("request not found");
        }
    }

    function handleUserPostRequest($request) {
        $req = array_shift($request);

        if ($req === "create") {
            api_createUser($_POST);
        } else if ($req === "login") {
            api_logUser($_POST);
        } else if ($req === "updateimage") {
            api_userUpdateImage($_POST);
        } else {
            httpNotFound("request not found");
        }

    }
    function handleUserGetRequest($request) {
        $req = array_shift($request);

        if ($req === "info") {
            api_getUserInfo($_GET);
        } else if ($req === "points") {
            api_getUserPoints($_GET);
        } else {
            httpNotFound("request not found");
        }
    }

    function handleUserPutRequest($request) {
        $req = array_shift($request);  
        $data = json_decode(file_get_contents("php://input"), true);
        
        if ($req === "updatebio") {
            api_userUpdateBio($data);
        } else if ($req === "updatepassword") {
            api_userUpdatePassword($data);
        } else {
            httpNotFound("request not found");
        }
    }

    function handleUserDeleteRequest($request) {
        $req = array_shift($request);  
        $data = json_decode(file_get_contents("php://input"), true);

        if ($req === "logout") {
            api_logoutUser($data);
        }
    }

    function api_getUserInfo($data) {
        if (isset($data["id"])) {       // Data by ID
            $id = $data["id"];
            if (!userExists($id)) {
                httpNotFound("user with id $id does not exist");
            } else {
                echo json_encode(array_merge(getUserInfo($id), getUserPoints($id), api_getUserImgJSON($id, "big")));
                http_response_code(200);
            }
        } else if (isset($data["user_username"])) {       // Data by Username
            $user_username = $data["user_username"];
            if (!usernameExists($user_username)){
                httpNotFound("user with username $user_username does not exist");
            } else {
                $info = getUserInfoByUsername($user_username);
                $userImgJSON = api_getUserImgJSON($info["user_id"], "big");
                echo json_encode(array_merge($info, getUserPoints($info["user_id"]), $userImgJSON));
                http_response_code(200);
            }
        } else if (isset($_SESSION['user_id'])) {       // Data by Session
            $id = $_SESSION['user_id'];
            echo json_encode(array_merge(getUserInfo($id), getUserPoints($id), api_getUserImgJSON($id, "big"), api_getUserImgJSON($id, "small")));
            http_response_code(200);
        } else {
            httpBadRequest("'id' or 'user_username' request parameter is missing and user is not logged in");
        }
    }

    function api_logUser($data) {
        if(!verifyRequestParameters($data, ["user_username", "user_password"])) {
            return;
        }

        $user_username = $data["user_username"];
        $user_password = $data["user_password"];

        if (!usernameExists($user_username)){
            httpBadRequest("user with username $user_username does not exist");
        } else {
            if (verifyUser($user_username, $user_password)) {
                $info = getUserInfoByUsername($user_username);
                $userImgJSONbig = api_getUserImgJSON($info["user_id"], "big");
                $userImgJSONsmall = api_getUserImgJSON($info["user_id"], "small");

                $csrf_token = generate_csrf_token();
                $csrf_info = ["csrf_token" => $csrf_token];

                $_SESSION["username"] = $user_username;
                $_SESSION["user_id"] = $info["user_id"];
                $_SESSION["csrf_token"] = $csrf_token;
                echo json_encode(array_merge($info, $userImgJSONsmall, $userImgJSONbig, $csrf_info));
                
                http_response_code(200);
            } else {
                httpUnauthorizedRequest("invalid password");
            }
        }
    }

    function api_logoutUser($data) {
        if(!isset($_SESSION["user_id"])) {
            return;
        }

        if(!verifyRequestParameters($data, ["csrf_token"])) {
            return;
        }

        $request_csrf_token = $data["csrf_token"];
        if ($request_csrf_token !== $_SESSION["csrf_token"]) {
            httpUnauthorizedRequest("invalid csrf token");
            return;
        }

        session_unset($_SESSION["username"]);
        session_unset($_SESSION["user_id"]);
        session_unset($_SESSION["csrf_token"]);
        session_destroy();
    }

    function api_getUserPoints($id) {
        if(!verifyRequestParameters($data, ["id"])) {
            return;
        }

        $id = $data["id"];

        if (!userExists($id)) {
            httpNotFound("user with id $id does not exist");
        } else {
            http_response_code(200);
            echo json_encode(getUserPoints($id));
        }
    }

    function api_createUser($data) {
        $password_min_length = 8;
        
        if(!verifyRequestParameters($data, ["user_username", "user_realname", "user_password", "user_bio"])) {
            return;
        }

        $user_username = $data["user_username"];
        $user_realname = $data["user_realname"];
        $user_password = $data["user_password"];
        $user_bio = $data["user_bio"];

        
        if (strlen($user_password) < $password_min_length) {
            httpBadRequest("password length should be at least $password_min_length characters long");
            return;
        } 

        if (usernameExists($user_username)){
            httpBadRequest("username already exists");
        } else {
            if (!isset($_FILES["user_img"])) {
                httpBadRequest("image missing");
                return;
            }
            
            $img = $_FILES["user_img"];

            $img_validation = validateImage($img);
            if ($img_validation !== "valid") {
                httpBadRequest($img_validation);
                return;
            }

            if (!api_checkInvalidUsername($user_username) && !api_checkInvalidRealname($user_realname)) {
                $user_id = createUser($user_username, $user_realname, $user_password, $user_bio);
                $img_upload = uploadUserImage($img, $user_id);
                
                // log user
                $csrf_token = generate_csrf_token();
                $csrf_info = ["csrf_token" => $csrf_token];
                $_SESSION["username"] = $user_username;
                $_SESSION["user_id"] = $user_id;
                $_SESSION["csrf_token"] = $csrf_token;
                
                echo(json_encode(array_merge(getUserInfo($user_id), api_getUserImgJSON($user_id, "big"), api_getUserImgJSON($user_id, "small"), $csrf_info)));
                http_response_code(201);
            }
        }
    }

    function api_userUpdateBio($data) {
        if(!isset($_SESSION["user_id"])) {
            httpUnauthorizedRequest("invalid permissions");
            return;
        }

        if(!verifyRequestParameters($data, ["csrf_token", "user_bio"])) {
            return;
        }

        $user_id = $_SESSION["user_id"];
        $request_csrf_token = $data["csrf_token"];
        $user_bio = $data["user_bio"];

        if ($request_csrf_token !== $_SESSION["csrf_token"]) {
            httpUnauthorizedRequest("invalid csrf token");
            return;
        }

        updateUserBio($user_id, $user_bio);
        http_response_code(200);
    }

    function api_userUpdatePassword($data) {
        $password_min_length = 8;
        
        if(!verifyRequestParameters($data, ["user_username", "user_old_password", "user_new_password"])) {
            return;
        }
        
        $user_username = $data["user_username"];
        $user_old_password = $data["user_old_password"];
        $user_new_password = $data["user_new_password"];

        if (strlen($user_new_password) < $password_min_length) {
            httpBadRequest("password length should be at least $password_min_length characters long");
            return;
        }

        if (!usernameExists($user_username)) {
            httpNotFound("user with id $user_username does not exist");
            return;
        }

        if (!verifyUser($user_username, $user_old_password)) {
            httpUnauthorizedRequest("invalid password");
        } else {
            updateUserPassword($user_username, $user_new_password);
            http_response_code(200);
        }
    }

    function api_userUpdateImage($data) {
        if(!isset($_SESSION["user_id"])) {
            httpUnauthorizedRequest("invalid permissions");
            return;
        }

        if(!verifyRequestParameters($data, ["csrf_token"])) {
            return;
        }

        $user_id = $_SESSION["user_id"];
        $request_csrf_token = $data["csrf_token"];

        if ($request_csrf_token !== $_SESSION["csrf_token"]) {
            httpUnauthorizedRequest("invalid csrf token");
            return;
        }
        
        if (isset($_FILES["user_img"])) {
            $img = $_FILES["user_img"];
            $img_validation = validateImage($img);
            if ($img_validation !== "valid") {
                httpBadRequest($img_validation);
                return;
            }

            $img_upload = uploadUserImage($img, $user_id);
            http_response_code(200);
        } else {
            httpBadRequest("image missing");
        }
    }

    function api_checkInvalidUsername($user_username) {
        $username_min_size = 5;
        $username_max_size = 14;

        if (!preg_match ("/^[A-Za-z][A-Za-z0-9]+$/", $user_username)) {
            httpBadRequest("username can only contain letters and numbers and must start with a letter");
            return true;
        } else if (strlen($user_username) < $username_min_size) {
            httpBadRequest("username must have at least $username_min_size characters");
            return true;
        } else if (strlen($user_username) > $username_max_size) {
            httpBadRequest("username must have at most $username_max_size characters");
            return true;
        } else {
            return false;   // Not Invalid
        }
    }

    function api_checkInvalidRealname($user_realname) {
        $realname_max_size = 60;

        if (!preg_match ("/^[A-Za-z][A-Za-z\s]+$/", $user_realname)) {
            httpBadRequest("real name can only contain letters and spaces and must start with a letter");
            return true;
        } else if (strlen($user_realname) > $realname_max_size) {
            httpBadRequest("real name must have at most $realname_max_size characters");
            return true;
        } else {
            return false;   // Not Invalid
        }
    }
?>