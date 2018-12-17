-----------
-- Users
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES (
    'marktsu1996', 
    'Mark Tsu Yu', 
    '$2y$10$7Ofawasf2V6iYF7O96Q/ve6JxZeJdtlIx6O1SWu4kkaBkv.ecDBx.', 
    'Theatre and Performative Arts bachelor degree student at Boston University. Chess player in the Boston Chess Club and Scholastic Center (BCC&SC).'
);
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES (
    'pphig125', 
    'Paul Higgins', 
    '$2y$10$YQ0xX9uR2Rq84MQuFUFNg.ksMmjokn21CBDkv2FSeVpLJ4KyWoBvO', 
    'I have been a farmar for most of my life. I spend my free days travelling, hiking and recently I have acquired a taste in bird watching.'
);
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES (
    'SelenaPeterson', 
    'Selena Peterson', 
    '$2y$10$UfOu1zeyuvCHanoFwRjl..xCO6o.DVDtKNvAQlK4j0cHBo96qIDX.', 
    'Biologic Tissue Regeneration reseacher at Saint Louis University, under a Scientific PPTW Scholaship. In my free time, I enjoy stamp collecting and boat trips by the lake.'
);
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES (
    'SarahVD', 
    'Sarah Van Davidson', 
    '$2y$10$yb1Xna0UdZykTmgHWpCAnOZHlZ02d3gaO5L9EoSH.J97dxGfVM39y', 
    'Full Stack-Entwickler in der deutschen Personalabteilung von JS Integrated Systems. In meiner Freizeit gehe ich gerne schwimmen, tauchen und skaten.'
);
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES (
    'rogerMC', 
    'Roger McGreggor', 
    '$2y$10$7Qt6sb2lEasaIUKgwiMvGe6LddfpyxMIByvlOEgk7g4sYtOsb.DFy', 
    'Health care assistant. Youtube and twich streamer in free times, where I show people how to solve puzzles (one of my biggest passions since I was a child!).'
);
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES (
    'muffinJP', 
    'Jessica Patrice', 
    '$2y$10$IdM9s2fkcBKtFCr/vX7.z.aZUqiSvTO4MZ7DqEGnSqqw1VJRclv9W', 
    'My name is Jessica, but most of my friends call me muffin! I am a cooking teacher at Escola de Cozinha de Guimaraes. I am also a hicking teacher and ocosionally I enjoy 1-month long road trips.' 
);
INSERT INTO User (user_username, user_realname, user_password, user_bio) VALUES (
    'guillermoLu', 
    'Guillermo de Lucia', 
    '$2y$10$R4RKDxKQuQMGW6ZtxtTTZeA3AGCvfwgmEvoNLJJgGX67YzCJXiRbC', 
    'Atleta a Venezia Scuola sportiva e Competenza accademica. Mi piace il mio tempo libero giocando a calcio e a basket con il mio amico. Suono il pianoforte da quando avevo 5 anni, e ho vinto un premio al concorso per pianoforte junior di San Tiago.'
);

----------------------
-- Votable Entities

-- Stories
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1527149000"); 
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1527946402"); 
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1527648000");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1527347699");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1528448606");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (2, "1528647306"); 
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (2, "1528147406");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (2, "1528046200");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1528547606"); 
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1527848414");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1527748800");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (4, "1528348412");  
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (4, "1527548888");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (4, "1527447650");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1528248100"); 
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1528748406"); 
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1526949333");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (6, "1527250000");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (6, "1527049666");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (7, "1526848567");

-- First level Comments
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1528848406");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1528847306");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1528848412");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1528848452");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (2, "1528848322");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (2, "1528847423");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (2, "1528843454");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (2, "1528841235");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1528846735");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1528846375");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1528836462");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1528842854");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (4, "1528842375");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (4, "1528845825");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (4, "1528846492");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (4, "1528846923");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1528840014");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1528856386");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1528847852");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1528846257");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (6, "1528848888");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (6, "1528842639");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (6, "1528841111");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (6, "1528842222");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (7, "1528843333");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (7, "1528844444");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (7, "1528845555");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (7, "1528846666");

-- Sub Comments
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (7, "1538858406");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (7, "1538867306");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (6, "1538878412");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (6, "1538888452");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (6, "1538898322");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (6, "1538907423");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (6, "1538913454");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1538921235");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1538936735");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1538946375");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1538956462");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1538962854");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (5, "1538972375");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1538985825");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1538996492");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1539006923");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1539010014");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1539026386");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (1, "1539037852");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (2, "1539046257");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (2, "1539058888");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1539062639");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1539071111");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1539082222");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1539093333");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (3, "1539104444");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (4, "1539115555");
INSERT INTO VotableEntity (user_id, votable_entity_creation_date) VALUES (4, "1539126666");

