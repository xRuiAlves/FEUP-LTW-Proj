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
        $result = $stmt->fetch(); 

        return $result["exists"];
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
        $result = $stmt->fetch(); 
        return $result["exists"];
    }

    function getUserInfo($user_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT user_id, user_username, user_realname, user_bio 
            FROM User 
            WHERE user_id = ?
        '); 
        $stmt->execute(array($user_id));
        return $stmt->fetch(); 
    }

    function getUserInfoByUsername($user_username) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT user_id, user_username, user_realname, user_bio 
            FROM User 
            WHERE user_username = ?
        '); 
        $stmt->execute(array($user_username));
        return $stmt->fetch(); 
    }

    function getRecentStories($offset, $num_stories) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT votable_entity_id, user_username, story_title, story_content, votable_entity_creation_date, max(num_up_votes) as upvotes, max(num_down_votes) as downvotes
            FROM
                (SELECT votable_entity_id, COUNT(*) as num_up_votes
                FROM Vote 
                    NATURAL JOIN Story
                WHERE vote_value = 1
                GROUP BY votable_entity_id
                UNION
                SELECT votable_entity_id, 0
                FROM Story)
            
                NATURAL JOIN
                (SELECT votable_entity_id, COUNT(*) as num_down_votes
                FROM Vote 
                    NATURAL JOIN Story
                WHERE vote_value = -1
                GROUP BY votable_entity_id
                UNION
                SELECT votable_entity_id, 0
                FROM Story)
                
                NATURAL JOIN VotableEntity
                NATURAL JOIN Story
                NATURAL JOIN User
            GROUP BY votable_entity_id
            ORDER BY votable_entity_creation_date DESC
            LIMIT ?
            OFFSET ?;
        ');
        $stmt->execute(array($num_stories, $offset));
        return $stmt->fetchAll(); 
    }

    function getUserRecentStories($user_id, $offset, $num_stories) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT votable_entity_id, user_username, story_title, story_content, votable_entity_creation_date, max(num_up_votes) as upvotes, max(num_down_votes) as downvotes
            FROM
                (SELECT votable_entity_id, COUNT(*) as num_up_votes
                FROM Vote 
                    NATURAL JOIN Story
                WHERE vote_value = 1
                GROUP BY votable_entity_id
                UNION
                SELECT votable_entity_id, 0
                FROM Story)
            
                NATURAL JOIN
                (SELECT votable_entity_id, COUNT(*) as num_down_votes
                FROM Vote 
                    NATURAL JOIN Story
                WHERE vote_value = -1
                GROUP BY votable_entity_id
                UNION
                SELECT votable_entity_id, 0
                FROM Story)
                
                NATURAL JOIN VotableEntity
                NATURAL JOIN Story
                NATURAL JOIN User
            WHERE user_id = ?
            GROUP BY votable_entity_id
            ORDER BY votable_entity_creation_date DESC
            LIMIT ?
            OFFSET ?;
        ');
        $stmt->execute(array($user_id, $num_stories, $offset));
        return $stmt->fetchAll(); 
    }

    function getMostUpvotedStories($offset, $num_stories) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT votable_entity_id, user_username, story_title, story_content, votable_entity_creation_date, max(num_up_votes) as upvotes, max(num_down_votes) as downvotes
            FROM
                (SELECT votable_entity_id, COUNT(*) as num_up_votes
                FROM Vote 
                    NATURAL JOIN Story
                WHERE vote_value = 1
                GROUP BY votable_entity_id
                UNION
                SELECT votable_entity_id, 0
                FROM Story)
            
                NATURAL JOIN
                (SELECT votable_entity_id, COUNT(*) as num_down_votes
                FROM Vote 
                    NATURAL JOIN Story
                WHERE vote_value = -1
                GROUP BY votable_entity_id
                UNION
                SELECT votable_entity_id, 0
                FROM Story)
                
                NATURAL JOIN VotableEntity
                NATURAL JOIN Story
                NATURAL JOIN User
            GROUP BY votable_entity_id
            ORDER BY upvotes DESC, downvotes DESC
            LIMIT ?
            OFFSET ?;
        ');
        $stmt->execute(array($num_stories, $offset));
        return $stmt->fetchAll(); 
    }

    function getUserMostUpvotedStories($user_id, $offset, $num_stories) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT votable_entity_id, user_username, story_title, story_content, votable_entity_creation_date, max(num_up_votes) as upvotes, max(num_down_votes) as downvotes
            FROM
                (SELECT votable_entity_id, COUNT(*) as num_up_votes
                FROM Vote 
                    NATURAL JOIN Story
                WHERE vote_value = 1
                GROUP BY votable_entity_id
                UNION
                SELECT votable_entity_id, 0
                FROM Story)
            
                NATURAL JOIN
                (SELECT votable_entity_id, COUNT(*) as num_down_votes
                FROM Vote 
                    NATURAL JOIN Story
                WHERE vote_value = -1
                GROUP BY votable_entity_id
                UNION
                SELECT votable_entity_id, 0
                FROM Story)
                
                NATURAL JOIN VotableEntity
                NATURAL JOIN Story
                NATURAL JOIN User
            WHERE user_id = ?
            GROUP BY votable_entity_id
            ORDER BY upvotes DESC, downvotes DESC
            LIMIT ?
            OFFSET ?;
        ');
        $stmt->execute(array($user_id, $num_stories, $offset));
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
        $result = $stmt->fetch(); 

        return $result["exists"];
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
        $result = $stmt->fetch(); 

        return $result["exists"];
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
        $result = $stmt->fetch(); 

        return $result["exists"];
    }

    function getStory($story_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT Story.votable_entity_id,
                   Story.story_title,
                   Story.story_content,
                   VotableEntity.votable_entity_creation_date,
                   User.user_username
            FROM Story 
                 NATURAL JOIN VotableEntity
                 NATURAL JOIN User
            WHERE votable_entity_id = ?
        ');
        $stmt->execute(array($story_id));
        return $stmt->fetch(); 
    }
    
    function getComment($comment_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT Comment.votable_entity_id,
                   Comment.comment_content,
                   Comment.parent_entity_id,
                   VotableEntity.votable_entity_creation_date
            FROM Comment
                 NATURAL JOIN VotableEntity
            WHERE votable_entity_id = ?
        ');
        $stmt->execute(array($comment_id));
        return $stmt->fetch(); 
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

        $result = $stmt->fetch();
        return $result["num_votes"];
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

        $result = $stmt->fetch();
        return $result["num_votes"];
    }

    function updateUserEntityVote($user_id, $entity_id, $vote_value) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            UPDATE Vote
            SET vote_value = ?
            WHERE user_id = ? AND votable_entity_id = ?
        ');
        $stmt->execute(array($vote_value, $user_id, $entity_id));
    }

    function updateUserBio($user_id, $bio_info) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            UPDATE User
            SET user_bio = ?
            WHERE user_id = ?
        ');
        $stmt->execute(array($bio_info, $user_id));
    }

    function updateUserPassword($user_username, $new_password) {
        $pass_hashing_options = ['cost' => 10];
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT, $pass_hashing_options);

        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            UPDATE User
            SET user_password = ?
            WHERE user_username = ?
        ');
        $stmt->execute(array($hashed_password, $user_username));
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
            ORDER BY VotableEntity.votable_entity_creation_date
        ');
        $stmt->execute(array($entity_id));
        return $stmt->fetchAll(); 
    }

    function getEntityNumComments($entity_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT COUNT(*) as num_comments
            FROM Comment 
                 NATURAL JOIN VotableEntity
            WHERE Comment.parent_entity_id = ?
        ');
        $stmt->execute(array($entity_id));
        return $stmt->fetch()["num_comments"]; 
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

        $result = $stmt->fetch(); 
        
        return $result['points'] ? $result['points'] : "0"; 
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
        $pass_hashing_options = ['cost' => 10];
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT, $pass_hashing_options);

        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES (?, ?, ?, ?);
        ');
        $stmt->execute(array($user_username, $user_realname, $hashed_password, $user_bio));
        $id = $db->lastInsertId();

        return $id;
    }

    function verifyUser($user_username, $user_password) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            SELECT user_password 
            FROM User 
            WHERE user_username = ?
        '); 
        $stmt->execute(array($user_username));
        $user = $stmt->fetch(); 

        return password_verify($user_password, $user['user_password']);
    }

    function removeUserEntityVote($user_id, $comment_id) {
        $db = Database::getInstance()->getDB();
        $stmt = $db->prepare('
            DELETE FROM Vote
            WHERE user_id = ?
                AND votable_entity_id = ?
        ');
        $stmt->execute(array($user_id, $comment_id));
    }
?>