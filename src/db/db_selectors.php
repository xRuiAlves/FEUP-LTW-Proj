<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/db/Database.php');

    function userExists($user_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT EXISTS (
                SELECT user_id 
                FROM User 
                WHERE user_id = ?
            ) as "exists"
        '); 
        $stmt->execute(array($user_id));
        $result = $stmt->fetchAll(); 

        return $result[0]["exists"];
    }

    function usernameExists($user_username) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT EXISTS (
                SELECT user_username 
                FROM User 
                WHERE user_username = ?
            ) as "exists"
        '); 
        $stmt->execute(array($user_username));
        $result = $stmt->fetchAll(); 
        return $result[0]["exists"];
    }

    function getUserInfo($user_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT user_id, user_username, user_realname, user_bio 
            FROM User 
            WHERE user_id = ?
        '); 
        $stmt->execute(array($user_id));
        return $stmt->fetchAll()[0]; 
    }

    function getUserStories($user_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT Story.story_title, 
                   Story.story_content, 
                   VotableEntity.votable_entity_creation_date
            FROM User 
                 NATURAL JOIN VotableEntity 
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
            SELECT vote_value
            FROM Vote 
            WHERE user_id = ?
                  AND votable_entity_id = ?
        ');
        $stmt->execute(array($user_id, $entity_id));

        $result = $stmt->fetchAll();
        if (count($result) == 1) {
            return $result[0]["vote_value"];
        } else {
            return 0;
        }
    }

    function storyExists($story_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT EXISTS (
                SELECT votable_entity_id 
                FROM Story 
                WHERE votable_entity_id = ?
            ) as "exists"
        '); 
        $stmt->execute(array($story_id));
        $result = $stmt->fetchAll(); 

        return $result[0]["exists"];
    }

    function commentExists($comment_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT EXISTS (
                SELECT votable_entity_id 
                FROM Comment 
                WHERE votable_entity_id = ?
            ) as "exists"
        '); 
        $stmt->execute(array($comment_id));
        $result = $stmt->fetchAll(); 

        return $result[0]["exists"];
    }

    function voteExists($user_id, $votable_entity_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT EXISTS (
                SELECT vote_value
                FROM Vote
                WHERE user_id = ? AND votable_entity_id = ?
            ) as "exists"
        '); 
        $stmt->execute(array($user_id, $votable_entity_id));
        $result = $stmt->fetchAll(); 

        return $result[0]["exists"];
    }

    function getStory($story_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT Story.votable_entity_id,
                   Story.story_title,
                   Story.story_content,
                   VotableEntity.votable_entity_creation_date 
            FROM Story 
                 NATURAL JOIN VotableEntity
            WHERE votable_entity_id = ?
        ');
        $stmt->execute(array($story_id));
        return $stmt->fetchAll()[0]; 
    }
    
    function getComment($comment_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT * 
            FROM Comment 
            WHERE votable_entity_id = ?
        ');
        $stmt->execute(array($comment_id));
        return $stmt->fetchAll()[0]; 
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

    function updateUserEntityVote($user_id, $entity_id, $vote_value) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            UPDATE Vote
            SET vote_value = ?
            WHERE user_id = ? AND votable_entity_id = ?
        ');
        $stmt->execute(array($vote_value, $user_id, $entity_id));
        return $stmt->fetchAll(); 
    }

    function getEntityComments($entity_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT Comment.votable_entity_id, 
                   Comment.comment_content, 
                   VotableEntity.votable_entity_creation_date, 
                   VotableEntity.user_id
            FROM Comment 
                 NATURAL JOIN VotableEntity
            WHERE Comment.parent_entity_id = ?
        ');
        $stmt->execute(array($entity_id));
        return $stmt->fetchAll(); 
    }

    function getUserPoints($user_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT sum(vote_value) as points
            FROM User  
                 NATURAL JOIN VotableEntity
                 NATURAL JOIN Story
                 JOIN Vote using(votable_entity_id)
            WHERE User.user_id = ?
        ');
        $stmt->execute(array($user_id));

        $result = $stmt->fetchAll(); 
        
        return $result[0]['points'] ? $result[0]['points'] : 0; 
    }

     function createUserStory($user_id, $date, $story_title, $story_content) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (?, ?);
        ');
        $stmt->execute(array($user_id, $date));
        $id = $db->lastInsertId();

        $stmt = $db->prepare('
            INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (?, ?, ?);
        ');
        $stmt->execute(array($id, $story_title, $story_content));

        return $id;
    }

    function createUserComment($user_id, $date, $parent_entity_id, $comment_content) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (?, ?);
        ');
        $stmt->execute(array($user_id, $date));
        $id = $db->lastInsertId();

        $stmt = $db->prepare('
            INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (?, ?, ?);
        ');
        $stmt->execute(array($id, $parent_entity_id, $comment_content));

        return $id;
    }

    function createUserVote($vote_value, $user_id, $votable_entity_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (?, ?, ?);
        ');
        $stmt->execute(array($vote_value, $user_id, $votable_entity_id));
        $id = $db->lastInsertId();

        return $id;
    }

    function createUser($user_username, $user_realname, $user_password, $user_bio) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES (?, ?, ?, ?);
        ');
        $stmt->execute(array($user_username, $user_realname, $user_password, $user_bio));
        $id = $db->lastInsertId();

        return $id;
    }

    function removeUserEntityVote($user_id, $comment_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            DELETE FROM Vote
            WHERE user_id = ?
                AND votable_entity_id = ?
        ');
        $stmt->execute(array($user_id, $comment_id));
        return $stmt->fetchAll();
    }
?>