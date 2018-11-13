<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_selectors.php');

    function handleStoryRequest($request, $method) {
        $req = array_shift($request);

        if ($req === "create" && $method === "POST") {
            api_createStory($_POST['user_id'],
                            $_POST['date'],
                            $_POST['story_title'],
                            $_POST['story_content']);
        } else if ($req === "user_stories" && $method === "GET" && isset($_GET['user_id'])) {
            api_getUserStories($_GET['user_id']);
        } else if ($req === "info" && $method === "GET" && isset($_GET['id'])) {
            api_getStoryInfo($_GET['id']);
        } else if ($req === "upvotes" && $method === "GET" && isset($_GET['id'])) {
            api_getStoryUpVotes($_GET['id']);
        } else if ($req === "downvotes" && $method === "GET" && isset($_GET['id'])) {
            api_getStoryDownVotes($_GET['id']);
        } else if ($req === "stories" && $method === "GET" && isset($_GET['id'])) {
            api_getStoryStorys($_GET['id']);
        } else if ($req === "upvote" && $method === "PUT") {
            $data = json_decode(file_get_contents("php://input"), true);
            api_userStoryUpvote($data['user_id'], $data['story_id']);
        } else if ($req === "downvote" && $method === "PUT") {
            $data = json_decode(file_get_contents("php://input"), true);
            api_userStoryDownvote($data['user_id'], $data['story_id']);
        } else if ($req === "unvote" && $method === "DELETE") {
            $data = json_decode(file_get_contents("php://input"), true);
            api_userStoryUnvote($data['user_id'], $data['story_id']);
        } else {
            // Invalid request
            http_response_code(404);
        }
    }

    function api_createStory($user_id, $date, $story_title, $story_content) {
        createUserStory($user_id, $date, $story_title, $story_content);
        http_response_code(201);
    }

    function api_getUserStories($user_id) {
        if (!userExists($user_id)) {
            http_response_code(404);
        } else {
            http_response_code(200);
            echo json_encode(getUserStories($user_id));
        }
    }

    function api_getStoryInfo($id) {
        $story = getStory($id);

        if(count($story) == 0) {
            http_response_code(404);
        } else {
            http_response_code(200);
            echo json_encode($story);
        }
    }

    function api_getStoryUpVotes($id) {
        if(!storyExists($id)) {
            http_response_code(404);
        } else {
            http_response_code(200);
            echo json_encode(getEntityNumUpVotes($id));
        }
    }   

    function api_getStoryDownVotes($id) {
        if(!storyExists($id)) {
            http_response_code(404);
        } else {
            http_response_code(200);
            echo json_encode(getEntityNumDownVotes($id));
        }
    }  

    function api_getStoryComments($id) {
        if(!storyExists($id)) {
            http_response_code(404);
        } else {
            http_response_code(200);
            echo json_encode(getEntityComments($id));
        }
    }

    function api_userStoryUpvote($user_id, $story_id) {
        if(voteExists($user_id, $story_id)) {
            updateUserEntityVote($user_id, $story_id, 1);
            http_response_code(200);
        }
        else {
            createUserVote(1, $user_id, $story_id);
            http_response_code(201);
        }
    }

    function api_userStoryDownvote($user_id, $story_id) {
        if(voteExists($user_id, $story_id)) {
            updateUserEntityVote($user_id, $story_id, -1);
            http_response_code(200);
        }
        else {
            createUserVote(-1, $user_id, $story_id);
            http_response_code(201);
        }
    }

    function api_userStoryUnvote($user_id, $story_id) {
        removeUserEntityVote($user_id, $story_id);
        http_response_code(200);
    }
?>