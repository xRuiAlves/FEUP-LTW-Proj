<?php
    include_once('db/Database.php');

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

    function getUserStories($used_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT Story.story_title, Story.story_content, Story.story_creation_date
            FROM User 
                 NATURAL JOIN Creator 
                 NATURAL JOIN Story
            WHERE User.user_id = ?
        ');
        $stmt->execute(array($user_id));
        return $stmt->fetchAll(); 
    }

    /**
     * Gets the User's vote on a story/comment (+1 or -1). If no vote is found, 0 is returned.
     */
    function getUserEntityVote($user_id, $entity_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT Vote.vote_value
            FROM User 
                 NATURAL JOIN Vote 
                 NATURAL JOIN VotableEntity
            WHERE User.user_id = ?
                  AND VotableEntity.votable_entity_id = ?
        ');
        $stmt->execute(array($user_id, $entity_id));

        $result = $stmt->fetchAll();
        if (count($result) == 1) {
            return $result[0]["vote_value"];
        } else {
            return 0;
        }
    }

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
            SELECT COUNT(*) as num_votes
            FROM Vote
            WHERE votable_entity_id = ?
                  AND vote_value = 1
        ');
        $stmt->execute(array($entity_id));

        $result = $stmt->fetchAll();
        return $result[0]["num_votes"];
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

        $result = $stmt->fetchAll();
        return $result[0]["num_votes"];
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