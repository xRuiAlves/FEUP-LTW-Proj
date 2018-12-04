<?php
    session_start();

    include_once($_SERVER['DOCUMENT_ROOT'] . '/api/story.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/api/user.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/api/comment.php');

    session_start();

    header('Content-Type: application/json');

    $method = $_SERVER['REQUEST_METHOD'];
    $request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

    handleRequest($request, $method);

    function handleRequest($request, $method) {

        $req = array_shift($request);

        if ($req === "story") {
            handleStoryRequest($request, $method);
        } else if ($req === "user") {
            handleUserRequest($request, $method);
        } else if ($req === "comment") {
            handleCommentRequest($request, $method);
        }  else {
            // Invalid request
            http_response_code(404);
        }
    }
?>