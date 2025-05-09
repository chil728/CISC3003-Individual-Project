CREATE DATABASE ooplogin;  -- Database For Practice01

CREATE TABLE users (
    users_uid INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    users_uid TINYTEXT NOT NULL,
    users_pwd LONGTEXT NOT NULL,
    users_email TINYTEXT NOT NULL
);