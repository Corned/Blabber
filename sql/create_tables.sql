-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Player(
    id SERIAL PRIMARY KEY,
    name varchar(50) NOT NULL,
    password varchar(50) NOT NULL
);

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
    body varchar(256) NOT NULL
);

CREATE TABLE AccountBlab(
    account_id INTEGER REFERENCES Account(id),
    blab_id INTEGER REFERENCES Blab(id)
);


CREATE TABLE Thumb(
    id SERIAL PRIMARY KEY
);

CREATE TABLE AccountThumb(
    account_id INTEGER REFERENCES Account(id),
    thumb_id INTEGER REFERENCES Thumb(id)
);


CREATE TABLE Reblab(
    id SERIAL PRIMARY KEY
);

CREATE TABLE AccountReblab(
    account_id INTEGER REFERENCES Account(id),
    reblab_id INTEGER REFERENCES Reblab(id)
);
