-- Crear la tabla Users
CREATE TABLE users (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    surname VARCHAR(255),
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    avatar VARCHAR(255),
    role VARCHAR(255)
);

-- Crear la tabla ClassGroup
CREATE TABLE classGroup (
    id INT PRIMARY KEY,
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
    id INT PRIMARY KEY,
    link VARCHAR(255),
    visibility BOOLEAN,
    format VARCHAR(255),
    creationDate DATE,
    creator INT,
    FOREIGN KEY (creator) REFERENCES Users(id)
);

-- Crear la tabla Photography
CREATE TABLE photography (
    id INT PRIMARY KEY,
    link VARCHAR(255),
    idStudent INT,
    idProfessor INT,
    FOREIGN KEY (idStudent) REFERENCES Users(id),
    FOREIGN KEY (idProfessor) REFERENCES Users(id)
);

-- Crear la tabla StudentCard y la relación 1 - 1 con Users
CREATE TABLE studentCard (
    id INT PRIMARY KEY,
    url VARCHAR(255),
    idStudent INT UNIQUE,
    FOREIGN KEY (idStudent) REFERENCES Users(id)
);

-- Agregar la relación 1 - N entre Users y Photography
ALTER TABLE photography
ADD FOREIGN KEY (idStudent) REFERENCES Users(id);