-- Create Accounts
INSERT INTO Account(username, password, description) 
	VALUES ('admin', 'admin', 'Blabber Test Account');
	
INSERT INTO Account(username, password, description) 
	VALUES ('BlabberSupport', 'password', 'Here to answer your questions.');

INSERT INTO Account(username, password, description) 
	VALUES ('Corned', 'password', 'I write programs and program accessories.');

INSERT INTO Account(username, password, description) 
	VALUES ('Follow4Follow', 'password', 'You follow me, I follow you. It''s that simple.');
	
INSERT INTO Account(username, password, description) 
	VALUES ('Jack', 'password', 'My name is Eminem and I''m here to say, if you study each night you can get straight A''s');
	
INSERT INTO Account(username, password, description) 
	VALUES ('Batman', 'password', 'Na na na na na na na na na na na na na na na na..');	

INSERT INTO Account(username, password, description) 
	VALUES ('Joker', 'password', 'Hahahahhaa');

-- Create Blabs
INSERT INTO Blab (account_id, username, body)
	VALUES (1, 'admin', 'Blabber Online');

INSERT INTO Blab (account_id, username, body)
	VALUES (2, 'BlabberSupport', 'Hello, we are here to help.');

INSERT INTO Blab (account_id, username, body)
	VALUES (3, 'Corned', 'EDIT THIS BLAB!!!!!!');

INSERT INTO Blab (account_id, username, body)
	VALUES (3, 'Corned', 'Check out the source: https://github.com/Corned/Blabber :D');

INSERT INTO Blab (account_id, username, body)
	VALUES (4, 'Follow4Follow', 'FOLLOW FOR FOLLOW!!!! LET''S GAIN FOLLOWERS TOGETHER!!');

INSERT INTO Blab (account_id, username, body)
	VALUES (5, 'Jack', 'Lightswitch amirite');

INSERT INTO Blab (account_id, username, body)
	VALUES (5, 'Jack', 'Who did dis???');

INSERT INTO Blab (account_id, username, body)
	VALUES (6, 'Batman', 'Day 26: Still no sight of Joker..');

INSERT INTO Blab (account_id, username, body)
	VALUES (7, 'Joker', 'Day 26: Batman still hasn''t noticed me.');

-- Create Follows
-- BlabberSupport -> others
INSERT INTO Follow (account_id, follower_id)
	VALUES (2, 3);
	
INSERT INTO Follow (account_id, follower_id)
	VALUES (2, 4);
	
INSERT INTO Follow (account_id, follower_id)
	VALUES (2, 5);
	
INSERT INTO Follow (account_id, follower_id)
	VALUES (2, 6);
	
INSERT INTO Follow (account_id, follower_id)
	VALUES (2, 7);

-- Corned -> Others
INSERT INTO Follow (account_id, follower_id)
	VALUES (3, 1);
	
INSERT INTO Follow (account_id, follower_id)
	VALUES (3, 2);
	
INSERT INTO Follow (account_id, follower_id)
	VALUES (3, 4);
	
INSERT INTO Follow (account_id, follower_id)
	VALUES (3, 5);

-- Follow4Follow -> Others
INSERT INTO Follow (account_id, follower_id)
	VALUES (4, 6);

INSERT INTO Follow (account_id, follower_id)
	VALUES (4, 7);

INSERT INTO Follow (account_id, follower_id)
	VALUES (6, 4);

INSERT INTO Follow (account_id, follower_id)
	VALUES (7, 4);





