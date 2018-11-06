DROP TABLE IF EXISTS User; 
CREATE TABLE User (
    user_id         INTEGER PRIMARY KEY,
    user_username   VARCHAR NOT NULL UNIQUE,
    user_realname   VARCHAR NOT NULL,
    user_password   VARCHAR NOT NULL,
    user_bio        VARCHAR
);

DROP TABLE IF EXISTS VotableEntity; 
CREATE TABLE VotableEntity (
    votable_entity_id               INTEGER PRIMARY KEY,
    user_id                         INTEGER NOT NULL REFERENCES User,
    votable_entity_creation_date    DATE NOT NULL
);

DROP TABLE IF EXISTS Comment; 
CREATE TABLE Comment (
    votable_entity_id   INTEGER PRIMARY KEY REFERENCES VotableEntity,
    parent_entity_id    INTEGER NOT NULL REFERENCES VotableEntity, 
    comment_content     VARCHAR NOT NULL
);

DROP TABLE IF EXISTS Story; 
CREATE TABLE Story (
    votable_entity_id   INTEGER PRIMARY KEY REFERENCES VotableEntity,
    story_title         VARCHAR NOT NULL,
    story_content       VARCHAR NOT NULL
);

DROP TABLE IF EXISTS Vote; 
CREATE TABLE Vote (
    vote_value          INTEGER NOT NULL CHECK (vote_value = -1 OR vote_value = 1),
    user_id             INTEGER NOT NULL REFERENCES User,
    votable_entity_id   INTEGER NOT NULL REFERENCES VotableEntity,
    PRIMARY KEY (
        user_id,
        votable_entity_id
    )
);