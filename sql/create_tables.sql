CREATE TABLE Account(
    id SERIAL NOT NULL,
    username varchar(20) NOT NULL,
    password varchar(32) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE Blab(
    id SERIAL NOT NULL,
    account_id INTEGER REFERENCES Account(id),
    username varchar(20) NOT NULL,
    body varchar(256) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE Favourite(
    account_id INTEGER REFERENCES Account(id),
    blab_id INTEGER REFERENCES Blab(id)
);

CREATE TABLE Follow(
    account_id INTEGER REFERENCES Account(id),
    follower_id INTEGER REFERENCES Account(id)
)
