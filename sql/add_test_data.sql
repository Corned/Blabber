-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Account(username, password) VALUES ('Corned', 'qwerty1234');
INSERT INTO Account(username, password) VALUES ('Maissitettu', 'asdfgh1234');

INSERT INTO AccountFollow(account_id, follow_id) VALUES (1, 2);

INSERT INTO Blab(id, body) VALUES (1, 'Hello world!');
INSERT INTO Blab(id, body) VALUES (2, 'Second Blab!');
INSERT INTO AccountBlab(account_id, blab_id) VALUES (1, 1);
INSERT INTO AccountBlab(account_id, blab_id) VALUES (1, 2);
