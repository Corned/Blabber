-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Account(username, password) VALUES ('Corned', 'qwerty1234'); -- id = 1
INSERT INTO Account(username, password) VALUES ('Maissitettu', 'asdfgh1234'); -- id = 2

INSERT INTO AccountFollow(account_id, follow_id) VALUES (1, 2);

-- Blabs
INSERT INTO Blab(id, body) VALUES (1, 'Hello world!');
INSERT INTO AccountBlab(account_id, blab_id) VALUES (1, 1);

INSERT INTO Blab(id, body) VALUES (2, 'Second Blab!');
INSERT INTO AccountBlab(account_id, blab_id) VALUES (1, 2);

INSERT INTO Blab(id, body) VALUES (3, 'Third Blab! My name is Maissitettu!');
INSERT INTO AccountBlab(account_id, blab_id) VALUES (2, 3);

INSERT INTO Blab(id, body) VALUES (4, 'Fourth Blab!! Anybody play Rocket League? -Corned');
INSERT INTO AccountBlab(account_id, blab_id) VALUES (1, 4);
