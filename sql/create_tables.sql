CREATE TABLE Account(
    id SERIAL NOT NULL,
    username varchar(32) NOT NULL,
    password varchar(32) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE AccountSettings(
    account_id INTEGER REFERENCES Account(id)
);

CREATE TABLE AccountFollow(
    account_id INTEGER REFERENCES Account(id),
    follow_id INTEGER NOT NULL
);


CREATE TABLE Blab(
    id SERIAL NOT NULL,
    body varchar(256) NOT NULL,
    deleted boolean DEFAULT FALSE,
    PRIMARY KEY(id)
);

CREATE TABLE AccountBlab(
    account_id INTEGER REFERENCES Account(id),
    blab_id INTEGER REFERENCES Blab(id)
);
