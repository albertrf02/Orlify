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
    role INT
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

-- Crear la taula per als rols
CREATE TABLE roles (
    idRole INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE
);

-- Create a table to relate users with orla
CREATE TABLE user_orla_relation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idUser INT,
    idOrla INT,
    PRIMARY KEY (idUser, idOrla),
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

INSERT INTO `users` (`Id`, `name`, `surname`, `username`, `password`, `email`, `avatar`, role) VALUES
(1, 'albert', 'rocas', 'arocas', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'albert@albert.com', NULL, 1);
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, 'https://www.santevet.es/uploads/images/es_ES/razas/gatocomuneuropeo.jpeg', '1', '1');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, 'https://hospitalveterinariodonostia.com/wp-content/uploads/2020/10/gatos.png', '0', '1');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, 'https://www.petz.com.br/blog/wp-content/uploads/2021/11/enxoval-para-gato-Copia.jpg', '0', '1');

