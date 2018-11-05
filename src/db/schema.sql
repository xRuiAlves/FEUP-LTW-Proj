CREATE TABLE User (
    user_id         INTEGER PRIMARY KEY,
    user_username   VARCHAR NOT NULL UNIQUE,
    user_realname   VARCHAR NOT NULL,
    user_password   VARCHAR NOT NULL,
    user_bio        VARCHAR
);

CREATE TABLE VotableEntity (
    votable_entity_id   INTEGER PRIMARY KEY,
    user_id             INTEGER NOT NULL REFERENCES User
);

CREATE TABLE Comment (
    votable_entity_id   INTEGER PRIMARY KEY REFERENCES VotableEntity,
    comment_content     VARCHAR NOT NULL
);

CREATE TABLE Story (
    votable_entity_id   INTEGER PRIMARY KEY REFERENCES VotableEntity,
    story_title         VARCHAR NOT NULL,
    story_content       VARCHAR NOT NULL,
    story_creation_date DATE NOT NULL
);

CREATE TABLE Vote (
    vote_value          INTEGER NOT NULL CHECK (vote_value = -1 OR vote_value = 1),
    user_id             INTEGER NOT NULL REFERENCES User,
    votable_entity_id   INTEGER NOT NULL REFERENCES VotableEntity,
    PRIMARY KEY (
        user_id,
        votable_entity_id
    )
);

CREATE TABLE VotableEntityComment (
    comment_id          INTEGER NOT NULL REFERENCES Comment,
    votable_entity_id   INTEGER NOT NULL REFERENCES VotableEntity, 
    PRIMARY KEY (
        comment_id,
        votable_entity_id
    )
);