<?php 
    include_once($_SERVER["DOCUMENT_ROOT"] . "/db/db_selectors.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/api/http_responses.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/api/images.php");

    function handleUserRequest($request, $method) {
        if ($method === "POST") {
            handleUserPostRequest($request);
        } else if ($method === "GET") {
            handleUserGetRequest($request);
        } else if ($method === "PUT") {
            handleUserPutRequest($request);
        } else {
            httpNotFound("request not found");
        }
    }

    function handleUserPostRequest($request) {
        $req = array_shift($request);

        if ($req === "create") {
            api_createUser($_POST["user_username"], 
                           $_POST["user_realname"], 
                           $_POST["user_password"], 
                           $_POST["user_bio"]);
        } else if ($req === "login") {
            api_logUser($_POST["user_username"], $_POST["user_password"]);
        } else if ($req === "updateimage") {
            api_userUpdateImage($_POST["user_id"]);
        } else {
            httpNotFound("request not found");
        }
    }

    function handleUserGetRequest($request) {
        $req = array_shift($request);

        if ($req === "info" && isset($_GET["id"])) {
            api_getUserInfo($_GET["id"]);
        } else if ($req === "points" && isset($_GET["id"])) {
            api_getUserPoints($_GET["id"]);
        } else {
            httpNotFound("request not found");
        }
    }

    function handleUserPutRequest($request) {
        $req = array_shift($request);  
        $data = json_decode(file_get_contents("php://input"), true);
        
        if ($req === "updatebio") {
            api_userUpdateBio($data["user_id"], $data["user_bio"]);
        } else if ($req === "updatepassword") {
            api_userUpdatePassword($data["user_id"], $data["user_password"]);
        } else {
            httpNotFound("request not found");
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

    function api_logUser($user_username, $user_password) {
        if (!usernameExists($user_username)){
            httpNotFound("user with username $user_username does not exist");
        } else {
            if (verifyUser($user_username, $user_password)) {
                http_response_code(200);
            } else {
                httpUnauthorizedRequest("invalid password");
            }
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
                $img_upload = uploadImage($img, "user" . $user_id);
                if ($img_upload !== "uploaded") {
                    httpInternalError($img_upload);
                    return;
                }
                echo(json_encode(getUserInfo($user_id)));
                http_response_code(201);
            }
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

    function api_userUpdateImage($user_id) {
        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else if (isset($_FILES["user_img"])) {
            $img = $_FILES["user_img"];
            $img_validation = validateImage($img);
            if ($img_validation !== "valid") {
                httpBadRequest($img_validation);
                return;
            }

            $img_upload = uploadImage($img, "user" . $user_id);
            if ($img_upload !== "uploaded") {
                httpInternalError($img_upload);
            } else {
                http_response_code(200);
            }
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