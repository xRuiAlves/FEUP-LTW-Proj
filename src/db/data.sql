INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES ('dicas', 'Rui', 'password1234', 'Gosto muito de pasteis de nata!');
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES ('dilipaFurao', 'Filipa', 'olaola', 'Gosto de chocolate!');
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES ('limalimao', 'Henrique', 'naoGostoDeESOF', 'Nao gosto de BDAD');
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES ('angelico', 'Angelo', 'mexicano', 'salsaTequilla');

INSERT INTO VotableEntity (votable_entity_id, user_id) VALUES (1, 1);
INSERT INTO VotableEntity (votable_entity_id, user_id) VALUES (2, 1);
INSERT INTO VotableEntity (votable_entity_id, user_id) VALUES (3, 2);
INSERT INTO VotableEntity (votable_entity_id, user_id) VALUES (4, 2);
INSERT INTO VotableEntity (votable_entity_id, user_id) VALUES (5, 3);
INSERT INTO VotableEntity (votable_entity_id, user_id) VALUES (6, 3);
INSERT INTO VotableEntity (votable_entity_id, user_id) VALUES (7, 4);
INSERT INTO VotableEntity (votable_entity_id, user_id) VALUES (8, 4);

INSERT INTO Comment (votable_entity_id, comment_content) VALUES (1, 'Gostei imenso deste texto!');
INSERT INTO Comment (votable_entity_id, comment_content) VALUES (2, 'Que fotos horríveis');
INSERT INTO Comment (votable_entity_id, comment_content) VALUES (3, 'Discordo plenamente!');
INSERT INTO Comment (votable_entity_id, comment_content) VALUES (4, 'Que saudades dessa cidade!');

INSERT INTO Story (votable_entity_id, story_title, story_content, story_creation_date) VALUES (5, 'Viagem a Paris', 'Paris é mesmo bonito bla bla bla bla bla bla bla bla bla', '20170801');
INSERT INTO Story (votable_entity_id, story_title, story_content, story_creation_date) VALUES (6, 'Porto!', ' bla bla bla bla bla bla bla bla bla', '20160427');
INSERT INTO Story (votable_entity_id, story_title, story_content, story_creation_date) VALUES (7, 'Alemanha!', ' bla bla bla bla bla bla bla bla bla', '20180823');
INSERT INTO Story (votable_entity_id, story_title, story_content, story_creation_date) VALUES (8, 'Espanha!', ' bla bla bla bla bla bla bla bla bla', '20160330');

INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 1);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 2, 2);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 3, 1);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 4, 3);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 4);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 3, 4);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 4, 4);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 2, 5);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 3, 5);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 4, 5);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 5);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 6);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 7);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 8);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 3, 7);

INSERT INTO VotableEntityComment (comment_id, votable_entity_id) VALUES (1, 7);
INSERT INTO VotableEntityComment (comment_id, votable_entity_id) VALUES (2, 7);
INSERT INTO VotableEntityComment (comment_id, votable_entity_id) VALUES (3, 1);
INSERT INTO VotableEntityComment (comment_id, votable_entity_id) VALUES (4, 1);
