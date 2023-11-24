DROP DATABASE IF EXISTS orlify;
CREATE DATABASE orlify;

-- Crear la tabla Users
CREATE TABLE users (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    surname VARCHAR(255),
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    avatar VARCHAR(255),
    role VARCHAR(255)
);

--
ALTER TABLE users
MODIFY COLUMN role ENUM('user', 'teacher', 'admin', 'team') NOT NULL;

-- Crear la tabla ClassGroup
CREATE TABLE classGroup (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    className VARCHAR(255)
);

-- Crear la tabla Users_ClassGroup para la relación N - M
CREATE TABLE users_classGroup (
    userId INT,
    classGroupId INT,
    PRIMARY KEY (userId, classGroupId),
    FOREIGN KEY (userId) REFERENCES Users(id),
    FOREIGN KEY (classGroupId) REFERENCES ClassGroup(id)
);

-- Crear la tabla Orla
CREATE TABLE orla (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    link VARCHAR(255),
    visibility BOOLEAN,
    format VARCHAR(255),
    creationDate DATE,
    creator INT,
    FOREIGN KEY (creator) REFERENCES Users(id)
);

-- Crear la tabla Photography
CREATE TABLE photography (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    link VARCHAR(255),
    idStudent INT,
    idProfessor INT,
    FOREIGN KEY (idStudent) REFERENCES Users(id),
    FOREIGN KEY (idProfessor) REFERENCES Users(id)
);

-- Crear la tabla StudentCard y la relación 1 - 1 con Users
CREATE TABLE studentCard (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255),
    idStudent INT UNIQUE,
    FOREIGN KEY (idStudent) REFERENCES Users(id)
);

-- Agregar la relación 1 - N entre Users y Photography
ALTER TABLE photography
ADD FOREIGN KEY (idStudent) REFERENCES Users(id);