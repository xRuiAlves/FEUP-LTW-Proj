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

    function getEntityNumUpVotes($entity_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT COUNT(*)
            FROM Vote
            WHERE votable_entity_id = ?
                  AND vote_value = 1
        ');
        $stmt->execute(array($entity_id));
        return $stmt->fetchAll(); 
    }

    function getEntityNumDownVotes($entity_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT COUNT(*) as num_votes
            FROM Vote
            WHERE votable_entity_id = ?
                  AND vote_value = -1
        ');
        $stmt->execute(array($entity_id));
        return $stmt->fetchAll(); 
    }

    function getEntityComments($entity_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT Comment.comment_content
            FROM Comment, VotableEntityComment
            WHERE Comment.votable_entity_id = VotableEntityComment.comment_id
                  AND VotableEntityComment.votable_entity_id = ?
        ');
        $stmt->execute(array($entity_id));
        return $stmt->fetchAll(); 
    }
?>