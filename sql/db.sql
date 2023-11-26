-- Crear la base de dades
DROP DATABASE IF EXISTS orlify;
CREATE DATABASE orlify;

-- Crear la taula d'usuaris
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    surname VARCHAR(255),
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    avatar VARCHAR(255),
    role INT
);

-- Crear la taula de classes
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
    link VARCHAR(255),
    visibility BOOLEAN,
    format VARCHAR(255),
    creationDate DATE,
    creator INT,
    FOREIGN KEY (creator) REFERENCES users(id)
);

-- Crear la taula per a les imatges
CREATE TABLE photography (
    id INT AUTO_INCREMENT PRIMARY KEY,
    link VARCHAR(255),
    idStudent INT,
    idProfessor INT,
    FOREIGN KEY (idStudent) REFERENCES users(id),
    FOREIGN KEY (idProfessor) REFERENCES users(id)
);

-- Crear la taula per a la tarjeta
CREATE TABLE studentCard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255),
    idStudent INT UNIQUE,
    FOREIGN KEY (idStudent) REFERENCES users(id)
);

-- Crear la taula per als rols
CREATE TABLE roles (
    idRole INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE
);

-- Modificar les taules
ALTER TABLE photography
ADD FOREIGN KEY (idStudent) REFERENCES users(id);

ALTER TABLE users
ADD FOREIGN KEY (role) REFERENCES roles(idRole);