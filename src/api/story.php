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
            api_createStory($_POST);
        } else {
            httpNotFound('request not found');
        }
    }

    function handleStoryGetRequest($request) {
        $req = array_shift($request);

        if ($req === "info") {
            api_getStoryInfo($_GET);
        } else if ($req === "upvotes") {
            api_getStoryUpVotes($_GET);
        } else if ($req === "downvotes") {
            api_getStoryDownVotes($_GET);
        } else if ($req === "comments") {
            api_getStoryComments($_GET);
        } else if ($req === "recent") {
            api_getRecentStories($_GET);
        } else if ($req === "recentuser") {
            api_getUserRecentStories($_GET);
        } else if ($req === "mostupvoted") {
            api_getMostUpvotedStories($_GET);
        } else if ($req === "mostupvoteduser") {
            api_getUserMostUpvotedStories($_GET);
        } else {
            httpNotFound('request not found');
        }
    }

    function handleStoryPutRequest($request) {
        $req = array_shift($request); 
        $data = json_decode(file_get_contents("php://input"), true); 

        if ($req === "upvote") {
            api_userStoryUpvote($data);
        } else if ($req === "downvote") {
            api_userStoryDownvote($data);
        } else {
            httpNotFound('request not found');
        }
    }

    function handleStoryDeleteRequest($request) {
        $req = array_shift($request);
        $data = json_decode(file_get_contents("php://input"), true);

        if ($req === "unvote") {
            api_userStoryUnvote($data);
        } else {
            httpNotFound('request not found');
        }
    }

    function api_createStory($data) {
        if(!verifyRequestParameters($data, ["user_id", "date", "story_title", "story_content"])) {
            return;
        }

        $user_id = $data["user_id"];
        $date = $data["date"];
        $story_title = $data["story_title"];
        $story_content = $data["story_content"];

        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
            return;
        } 

        $user_username = getUserUsername($user_id);
        if(!verifyAuthentication($user_username)) {
            httpUnauthorizedRequest("invalid permissions");
            return;
        } else {
            $story_id = createUserStory($user_id, $date, $story_title, $story_content);

            if (isset($_FILES["story_img"])) {
                $img = $_FILES["story_img"];

                $img_validation = validateImage($img);
                if ($img_validation !== "valid") {
                    httpBadRequest($img_validation);
                    return;
                }
                
                $img_upload = uploadImage($img, "story" . $story_id);
                if ($img_upload !== "uploaded") {
                    httpInternalError($img_upload);
                    return;
                }
            }
            $story_info = getStory($story_id);
            $story_extra_info = [
                'upvotes' => 0,
                'downvotes' => 0,
                'num_comments' => 0
            ];

            // Story image (if existant) and creator image
            $img = api_getStoryImgJSON($story_id);
            if ($img !== null) {
                $story_info = array_merge($story_info, $img);
            }

            $story_info = array_merge($story_info, api_getUserImgJSON($story_info["user_id"]));
            unset($story_info["user_id"]);

            echo(json_encode(array_merge($story_info, $story_extra_info)));
            http_response_code(201);
        }
    }

    function api_getStoryInfo($data) {
        if(!verifyRequestParameters($data, ["id"])) {
            return;
        }

        $id = $data["id"];

        if (!storyExists($id)) {
            httpNotFound("story with id $id does not exist");
        } else {
            $upvotes = getEntityNumUpVotes($id);
            $downvotes = getEntityNumDownVotes($id);
            $num_comments = getEntityNumComments($id);
            $story_info = getStory($id);

            // Votes / Commetns extra info
            $story_extra_info = [
                'upvotes' => $upvotes,
                'downvotes' => $downvotes,
                'num_comments' => $num_comments
            ];

            // Story image (if existant) and creator image
            $img = api_getStoryImgJSON($id);
            if ($img !== null) {
                $story_info = array_merge($story_info, $img);
            }

            $story_info = array_merge($story_info, api_getUserImgJSON($story_info["user_id"]));
            unset($story_info["user_id"]);

            echo(json_encode(array_merge($story_info, $story_extra_info)));
            http_response_code(200);
        }
    }

    function api_getStoryUpVotes($data) {
        if(!verifyRequestParameters($data, ["id"])) {
            return;
        }

        $id = $data["id"];

        if(!storyExists($id)) {
            httpNotFound("story with id $id does not exist");
        } else {
            http_response_code(200);
            echo(json_encode(getEntityNumUpVotes($id)));
        }
    }   

    function api_getStoryDownVotes($data) {
        if(!verifyRequestParameters($data, ["id"])) {
            return;
        }

        $id = $data["id"];

        if(!storyExists($id)) {
            httpNotFound("story with id $id does not exist");
        } else {
            http_response_code(200);
            echo(json_encode(getEntityNumDownVotes($id)));
        }
    }  

    function api_getStoryComments($data) {
        if(!verifyRequestParameters($data, ["id"])) {
            return;
        }

        $id = $data["id"];

        if(!storyExists($id)) {
            httpNotFound("story with id $id does not exist");
        } else {
            $comments = getEntityComments($id);
            foreach ($comments as $index => $comment) {
                $num_comments = ["num_comments" => getEntityNumComments($comment["votable_entity_id"])];
                $comments[$index] = array_merge($comment, $num_comments);
            }
            echo(json_encode($comments));
            http_response_code(200);
        }
    }

    function api_userStoryUpvote($data) {
        if(!verifyRequestParameters($data, ["user_id", "story_id"])) {
            return;
        }

        $user_id = $data["user_id"];
        $story_id = $data["story_id"];

        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
            return;
        } else if (!storyExists($story_id)) {
            httpNotFound("story with id $story_id does not exist");
            return;
        }  

        $user_username = getUserUsername($user_id);
        if(!verifyAuthentication($user_username)) {
            httpUnauthorizedRequest("invalid permissions");
            return;
        } 

        if(voteExists($user_id, $story_id)) {
            updateUserEntityVote($user_id, $story_id, 1);
            http_response_code(200);
        } else {
            createUserVote(1, $user_id, $story_id);
            http_response_code(201);
        }
    }

    function api_userStoryDownvote($data) {
        if(!verifyRequestParameters($data, ["user_id", "story_id"])) {
            return;
        }

        $user_id = $data["user_id"];
        $story_id = $data["story_id"];

        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
            return;
        } else if (!storyExists($story_id)) {
            httpNotFound("story with id $story_id does not exist");
            return;
        } 

        $user_username = getUserUsername($user_id);
        if(!verifyAuthentication($user_username)) {
            httpUnauthorizedRequest("invalid permissions");
            return;
        } 
        
        if(voteExists($user_id, $story_id)) {
            updateUserEntityVote($user_id, $story_id, -1);
            http_response_code(200);
        } else {
            createUserVote(-1, $user_id, $story_id);
            http_response_code(201);
        }
    }

    function api_userStoryUnvote($data) {
        if(!verifyRequestParameters($data, ["user_id", "story_id"])) {
            return;
        }

        $user_id = $data["user_id"];
        $story_id = $data["story_id"];

        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
            return;
        } else if (!storyExists($story_id)) {
            httpNotFound("story with id $story_id does not exist");
            return;
        } 

        $user_username = getUserUsername($user_id);
        if(!verifyAuthentication($user_username)) {
            httpUnauthorizedRequest("invalid permissions");
        } else {
            removeUserEntityVote($user_id, $story_id);
            http_response_code(200);
        }
    }

    function api_getRecentStories($data) {
        if(!verifyRequestParameters($data, ["offset", "num_stories"])) {
            return;
        }

        $offset = $data["offset"];
        $num_stories = $data["num_stories"];

        $stories = getRecentStories($offset, $num_stories);
        foreach ($stories as $index => $story) {
            $stories[$index] = api_addStoryExtraInfo($story);
            $stories[$index]["story_content"] = api_getStoryPreview($story["story_content"]);
        }
        
        echo(json_encode($stories));
        http_response_code(200);
    }

    function api_getUserRecentStories($data) {
        if(!verifyRequestParameters($data, ["user_id", "offset", "num_stories"])) {
            return;
        }

        $user_id = $data["user_id"];
        $offset = $data["offset"];
        $num_stories = $data["num_stories"];

        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else {
            $stories = getUserRecentStories($user_id, $offset, $num_stories);
            foreach ($stories as $index => $story) {
                $stories[$index] = api_addStoryExtraInfo($story);
                $stories[$index]["story_content"] = api_getStoryPreview($story["story_content"]);
            }

            echo(json_encode($stories));
            http_response_code(200);
        }
    }

    function api_getMostUpvotedStories($data) {
        if(!verifyRequestParameters($data, ["offset", "num_stories"])) {
            return;
        }

        $offset = $data["offset"];
        $num_stories = $data["num_stories"];

        $stories = getMostUpvotedStories($offset, $num_stories);
        foreach ($stories as $index => $story) {
            $stories[$index] = api_addStoryExtraInfo($story);
            $stories[$index]["story_content"] = api_getStoryPreview($story["story_content"]);
        }

        echo(json_encode($stories));
        http_response_code(200);
    }

    function api_getUserMostUpvotedStories($data) {
        if(!verifyRequestParameters($data, ["user_id", "offset", "num_stories"])) {
            return;
        }

        $user_id = $data["user_id"];
        $offset = $data["offset"];
        $num_stories = $data["num_stories"];

        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else {
            $stories = getUserMostUpvotedStories($user_id, $offset, $num_stories);
            foreach ($stories as $index => $story) {
                $stories[$index] = api_addStoryExtraInfo($story);
                $stories[$index]["story_content"] = api_getStoryPreview($story["story_content"]);
            }

            echo(json_encode($stories));
            http_response_code(200);
        }
    }

    function api_addStoryExtraInfo($story) {
        // Number of story comments
        $num_comments = ["num_comments" => getEntityNumComments($story["votable_entity_id"])];
        $story = array_merge($story, $num_comments);
        
        // Story image
        $img = api_getStoryImgJSON($story["votable_entity_id"]);
        if ($img !== null) {
            $story = array_merge($story, $img);
        }

        // Story creator user image
        $story = array_merge($story, api_getUserImgJSON($story["user_id"]));
        unset($story["user_id"]);        
        
        return $story;
    }

    function api_getStoryPreview($story_content) {
        $story_content_max_size = 15;

        if (strlen($story_content) > $story_content_max_size) {
            $story_content = substr($story_content, 0, $story_content_max_size) . "...";
        }

        return $story_content;
    }
?>