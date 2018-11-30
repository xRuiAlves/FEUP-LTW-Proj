<?php
    function verifyAuthentication($user_username) {
        return (isset($_SESSION["username"]) && 
                $_SESSION["username"] === $user_username);
    }
?>