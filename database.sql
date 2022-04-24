CREATE DATABASE IF NOT EXISTS instagram_clone;
USE instagram_clone;

CREATE TABLE users(
    id              int(255) auto_increment not null, 
    role            varchar(20),
    name            varchar(100),
    surname         varchar(200),
    nick            varchar(100),
    email           varchar(255),
    password        varchar(255),
    image           varchar(255),
    created_at      datetime, 
    updated_at      datetime, 
    remember_token  varchar(255),
    CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb; 

INSERT INTO users VALUES(NULL, 'user', 'Guillem', 'Vila', 'Guillem', 'guillem.vtorrent@gmail.com', 'pass', NULL, CURTIME(), CURTIME(), NULL); 
INSERT INTO users VALUES(NULL, 'user', 'Miquel', 'Perez', 'Miquel', 'miquel@gmail.com', 'pass', NULL, CURTIME(), CURTIME(), NULL); 
INSERT INTO users VALUES(NULL, 'user', 'Joaquim', 'Ors', 'Joaquim', 'joaquim@gmail.com', 'pass', NULL, CURTIME(), CURTIME(), NULL); 

CREATE TABLE IF NOT EXISTS images(
    id              int(255) auto_increment not null, 
    user_id         int(255),
    image_path      varchar(255),
    description     text, 
    created_at      datetime, 
    updated_at      datetime, 
    CONSTRAINT pk_images PRIMARY KEY(id),
    CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb; 

INSERT INTO images VALUES(NULL, 1, 'test.jpg', 'test description 1', CURTIME(), CURTIME()); 
INSERT INTO images VALUES(NULL, 1, 'beach.jpg', 'test description 2', CURTIME(), CURTIME()); 
INSERT INTO images VALUES(NULL, 2, 'sand.jpg', 'test description 3', CURTIME(), CURTIME()); 
INSERT INTO images VALUES(NULL, 3, 'family.jpg', 'test description 4', CURTIME(), CURTIME()); 


CREATE TABLE IF NOT EXISTS comments(
    id              int(255) auto_increment not null, 
    user_id         int(255),
    image_id        int(255),
    content         text,
    created_at      datetime, 
    updated_at      datetime, 
    CONSTRAINT pk_comments PRIMARY KEY(id),
    CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb; 

INSERT INTO comments VALUES(NULL, 1, 4, 'Nice family picture!', CURTIME(), CURTIME()); 
INSERT INTO comments VALUES(NULL, 2, 1, 'Nice picture!', CURTIME(), CURTIME()); 
INSERT INTO comments VALUES(NULL, 3, 2, 'Love it!', CURTIME(), CURTIME()); 

CREATE TABLE IF NOT EXISTS likes(
    id              int(255) auto_increment not null, 
    user_id         int(255),
    image_id        int(255),
    created_at      datetime, 
    updated_at      datetime, 
    CONSTRAINT pk_likes PRIMARY KEY(id),
    CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb; 

INSERT INTO likes VALUES(NULL, 1, 4, CURTIME(), CURTIME()); 
INSERT INTO likes VALUES(NULL, 2, 3, CURTIME(), CURTIME()); 
INSERT INTO likes VALUES(NULL, 3, 2, CURTIME(), CURTIME()); 
INSERT INTO likes VALUES(NULL, 3, 1, CURTIME(), CURTIME()); 

