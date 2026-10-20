
DROP DATABASE IF EXISTS login;
CREATE DATABASE login;

USE login;

DROP TABLE IF EXISTS appuser;

CREATE TABLE appuser (
    email VARCHAR(100),
    name VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    PRIMARY KEY(email)
);