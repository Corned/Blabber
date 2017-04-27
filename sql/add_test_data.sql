/* id 1 */ INSERT INTO Account(username, password) VALUES ('admin', 'admin');
/* id 2 */ INSERT INTO Account(username, password) VALUES ('Corned', 'corned');
/* id 3 */ INSERT INTO Account(username, password) VALUES ('Maissitettu', 'maissitettu');
/* id 4 */ INSERT INTO Account(username, password) VALUES ('XxXMasterXxX', 'salasana');
/* id 5 */ INSERT INTO Account(username, password) VALUES ('Jussi', 'salasana');
/* id 6 */ INSERT INTO Account(username, password) VALUES ('Maisa', 'salasana');
/* id 7 */ INSERT INTO Account(username, password) VALUES ('Muurari', 'salasana');
/* id 8 */ INSERT INTO Account(username, password) VALUES ('ElPresidente', 'salasana');
/* id 9 */ INSERT INTO Account(username, password) VALUES ('Saitama', 'salasana');

INSERT INTO Follow(account_id, follower_id) VALUES (0, 1);
INSERT INTO Follow(account_id, follower_id) VALUES (0, 3);
INSERT INTO Follow(account_id, follower_id) VALUES (0, 5);
INSERT INTO Follow(account_id, follower_id) VALUES (0, 7);

INSERT INTO Follow(account_id, follower_id) VALUES (2, 0);
INSERT INTO Follow(account_id, follower_id) VALUES (4, 0);
INSERT INTO Follow(account_id, follower_id) VALUES (6, 0);
INSERT INTO Follow(account_id, follower_id) VALUES (8, 0);

INSERT INTO Blab(id, body) VALUES (0, "Admin Test Blab, Corned and Muurari likes this blab.");
INSERT INTO Favourite(account_id, blab_id) VALUES (1, 0);
INSERT INTO Favourite(account_id, blab_id) VALUES (6, 0);
