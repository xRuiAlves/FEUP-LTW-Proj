<?php
    include_once('Database.php');

    function getUserInfo($user_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT user_id, user_username, user_realname, user_bio 
            FROM User 
            WHERE user_id = ?
        ');
        $stmt->execute(array($user_id));
        return $stmt->fetchAll(); 
    }
?>