<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_selectors.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/api/http_responses.php');

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
            httpNotFound('request not found');
        }
    }

    function handleCommentPostRequest($request) {
        $req = array_shift($request);

        if ($req === "create") {
            api_createComment($_POST);
        } else {
            httpNotFound('request not found');
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
            httpNotFound('request not found');
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
            httpNotFound('request not found');
        }
    }

    function handleCommentDeleteRequest($request) {
        $req = array_shift($request);
        $data = json_decode(file_get_contents("php://input"), true);

        if ($req === "unvote") {
           api_userCommentUnvote($data);
        } else {
            httpNotFound('request not found');
        }
    }

    function api_createComment($data) {
        if(!verifyRequestParameters($data, ["user_id", "date", "parent_entity_id", "comment_content"])) {
            return;
        }

        $user_id = $data["user_id"];
        $date = $data["date"];
        $parent_entity_id = $data["parent_entity_id"];
        $comment_content = $data["comment_content"];

        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else {
            $comment_id = createUserComment($user_id, $date, $parent_entity_id, $comment_content);
            echo(json_encode(getComment($comment_id)));
            http_response_code(201);
        }
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

        if(!commentExists($id)) {
            httpNotFound("comment with id $id does not exist");
        } else {
            http_response_code(200);
            echo json_encode(getEntityComments($id));
        }
    }

    function api_userCommentUpvote($data) {
        if(!verifyRequestParameters($data, ["user_id", "comment_id"])) {
            return;
        }

        $user_id = $data["user_id"];
        $comment_id = $data["comment_id"];

        if(voteExists($user_id, $comment_id)) {
            updateUserEntityVote($user_id, $comment_id, 1);
            http_response_code(200);
        } else if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else if (!commentExists($comment_id)) {
            httpNotFound("comment with id $comment_id does not exist");
        }
        else {
            createUserVote(1, $user_id, $comment_id);
            http_response_code(201);
        }
    }

    function api_userCommentDownvote($data) {
        if(!verifyRequestParameters($data, ["user_id", "comment_id"])) {
            return;
        }

        $user_id = $data["user_id"];
        $comment_id = $data["comment_id"];

        if(voteExists($user_id, $comment_id)) {
            updateUserEntityVote($user_id, $comment_id, -1);
            http_response_code(200);
        } else if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else if (!commentExists($comment_id)) {
            httpNotFound("comment with id $comment_id does not exist");
        } else {
            createUserVote(-1, $user_id, $comment_id);
            http_response_code(201);
        }
    }

    function api_userCommentUnvote($data) {
        if(!verifyRequestParameters($data, ["user_id", "comment_id"])) {
            return;
        }

        $user_id = $data["user_id"];
        $comment_id = $data["comment_id"];

        if (!userExists($user_id)) {
            httpNotFound("user with id $user_id does not exist");
        } else if (!commentExists($comment_id)) {
            httpNotFound("comment with id $comment_id does not exist");
        } else {
            removeUserEntityVote($user_id, $comment_id);
            http_response_code(200);
        }

    }
?>