<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_selectors.php');

    function handleStoryRequest($request, $method) {
        $req = array_shift($request);

        if ($req === "user_stories" && $method === "GET" && isset($_GET['user_id'])) {
            api_getUserStories($_GET['user_id']);
        } else if ($req === "info" && $method === "GET" && isset($_GET['id'])) {
            api_getStoryInfo($_GET['id']);
        } else if ($req === "upvotes" && $method === "GET" && isset($_GET['id'])) {
            api_getStoryUpVotes($_GET['id']);
        } else if ($req === "downvotes" && $method === "GET" && isset($_GET['id'])) {
            api_getStoryDownVotes($_GET['id']);
        } else {
            // Invalid request
            http_response_code(400);
        }
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
?>