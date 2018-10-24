<?php
    include_once('Database.php');

    function getComment($comment_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT * 
            FROM Comment 
            WHERE comment_id = ?
        ');
        $stmt->execute(array($comment_id));
        return $stmt->fetchAll(); 
    }
?>