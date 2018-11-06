<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_selectors.php');

    function handleCommentRequest($request, $method) {
        $req = array_shift($request);

        if ($req === "upvotes" && $method === "GET" && isset($_GET['id'])) {
            api_getCommentUpVotes($_GET['id']);
        } else if ($req === "downvotes" && $method === "GET" && isset($_GET['id'])) {
            api_getCommentDownVotes($_GET['id']);
        } else if ($req === "comments" && $method === "GET" && isset($_GET['id'])) {
            api_getCommentComments($_GET['id']);
        } else {
            // Invalid request
            http_response_code(400);
        }
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
?>