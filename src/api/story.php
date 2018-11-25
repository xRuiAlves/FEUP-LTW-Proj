<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_selectors.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/api/http_responses.php');
    include_once($_SERVER["DOCUMENT_ROOT"] . "/api/images.php");

    function handleStoryRequest($request, $method) {
        if ($method === "POST") {
            handleStoryPostRequest($request);
        } else if ($method === "GET") {
            handleStoryGetRequest($request);
        } else if ($method === "PUT") {
            handleStoryPutRequest($request);
        } else if ($method === "DELETE") {
            handleStoryDeleteRequest($request);
        } else {
            httpNotFound('request not found');
        }
    }

    function handleStoryPostRequest($request) {
        $req = array_shift($request);

        if ($req === "create") {
            api_createStory($_POST['user_id'],
                            $_POST['date'],
                            $_POST['story_title'],
                            $_POST['story_content']);
        } else {
            httpNotFound('request not found');
        }
    }

    function handleStoryGetRequest($request) {
        $req = array_shift($request);

        if ($req === "user_stories" && isset($_GET['user_id'])) {
            api_getUserStories($_GET['user_id']);
        } else if ($req === "info" && isset($_GET['id'])) {
            api_getStoryInfo($_GET['id']);
        } else if ($req === "upvotes" && isset($_GET['id'])) {
            api_getStoryUpVotes($_GET['id']);
        } else if ($req === "downvotes" && isset($_GET['id'])) {
            api_getStoryDownVotes($_GET['id']);
        } else if ($req === "comments" && isset($_GET['id'])) {
            api_getStoryComments($_GET['id']);
        } else {
            httpNotFound('request not found');
        }
    }

    function handleStoryPutRequest($request) {
        $req = array_shift($request); 
        $data = json_decode(file_get_contents("php://input"), true); 

        if ($req === "upvote") {
            api_userStoryUpvote($data['user_id'], $data['story_id']);
        } else if ($req === "downvote") {
            api_userStoryDownvote($data['user_id'], $data['story_id']);
        } else {
            httpNotFound('request not found');
        }
    }

    function handleStoryDeleteRequest($request) {
        $req = array_shift($request);
        $data = json_decode(file_get_contents("php://input"), true);

        if ($req === "unvote") {
            api_userStoryUnvote($data['user_id'], $data['story_id']);
        } else {
            httpNotFound('request not found');
        }
    }

    function api_createStory($user_id, $date, $story_title, $story_content) {
        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else {
            if (!isset($_FILES["story_img"])) {
                httpBadRequest("image missing");
                return;
            }
            $img = $_FILES["story_img"];

            $img_validation = validateImage($img);
            if ($img_validation !== "valid") {
                httpBadRequest($img_validation);
                return;
            }

            $story_id = createUserStory($user_id, $date, $story_title, $story_content);

            $img_upload = uploadImage($img, "story" . $story_id);
            if ($img_upload !== "uploaded") {
                httpInternalError($img_upload);
                return;
            }

            echo(json_encode(getStory($story_id)));
            http_response_code(201);
        }
    }

    function api_getUserStories($user_id) {
        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else {
            http_response_code(200);
            echo json_encode(getUserStories($user_id));
        }
    }

    function api_getStoryInfo($story_id) {
        if (!storyExists($story_id)) {
            httpNotFound("story with id $story_id does not exist");
        } else {
            $upvotes = getEntityNumUpVotes($story_id);
            $downvotes = getEntityNumDownVotes($story_id);
            $story_info = getStory($story_id);
            $story_votes = [
                'upvotes' => $upvotes,
                'downvotes' => $downvotes
            ];
            echo(json_encode(array_merge($story_info, $story_votes)));
            http_response_code(200);
        }
    }

    function api_getStoryUpVotes($story_id) {
        if(!storyExists($story_id)) {
            httpNotFound("story with id $story_id does not exist");
        } else {
            http_response_code(200);
            echo(json_encode(getEntityNumUpVotes($story_id)));
        }
    }   

    function api_getStoryDownVotes($story_id) {
        if(!storyExists($story_id)) {
            httpNotFound("story with id $story_id does not exist");
        } else {
            http_response_code(200);
            echo(json_encode(getEntityNumDownVotes($story_id)));
        }
    }  

    function api_getStoryComments($story_id) {
        if(!storyExists($story_id)) {
            httpNotFound("story with id $story_id does not exist");
        } else {
            http_response_code(200);
            echo(json_encode(getEntityComments($story_id)));
        }
    }

    function api_userStoryUpvote($user_id, $story_id) {
        if(voteExists($user_id, $story_id)) {
            updateUserEntityVote($user_id, $story_id, 1);
            http_response_code(200);
        } else if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else if (!storyExists($story_id)) {
            httpNotFound("story with id $story_id does not exist");
        } else {
            createUserVote(1, $user_id, $story_id);
            http_response_code(201);
        }
    }

    function api_userStoryDownvote($user_id, $story_id) {
        if(voteExists($user_id, $story_id)) {
            updateUserEntityVote($user_id, $story_id, -1);
            http_response_code(200);
        } else if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else if (!storyExists($story_id)) {
            httpNotFound("story with id $story_id does not exist");
        } else {
            createUserVote(-1, $user_id, $story_id);
            http_response_code(201);
        }
    }

    function api_userStoryUnvote($user_id, $story_id) {
        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else if (!storyExists($story_id)) {
            httpNotFound("story with id $story_id does not exist");
        } else {
            removeUserEntityVote($user_id, $story_id);
            http_response_code(200);
        }
    }
?>