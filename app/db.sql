CREATE TABLE admin(
    id INTEGER NOT NULL PRIMARY KEY, 
    username VARCHAR(255), 
    password VARCHAR(255)
);
CREATE TABLE card(
    id INTEGER NOT NULL PRIMARY KEY,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    profilepicture VARCHAR(255),
    title VARCHAR(255),
    birthday date,
    theme VARCHAR(255)
);
CREATE TABLE email(
    id INTEGER NOT NULL PRIMARY KEY,
    email VARCHAR(255),
    position INTEGER NOT NULL DEFAULT '0'
);
CREATE TABLE phonenumber(
    id INTEGER NOT NULL PRIMARY KEY,
    phonenumber VARCHAR(255),
    position INTEGER NOT NULL DEFAULT '0'
);
CREATE TABLE website(
    id INTEGER NOT NULL PRIMARY KEY,
    url VARCHAR(255),
    title VARCHAR(255),
    position INTEGER NOT NULL DEFAULT '0'
);
CREATE TABLE link(
    id INTEGER NOT NULL PRIMARY KEY,
    url VARCHAR(255),
    title VARCHAR(255),
    icon VARCHAR(255),
    position INTEGER NOT NULL DEFAULT '0'
);
CREATE TABLE lang(
    id INTEGER NOT NULL PRIMARY KEY,
    lang VARCHAR(255)
);
CREATE TABLE text(
    id INTEGER NOT NULL PRIMARY KEY,
    text longtext,
    category VARCHAR(255)
);
CREATE TABLE content(
    id INTEGER NOT NULL PRIMARY KEY,
    lang_id INTEGER,
    text_id INTEGER,
    FOREIGN KEY(lang_id) REFERENCES lang(id),
    FOREIGN KEY(text_id) REFERENCES text(id)
);