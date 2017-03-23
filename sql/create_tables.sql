-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Account(
    id SERIAL PRIMARY KEY,
    username varchar(32),
    password varchar(32)
)

CREATE TABLE AccountSettings(
    account_id INTEGER REFERENCES Account(id)
)

CREATE TABLE AccountFollow(
    account_id INTEGER REFERENCES Account(id),
    follow_id INTEGER
)


CREATE TABLE Bleb(
    id SERIAL PRIMARY KEY,
    body varchar(256)
)

CREATE TABLE AccountBleb(
    account_id INTEGER REFERENCES Account(id),
    bleb_id INTEGER REFERENCES Bleb(id)
)


CREATE TABLE Like(
    id SERIAL PRIMARY KEY
)

CREATE TABLE AccountLike(
    account_id INTEGER REFERENCES Account(id),
    like_id INTEGER REFERENCES Like(id)
)


CREATE TABLE Rebleb(
    id SERIAL PRIMARY KEY
)

CREATE TABLE AccountRebleb(
    account_id INTEGER REFERENCES Account(id),
    rebleb_id INTEGER REFERENCES Rebleb(id)
)
