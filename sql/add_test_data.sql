INSERT INTO Account(id, username, password) VALUES (0, 'admin', 'admin');
INSERT INTO Account(id, username, password) VALUES (1, 'Corned', 'corned');
INSERT INTO Account(id, username, password) VALUES (2, 'Maissitettu', 'maissitettu');
INSERT INTO Account(id, username, password) VALUES (3, 'XxXMasterXxX', 'salasana');
INSERT INTO Account(id, username, password) VALUES (4, 'Jussi', 'salasana');
INSERT INTO Account(id, username, password) VALUES (5, 'Maisa', 'salasana');
INSERT INTO Account(id, username, password) VALUES (6, 'Muurari', 'salasana');
INSERT INTO Account(id, username, password) VALUES (7, 'ElPresidente', 'salasana');
INSERT INTO Account(id, username, password) VALUES (8, 'Saitama', 'salasana');

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
