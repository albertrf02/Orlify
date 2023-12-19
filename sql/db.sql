-- Crear la base de dades
DROP DATABASE IF EXISTS orlify;
CREATE DATABASE orlify;

use orlify;


-- Crear la tabla Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    surname VARCHAR(255),
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    avatar VARCHAR(255),
    role INT,
    token varchar(250) NOT NULL,
    token_expiration datetime
);



-- Crear la tabla ClassGroup
CREATE TABLE classGroup (
    id INT AUTO_INCREMENT PRIMARY KEY,
    className VARCHAR(255)
);

-- Crear la taula de la relació users - classGroup
CREATE TABLE users_classGroup (
    idUser INT,
    idGroupClass INT,
    PRIMARY KEY (idUser, idGroupClass),
    FOREIGN KEY (idUser) REFERENCES users(id),
    FOREIGN KEY (idGroupClass) REFERENCES classGroup(id)
);

-- Crear la taula de les orles
CREATE TABLE orla (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    visibility BOOLEAN,
    idCreator INT,
    FOREIGN KEY (idCreator) REFERENCES users(id)
);

-- Crear la taula per a les imatges
CREATE TABLE photography (
    id INT AUTO_INCREMENT PRIMARY KEY,
    link VARCHAR(255),
    defaultPhoto BOOLEAN,
    idUser INT,
    FOREIGN KEY (idUser) REFERENCES users(id)
    );

-- Crear la taula per a la tarjeta
CREATE TABLE studentCard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255),
    idStudent INT UNIQUE,
    FOREIGN KEY (idStudent) REFERENCES users(id)
);

CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idUser INT,
    idPhoto INT,
    FOREIGN KEY (idUser) REFERENCES users(id),
    FOREIGN KEY (idPhoto) REFERENCES photography(id)
);

-- Crear la taula per als rols
CREATE TABLE roles (
    idRole INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE
);

-- Alter the orla table to include a foreign key for classGroup
ALTER TABLE orla
ADD COLUMN idClassGroup INT,
ADD FOREIGN KEY (idClassGroup) REFERENCES classGroup(id);


-- Create a table to relate users with orla
CREATE TABLE user_orla (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idUser INT,
    idOrla INT,
    FOREIGN KEY (idUser) REFERENCES users(id),
    FOREIGN KEY (idOrla) REFERENCES orla(id)
);


ALTER TABLE users
ADD FOREIGN KEY (role) REFERENCES roles(idRole);

INSERT INTO `roles` (`name`) VALUES ('student');
INSERT INTO `roles` (`name`) VALUES ('teacher');
INSERT INTO `roles` (`name`) VALUES ('team');
INSERT INTO `roles` (`name`) VALUES ('admin');

-- Modificar les taules
ALTER TABLE photography
ADD FOREIGN KEY (idUser) REFERENCES Users(id);

ALTER TABLE classgroup
ADD COLUMN state TINYINT(1) NOT NULL DEFAULT 1;
