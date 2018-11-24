<?php
    function httpNotFound($message) {
        echo(json_encode(array(
            'error:' => $message
        )));
        http_response_code(404);
    }

    function httpBadRequest($message) {
        echo(json_encode(array(
            'error:' => $message
        )));
        http_response_code(400);
    }
?>