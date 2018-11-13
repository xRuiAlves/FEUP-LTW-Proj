<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_selectors.php');

    function handleCommentRequest($request, $method) {
        $req = array_shift($request);

        if ($req === "create" && $method === "POST") {
            api_createComment($_POST['user_id'], 
                              $_POST['date'], 
                              $_POST['parent_entity_id'], 
                              $_POST['comment_content']);
        } else if ($req === "upvotes" && $method === "GET" && isset($_GET['id'])) {
            api_getCommentUpVotes($_GET['id']);
        } else if ($req === "downvotes" && $method === "GET" && isset($_GET['id'])) {
            api_getCommentDownVotes($_GET['id']);
        } else if ($req === "comments" && $method === "GET" && isset($_GET['id'])) {
            api_getCommentComments($_GET['id']);
        } else if ($req === "upvote" && $method === "PUT") {
            $data = json_decode(file_get_contents("php://input"), true);
            api_userCommentUpvote($data['user_id'], $data['comment_id']);
        } else if ($req === "downvote" && $method === "PUT") {
            $data = json_decode(file_get_contents("php://input"), true);
            api_userCommentDownvote($data['user_id'], $data['comment_id']);
        } else if ($req === "unvote" && $method === "DELETE") {
            $data = json_decode(file_get_contents("php://input"), true);
            api_userCommentUnvote($data['user_id'], $data['comment_id']);
        } else {
            // Invalid request
            http_response_code(404);
        }
    }

    function api_createComment($user_id, $date, $parent_entity_id, $comment_content) {
        createUserComment($user_id, $date, $parent_entity_id, $comment_content);
        http_response_code(201);
    }

    function api_getCommentUpVotes($id) {
        if(!commentExists($id)) {
            http_response_code(404);
        } else {
            http_response_code(200);
            echo json_encode(getEntityNumUpVotes($id));
        }
    }   

    function api_getCommentDownVotes($id) {
        if(!commentExists($id)) {
            http_response_code(404);
        } else {
            http_response_code(200);
            echo json_encode(getEntityNumDownVotes($id));
        }
    }  

    function api_getCommentComments($id) {
        if(!commentExists($id)) {
            http_response_code(404);
        } else {
            http_response_code(200);
            echo json_encode(getEntityComments($id));
        }
    }

    function api_userCommentUpvote($user_id, $comment_id) {
        if(voteExists($user_id, $comment_id)) {
            updateUserEntityVote($user_id, $comment_id, 1);
            http_response_code(200);
        }
        else {
            createUserVote(1, $user_id, $comment_id);
            http_response_code(201);
        }
    }

    function api_userCommentDownvote($user_id, $comment_id) {
        if(voteExists($user_id, $comment_id)) {
            updateUserEntityVote($user_id, $comment_id, -1);
            http_response_code(200);
        }
        else {
            createUserVote(-1, $user_id, $comment_id);
            http_response_code(201);
        }
    }

    function api_userCommentUnvote($user_id, $comment_id) {
        removeUserEntityVote($user_id, $comment_id);
        http_response_code(200);
    }
?>