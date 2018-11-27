<?php
    function httpBadRequest($message) {
        sendJsonErrorMessage($message);
        http_response_code(400);
    }

    function httpUnauthorizedRequest($message) {
        sendJsonErrorMessage($message);
        http_response_code(401);
    }

    function httpNotFound($message) {
        sendJsonErrorMessage($message);
        http_response_code(404);
    }

    function httpInternalError($message) {
        sendJsonErrorMessage($message);
        http_response_code(500);
    }

    function sendJsonErrorMessage($message) {
        echo(json_encode(array(
            'error:' => $message
        )));
    }
?>