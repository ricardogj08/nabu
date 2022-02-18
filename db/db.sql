/*
DROP DATABASE IF EXISTS nabu;
*/

CREATE DATABASE IF NOT EXISTS nabu
    CHARACTER SET = 'utf8mb4'
    COLLATE       = 'utf8mb4_general_ci';

USE nabu;

CREATE TABLE IF NOT EXISTS `roles` (
    `id`       TINYINT UNSIGNED NOT NULL,
    `name`     VARCHAR(20)      NOT NULL,
    CONSTRAINT roles_id_pk      PRIMARY KEY(id),
    CONSTRAINT roles_name_uk    UNIQUE(name)
);

CREATE TABLE IF NOT EXISTS `users` (
    `id`                INT UNSIGNED      NOT NULL AUTO_INCREMENT,
    `role_id`           TINYINT UNSIGNED  NOT NULL DEFAULT 3,
    `name`              VARCHAR(255)      NOT NULL,
    `username`          VARCHAR(255)      NOT NULL,
    `email`             VARCHAR(255),
    `password`          VARCHAR(255)      NOT NULL,
    `activated`         TINYINT(1)        NOT NULL DEFAULT FALSE,
    `registration_date` DATETIME(0)       NOT NULL,
    CONSTRAINT          users_id_pk       PRIMARY KEY(id),
    CONSTRAINT          users_username_uk UNIQUE(username),
    CONSTRAINT          users_email_uk    UNIQUE(email),
    CONSTRAINT          users_role_id_fk  FOREIGN KEY(role_id) REFERENCES roles(id) ON UPDATE RESTRICT ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS `authentications` (
    `id`         INT UNSIGNED          NOT NULL,
    `hash`       VARCHAR(255)          NOT NULL,
    `expiration` INT UNSIGNED          NOT NULL,
    CONSTRAINT   authentications_id_pk PRIMARY KEY(id),
    CONSTRAINT   authentications_id_fk FOREIGN KEY(id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `profiles` (
    `id`          INT UNSIGNED           NOT NULL,
    `avatar`      VARCHAR(255),
    `background`  VARCHAR(255),
    `description` VARCHAR(255),
    CONSTRAINT    profiles_id_pk         PRIMARY KEY(id),
    CONSTRAINT    profiles_id_fk         FOREIGN KEY(id) REFERENCES users(id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    CONSTRAINT    profiles_avatar_uk     UNIQUE(avatar),
    CONSTRAINT    profiles_background_uk UNIQUE(background)
);

CREATE TABLE IF NOT EXISTS `articles` (
    `id`                INT UNSIGNED        NOT NULL AUTO_INCREMENT,
    `user_id`           INT UNSIGNED        NOT NULL,
    `title`             VARCHAR(246)        NOT NULL,
    `synopsis`          VARCHAR(255)        NOT NULL,
    `body`              MEDIUMTEXT          NOT NULL,
    `slug`              VARCHAR(255)        NOT NULL,
    `cover`             VARCHAR(255),
    `authorized`        TINYINT(1)          NOT NULL DEFAULT FALSE,
    `creation_date`     DATETIME(0)         NOT NULL,
    `modification_date` DATETIME(0),
    CONSTRAINT          articles_id_pk      PRIMARY KEY(id),
    CONSTRAINT          articles_user_id_fk FOREIGN KEY(user_id) REFERENCES users(id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    CONSTRAINT          articles_slug_uk    UNIQUE(slug),
    CONSTRAINT          articles_cover_uk   UNIQUE(cover)
);

CREATE TABLE IF NOT EXISTS `authorizations` (
    `id`                 INT UNSIGNED                 NOT NULL,
    `user_id`            INT UNSIGNED                 NOT NULL,
    `authorization_date` DATETIME(0)                  NOT NULL,
    CONSTRAINT           authorizations_pk            PRIMARY KEY(id),
    CONSTRAINT           authorizations_id_fk         FOREIGN KEY(id)      REFERENCES articles(id) ON UPDATE CASCADE  ON DELETE CASCADE,
    CONSTRAINT           authorizations_user_id_fk    FOREIGN KEY(user_id) REFERENCES users(id)    ON UPDATE RESTRICT ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS `comments` (
    `user_id`      INT UNSIGNED           NOT NULL,
    `article_id`   INT UNSIGNED           NOT NULL,
    `body`         VARCHAR(255)           NOT NULL,
    `comment_date` DATETIME(0)            NOT NULL,
    CONSTRAINT     comments_pk            PRIMARY KEY(user_id, comment_date),
    CONSTRAINT     comments_user_id_fk    FOREIGN KEY(user_id)    REFERENCES users(id)    ON UPDATE RESTRICT ON DELETE RESTRICT,
    CONSTRAINT     comments_article_id_fk FOREIGN KEY(article_id) REFERENCES articles(id) ON UPDATE CASCADE  ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `favorites` (
    `user_id`    INT UNSIGNED            NOT NULL,
    `article_id` INT UNSIGNED            NOT NULL,
    CONSTRAINT   favorites_pk            PRIMARY KEY(user_id, article_id),
    CONSTRAINT   favorites_user_id_fk    FOREIGN KEY(user_id)    REFERENCES users(id)    ON UPDATE RESTRICT ON DELETE RESTRICT,
    CONSTRAINT   favorites_article_id_fk FOREIGN KEY(article_id) REFERENCES articles(id) ON UPDATE CASCADE  ON DELETE CASCADE
);

INSERT INTO roles(id, name) VALUES(1, 'ADMIN'), (2, 'MODERATOR'), (3, 'USER');
