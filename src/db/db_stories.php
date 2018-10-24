<?php
    include_once('Database.php');

    function getStory($story_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT * 
            FROM Story 
            WHERE story_id = ?
        ');
        $stmt->execute(array($story_id));
        return $stmt->fetchAll(); 
    }
?>