-------------
-- Comments

-- First Level Comments
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (21, 5, 'Amazing!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (22, 2, 'Good picture.');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (23, 13, 'Terrible...');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (24, 1, 'Looks pretty good to me!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (25, 5, 'Really very nice!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (26, 2, 'Not bad!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (27, 13, 'I really dislike this.');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (28, 3, 'Hello! Happy to see you are enjoying you trip :)');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (29, 5, 'Marvelous ...');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (30, 2, 'Could be worse ...');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (31, 13, 'I do not enjoy this.');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (32, 4, 'Nice');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (33, 5, 'Uau, I luv it! <3');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (34, 2, 'Well, that is a great place!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (35, 13, 'The fact that I do not like this story is true.');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (36, 6, ':D');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (37, 5, 'So good, omg!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (38, 2, 'Nice place.');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (39, 13, ':(');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (40, 7, 'Looking fine ;)');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (41, 5, 'Really amazing, gosh :)');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (42, 2, 'I like the light in this photo c:');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (43, 13, 'Not that good ...');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (44, 8, 'Hello! Hope you are enjoying your trip! :)');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (45, 5, 'Looking good!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (46, 2, 'Marvelous ;)');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (47, 13, 'meh :/');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (48, 9, 'Wow!');

-- Sub Comments
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (49, 21, 'Indeed ...');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (50, 21, 'In a certain way, that is true :)');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (51, 22, 'Totally!!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (52, 24, 'I think so too');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (53, 25, 'yep');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (54, 25, ';)');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (55, 27, 'Indeed!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (56, 27, 'Ahah');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (57, 28, ':P');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (58, 30, 'Well, you do have a point!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (59, 30, 'I have also been to this city');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (60, 31, 'I think i have been there before');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (61, 33, 'It think its a good picture');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (62, 34, ':) :)');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (63, 34, 'What a time to be alive');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (64, 36, 'Agreed.');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (65, 36, 'I kind of disagree ...');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (66, 37, 'Well, in a certain way thats true :P');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (67, 39, 'eheheh');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (68, 39, 'lmao!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (69, 40, 'I wish i could go there ...');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (70, 42, 'It is a beautifull beautiful city');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (71, 43, 'Indeed!!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (72, 43, 'That is a valid argument!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (73, 45, 'well ....');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (74, 45, ':D');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (75, 47, 'I am commenting on your comment!');
INSERT INTO Comment (votable_entity_id, parent_entity_id, comment_content) VALUES (76, 47, 'I Completely AGREE with that!!');

------------
-- Stories
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (1, 
    'Alpes', 
    'The Alps are the highest and most extensive mountain range system that lies entirely in Europe, stretching approximately 1,200 kilometres (750 mi) across eight Alpine countries (from west to east): France, Switzerland, Italy, Monaco, Liechtenstein, Austria, Germany, and Slovenia.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (2, 
    'Aztec Pyramid', 
    'Aztec architecture refers to pre-Columbian architecture of the Aztec civilization. Much of the information that is known about Aztec architecture comes from the structures that are still standing. These structures have survived through several centuries because of the strong materials used and the skill of the builders.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (3, 
    'Bilbao Guggenheim', 
    'The Guggenheim Museum Bilbao is a museum of modern and contemporary art designed by Canadian-American architect Frank Gehry, and located in Bilbao, Basque Country, Spain. The museum was inaugurated on 18 October 1997 by King Juan Carlos I of Spain. Built alongside the Nervion River, which runs through the city of Bilbao to the Cantabrian Sea, it is one of several museums belonging to the Solomon R. Guggenheim Foundation and features permanent and visiting exhibits of works by Spanish and international artists. It is one of the largest museums in Spain.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (4, 
    'Branderburg Gates', 
    'The Brandenburg Gate is an 18th-century neoclassical monument in Berlin, built on the orders of Prussian king Frederick William II after the (temporarily) successful restoration of order during the early Batavian Revolution. One of the best-known landmarks of Germany, it was built on the site of a former city gate that marked the start of the road from Berlin to the town of Brandenburg an der Havel, which used to be capital of the Margraviate of Brandenburg.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (5, 
    'Buddhist Temple', 
    'A Buddhist temple is the place of worship for Buddhists, the followers of Buddhism. They include the structures called vihara, stupa, wat and pagoda in different regions and languages. Temples in Buddhism represent the pure land or pure environment of a Buddha. Traditional Buddhist temples are designed to inspire inner and outer peace. Its structure and architecture varies from region to region. Usually, the temple consists not only of its buildings, but also the surrounding environment. The Buddhist temples are designed to symbolize 5 elements: Fire, Air, Earth, Water, and Wisdom.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (6, 
    'Chile', 
    'Chile is a South American country occupying a long, narrow strip of land between the Andes to the east and the Pacific Ocean to the west. It borders Peru to the north, Bolivia to the northeast, Argentina to the east, and the Drake Passage in the far south. Chilean territory includes the Pacific islands of Juan Fernández, Salas y Gómez, Desventuradas, and Easter Island in Oceania. Chile also claims about 1,250,000 square kilometres (480,000 sq mi) of Antarctica, although all claims are suspended under the Antarctic Treaty.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (7, 
    'Easter Island', 
    'Easter Island is a Chilean island in the southeastern Pacific Ocean, at the southeasternmost point of the Polynesian Triangle in Oceania. Easter Island is most famous for its nearly 1,000 extant monumental statues, called moai, created by the early Rapa Nui people. In 1995, UNESCO named Easter Island a World Heritage Site, with much of the island protected within Rapa Nui National Park.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (8, 
    'Egypt', 
    'Egypt, officially the Arab Republic of Egypt, is a country spanning the northeast corner of Africa and southwest corner of Asia by a land bridge formed by the Sinai Peninsula. Egypt is a Mediterranean country bordered by the Gaza Strip and Israel to the northeast, the Gulf of Aqaba to the east, the Red Sea to the east and south, Sudan to the south, and Libya to the west. Across the Gulf of Aqaba lies Jordan, across the Red Sea lies Saudi Arabia, and across the Mediterranean lie Greece, Turkey and Cyprus, although none share a land border with Egypt.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (9, 
    'Eiffel Tower', 
    'The Eiffel Tower is a wrought-iron lattice tower on the Champ de Mars in Paris, France. It is named after the engineer Gustave Eiffel, whose company designed and built the tower. Constructed from 1887–1889 as the entrance to the 1889 Worlds Fair, it was initially criticized by some of Frances leading artists and intellectuals for its design, but it has become a global cultural icon of France and one of the most recognisable structures in the world. The Eiffel Tower is the most-visited paid monument in the world; 6.91 million people ascended it in 2015.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (10, 
    'Empire State Building', 
    'The Empire State Building is a 102-story Art Deco skyscraper in Midtown Manhattan, New York City. Designed by Shreve, Lamb & Harmon and completed in 1931, the building has a roof height of 1,250 feet (380 m) and stands a total of 1,454 feet (443.2 m) tall, including its antenna. Its name is derived from "Empire State", the nickname of New York, which is of unknown origin. As of 2017 the building is the 5th-tallest completed skyscraper in the United States and the 28th-tallest in the world. It is also the 6th-tallest freestanding structure in the Americas.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (11, 
    'Grand Canyon', 
    'The Grand Canyon is a steep-sided canyon carved by the Colorado River in Arizona, United States. The Grand Canyon is 277 miles (446 km) long, up to 18 miles (29 km) wide and attains a depth of over a mile (6,093 feet or 1,857 meters). The canyon and adjacent rim are contained within Grand Canyon National Park, the Kaibab National Forest, Grand Canyon-Parashant National Monument, the Hualapai Indian Reservation, the Havasupai Indian Reservation and the Navajo Nation. President Theodore Roosevelt was a major proponent of preservation of the Grand Canyon area, and visited it on numerous occasions to hunt and enjoy the scenery.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (12, 
    'Great Wall of China', 
    'The Great Wall of China is a series of fortifications made of stone, brick, tamped earth, wood, and other materials, generally built along an east-to-west line across the historical northern borders of China to protect the Chinese states and empires against the raids and invasions of the various nomadic groups of the Eurasian Steppe with an eye to expansion. Several walls were being built as early as the 7th century BC.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (13, 
    'Heidelberg', 
    'Located about 78 km (48 mi) south of Frankfurt, Heidelberg is the fifth-largest city in the German state of Baden-Württemberg. Heidelberg is part of the densely populated Rhine-Neckar Metropolitan Region. Founded in 1386, Heidelberg University is Germanys oldest and one of Europes most reputable universities.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (14, 
    'London', 
    'The City of London is a city and county that contains the historic centre and the primary central business district (CBD) of London. It constituted most of London from its settlement by the Romans in the 1st century AD to the Middle Ages, but the agglomeration has since grown far beyond the Citys borders.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (15, 
    'Louvre', 
    'The Louvre is the worlds largest art museum and a historic monument in Paris, France. A central landmark of the city, it is located on the Right Bank of the Seine in the citys 1st arrondissement (district or ward). Approximately 38,000 objects from prehistory to the 21st century are exhibited over an area of 72,735 square metres (782,910 square feet). In 2017, the Louvre was the worlds most visited art museum, receiving 8.1 million visitors.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (16, 
    'Machu Picchu', 
    'Machu Picchu is a 15th-century Inca citadel, located in the Eastern Cordillera of southern Peru, on a mountain ridge 2,430 metres (7,970 ft) above sea level.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (17, 
    'Orsay', 
    'The Musée dOrsay is a museum in Paris, France, on the Left Bank of the Seine. It is housed in the former Gare dOrsay, a Beaux-Arts railway station built between 1898 and 1900. The museum holds mainly French art dating from 1848 to 1914, including paintings, sculptures, furniture, and photography. It houses the largest collection of impressionist and post-Impressionist masterpieces in the world, by painters including Monet, Manet, Degas, Renoir, Cézanne, Seurat, Sisley, Gauguin, and Van Gogh. Many of these works were held at the Galerie nationale du Jeu de Paume prior to the museums opening in 1986. It is one of the largest art museums in Europe. Musée dOrsay had 3.177 million visitors in 2017.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (18, 
    'Partenon', 
    'The Parthenon is a former temple on the Athenian Acropolis, Greece, dedicated to the goddess Athena, whom the people of Athens considered their patron. Construction began in 447 BC when the Athenian Empire was at the peak of its power. It was completed in 438 BC, although decoration of the building continued until 432 BC. It is the most important surviving building of Classical Greece, generally considered the zenith of the Doric order. Its decorative sculptures are considered some of the high points of Greek art.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (19, 
    'Petra', 
    'Petra, originally known to its inhabitants as Raqmu, is a historical and archaeological city in southern Jordan. Petra lies on the slope of Jabal Al-Madbah in a basin among the mountains which form the eastern flank of Arabah valley that run from the Dead Sea to the Gulf of Aqaba. Petra is believed to have been settled as early as 9,000 BC, and it was possibly established in the 4th century BC as the capital city of the Nabataean Kingdom. The Nabataeans were nomadic Arabs who invested in Petras proximity to the trade routes by establishing it as a major regional trading hub.'
);
INSERT INTO Story (votable_entity_id, story_title, story_content) VALUES (20, 
    'Rome Colosseum', 
    'The Colosseum or Coliseum, also known as the Flavian Amphitheatre, is an oval amphitheatre in the centre of the city of Rome, Italy. Built of travertine, tuff, and brick-faced concrete, it is the largest amphitheatre ever built. The Colosseum is situated just east of the Roman Forum. Construction began under the emperor Vespasian in AD 72, and was completed in AD 80 under his successor and heir Titus.'
);

-----------
-- Votes
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 5);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 2, 5);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 3, 5);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 4, 5);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 5, 5);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 6, 5);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 7, 5);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 1, 13);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 2, 13);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 3, 13);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 4, 13);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 5, 13);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 6, 13);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 7, 13);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 2);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 2, 2);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 3, 2);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 4, 2);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 5, 2);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 6, 2);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 7, 2);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 3);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 1, 4);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 6);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 7);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 1, 8);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 9);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 10);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 11);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 1, 12);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 14);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 15);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 16);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 1, 17);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 18);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 19);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 2, 14);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 2, 15);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 2, 16);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 2, 17);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 2, 18);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 2, 19);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 3, 12);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 3, 11);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 3, 14);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 3, 15);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 3, 16);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 3, 17);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 4, 6);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 4, 7);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 4, 8);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 4, 9);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 4, 10);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 4, 11);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 5, 3);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 5, 4);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 5, 6);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 5, 7);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 5, 8);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 5, 9);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 6, 1);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 6, 3);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 6, 4);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 6, 6);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 6, 20);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 6, 7);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 7, 20);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 7, 19);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 7, 18);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 7, 17);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 7, 16);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 7, 15);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 21);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 2, 22);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 3, 23);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 4, 24);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 5, 25);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 6, 26);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 7, 27);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 28);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 2, 29);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 3, 30);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 4, 31);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 5, 32);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 6, 33);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 7, 34);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 1, 35);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 2, 36);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 3, 37);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 4, 38);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 5, 39);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 6, 40);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 7, 41);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 42);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 2, 43);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 3, 44);

INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 7, 76);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 6, 74);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 5, 72);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 4, 70);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 3, 68);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 2, 66);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 1, 64);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 2, 62);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 3, 60);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 4, 58);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 5, 56);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 6, 54);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 7, 52);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (1, 1, 50);
INSERT INTO Vote (vote_value, user_id, votable_entity_id) VALUES (-1, 1, 57);