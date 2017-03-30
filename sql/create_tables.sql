CREATE TABLE Account(
    id SERIAL PRIMARY KEY,
    username varchar(32) NOT NULL,
    password varchar(32) NOT NULL
);

CREATE TABLE AccountSettings(
    account_id INTEGER REFERENCES Account(id)
);

CREATE TABLE AccountFollow(
    account_id INTEGER REFERENCES Account(id),
    follow_id INTEGER NOT NULL
);


CREATE TABLE Blab(
    id SERIAL PRIMARY KEY,
    body varchar(256) NOT NULL,
    deleted boolean NOT NULL
);

CREATE TABLE AccountBlab(
    account_id INTEGER REFERENCES Account(id),
    blab_id INTEGER REFERENCES Blab(id)
);
