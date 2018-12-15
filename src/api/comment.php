<?php 
    include_once("../db/db_selectors.php");
    include_once("./http_responses.php");

    function handleCommentRequest($request, $method) {
        if ($method === "POST") {
            handleCommentPostRequest($request);
        } else if ($method === "GET") {
            handleCommentGetRequest($request);
        } else if ($method === "PUT") {
            handleCommentPutRequest($request);
        } else if ($method === "DELETE") {
            handleCommentDeleteRequest($request);
        } else {
            httpNotFound("request not found");
        }
    }

    function handleCommentPostRequest($request) {
        $req = array_shift($request);

        if ($req === "create") {
            api_createComment($_POST);
        } else {
            httpNotFound("request not found");
        }
    }

    function handleCommentGetRequest($request) {
        $req = array_shift($request);

        if ($req === "upvotes") {
            api_getCommentUpVotes($_GET);
        } else if ($req === "downvotes") {
            api_getCommentDownVotes($_GET);
        } else if ($req === "comments") {
            api_getCommentComments($_GET);
        } else {
            httpNotFound("request not found");
        }
    }

    function handleCommentPutRequest($request) {
        $req = array_shift($request);  
        $data = json_decode(file_get_contents("php://input"), true);
        
        if ($req === "upvote") {
            api_userCommentUpvote($data);
        } else if ($req === "downvote") {
            api_userCommentDownvote($data);
        } else {
            httpNotFound("request not found");
        }
    }

    function handleCommentDeleteRequest($request) {
        $req = array_shift($request);
        $data = json_decode(file_get_contents("php://input"), true);

        if ($req === "unvote") {
           api_userCommentUnvote($data);
        } else {
            httpNotFound("request not found");
        }
    }

    function api_createComment($data) {
        if(!isset($_SESSION["user_id"])) {
            httpUnauthorizedRequest("invalid permissions");
            return;
        }

        if(!verifyRequestParameters($data, ["parent_entity_id", "comment_content", "csrf_token"])) {
            return;
        }

        $request_csrf_token = $data["csrf_token"];
        if ($request_csrf_token !== $_SESSION["csrf_token"]) {
            httpUnauthorizedRequest("invalid csrf token");
            return;
        }

        $user_id = $_SESSION["user_id"];
        $date = time();
        $parent_entity_id = $data["parent_entity_id"];
        $comment_content = $data["comment_content"];

        if (empty($comment_content)) {
            httpBadRequest("Comment content can not be empty");
            return;
        }
        
        $comment_id = createUserComment($user_id, $date, $parent_entity_id, $comment_content);
        $comment_extra_info = [
            "upvotes" => 0,
            "downvotes" => 0,
            "num_comments" => 0,
            "hasupvoted" => false,
            "hasdownvoted" => false
        ];

        echo(json_encode(array_merge(getComment($comment_id), $comment_extra_info, api_getUserImgJSON($user_id, "small"))));
        http_response_code(201);
    }

    function api_getCommentUpVotes($data) {
        if(!verifyRequestParameters($data, ["id"])) {
            return;
        }

        $id = $data["id"];

        if(!commentExists($id)) {
            httpNotFound("comment with id $id does not exist");
        } else {
            http_response_code(200);
            echo json_encode(getEntityNumUpVotes($id));
        }
    }   

    function api_getCommentDownVotes($data) {
        if(!verifyRequestParameters($data, ["id"])) {
            return;
        }

        $id = $data["id"];

        if(!commentExists($id)) {
            httpNotFound("comment with id $id does not exist");
        } else {
            http_response_code(200);
            echo json_encode(getEntityNumDownVotes($id));
        }
    }  

    function api_getCommentComments($data) {
        if(!verifyRequestParameters($data, ["id"])) {
            return;
        }

        $id = $data["id"];
        $logged_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        if(!commentExists($id)) {
            httpNotFound("comment with id $id does not exist");
        } else {
            $comments = getEntityComments($id);
            foreach($comments as $index => $comment) {
                $comments[$index] = array_merge($comment, api_getUserImgJSON($comment["user_id"], "small"));
                if ($logged_user_id) {
                    $vote_value = getUserEntityVote($logged_user_id, $comment["votable_entity_id"]);
                    $comments[$index] = array_merge($comments[$index], [
                        "hasupvoted" => $vote_value === "1",
                        "hasdownvoted" => $vote_value === "-1",
                    ]);
                }  
            }
            
            echo json_encode($comments);
            http_response_code(200);
        }
    }

    function api_userCommentUpvote($data) {
        if(!isset($_SESSION["user_id"])) {
            httpUnauthorizedRequest("invalid permissions");
            return;
        }

        if(!verifyRequestParameters($data, ["comment_id", "csrf_token"])) {
            return;
        }

        $request_csrf_token = $data["csrf_token"];
        if ($request_csrf_token !== $_SESSION["csrf_token"]) {
            httpUnauthorizedRequest("invalid csrf token");
            return;
        }

        $user_id = $_SESSION["user_id"];
        $comment_id = $data["comment_id"];

        if (!commentExists($comment_id)) {
            httpNotFound("comment with id $comment_id does not exist");
            return;
        }

        if(voteExists($user_id, $comment_id)) {
            updateUserEntityVote($user_id, $comment_id, 1);
            http_response_code(200);
        } else {
            createUserVote(1, $user_id, $comment_id);
            http_response_code(201);
        }
    }

    function api_userCommentDownvote($data) {
        if(!isset($_SESSION["user_id"])) {
            httpUnauthorizedRequest("invalid permissions");
            return;
        }

        if(!verifyRequestParameters($data, ["comment_id", "csrf_token"])) {
            return;
        }

        $request_csrf_token = $data["csrf_token"];
        if ($request_csrf_token !== $_SESSION["csrf_token"]) {
            httpUnauthorizedRequest("invalid csrf token");
            return;
        }

        $user_id = $_SESSION["user_id"];
        $comment_id = $data["comment_id"];

        if (!commentExists($comment_id)) {
            httpNotFound("comment with id $comment_id does not exist");
            return;
        }

        if(voteExists($user_id, $comment_id)) {
            updateUserEntityVote($user_id, $comment_id, -1);
            http_response_code(200);
        } else {
            createUserVote(-1, $user_id, $comment_id);
            http_response_code(201);
        }
    }

    function api_userCommentUnvote($data) {
        if(!isset($_SESSION["user_id"])) {
            httpUnauthorizedRequest("invalid permissions");
            return;
        }

        if(!verifyRequestParameters($data, ["comment_id", "csrf_token"])) {
            return;
        }

        $request_csrf_token = $data["csrf_token"];
        if ($request_csrf_token !== $_SESSION["csrf_token"]) {
            httpUnauthorizedRequest("invalid csrf token");
            return;
        }

        $user_id = $_SESSION["user_id"];
        $comment_id = $data["comment_id"];

        if (!commentExists($comment_id)) {
            httpNotFound("comment with id $comment_id does not exist");
            return;
        } 
        
        removeUserEntityVote($user_id, $comment_id);
        http_response_code(200);
    }
?>