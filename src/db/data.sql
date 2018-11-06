INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES ('dicas', 'Rui', 'password1234', 'Gosto muito de pasteis de nata!');
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES ('dilipaFurao', 'Filipa', 'olaola', 'Gosto de chocolate!');
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES ('limalimao', 'Henrique', 'naoGostoDeESOF', 'Nao gosto de BDAD');
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES ('angelico', 'Angelo', 'mexicano', 'salsaTequilla');

INSERT INTO VotableEntity (votable_entity_id, user_id, votable_entity_creation_date) VALUES (1, 1, "2018-01-26 14:35:56");
INSERT INTO VotableEntity (votable_entity_id, user_id, votable_entity_creation_date) VALUES (2, 1, "2018-02-07 10:20:00");
INSERT INTO VotableEntity (votable_entity_id, user_id, votable_entity_creation_date) VALUES (3, 2, "2018-03-15 06:02:34");
INSERT INTO VotableEntity (votable_entity_id, user_id, votable_entity_creation_date) VALUES (4, 2, "2018-04-10 22:43:22");
INSERT INTO VotableEntity (votable_entity_id, user_id, votable_entity_creation_date) VALUES (5, 3, "2018-05-01 23:12:03");
INSERT INTO VotableEntity (votable_entity_id, user_id, votable_entity_creation_date) VALUES (6, 3, "2018-06-20 13:35:54");
INSERT INTO VotableEntity (votable_entity_id, user_id, votable_entity_creation_date) VALUES (7, 4, "2018-07-15 18:52:15");
INSERT INTO VotableEntity (votable_entity_id, user_id, votable_entity_creation_date) VALUES (8, 4, "2018-08-30 19:10:09");

INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (1, 7, 'Gostei imenso deste texto!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (2, 7, 'Que fotos horríveis');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (3, 1, 'Discordo plenamente!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (4, 1, 'Que saudades dessa cidade!');

INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (5, 'Viagem a Paris', 'Paris é mesmo bonito bla bla bla bla bla bla bla bla bla');
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (6, 'Porto!', ' bla bla bla bla bla bla bla bla bla');
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (7, 'Alemanha!', ' bla bla bla bla bla bla bla bla bla');
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (8, 'Espanha!', ' bla bla bla bla bla bla bla bla bla');

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