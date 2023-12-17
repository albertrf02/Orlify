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
    public BOOLEAN,
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

INSERT INTO `users` (`Id`, `name`, `surname`, `username`, `password`, `email`, `avatar`, role) VALUES
(1, 'albert', 'rocas', 'arocas', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'arocas@cendrassos.net', NULL, 1),
(2, 'john', 'doe', 'jdoe', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'john@doe.com', NULL, 2),
(3, 'emma', 'smith', 'esmith', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'emma@smith.com', NULL, 1),
(4, 'david', 'brown', 'dbrown', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'david@brown.com', NULL, 1),
(5, 'sophie', 'martin', 'smartin', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'sophie@martin.com', NULL, 1),
(6, 'alejandro', 'espinoza', 'aespinoza', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'aespinoza@cendrassos.net', NULL, 1),
(7, 'lisa', 'miller', 'lmiller', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'lisa@miller.com', NULL, 1),
(8, 'peter', 'wilson', 'pwilson', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'peter@wilson.com', NULL, 1),
(9, 'grace', 'rodriguez', 'grodriguez', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'grace@rodriguez.com', NULL, 1),
(10, 'olivia', 'anderson', 'oanderson', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'olivia@anderson.com', NULL, 2),
(11, 'nathan', 'lopez', 'nlopez', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'nathan@lopez.com', NULL, 1),
(12, 'zoey', 'garcia', 'zgarcia', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'zoey@garcia.com', NULL, 1),
(13, 'isaac', 'turner', 'iturner', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'isaac@turner.com', NULL, 1),
(14, 'chloe', 'roberts', 'croberts', '$2y$10$fnefNZkgBjPJfmRN0SxeQuQ9K8Q5e2rrb11CpGeFvQMLV79fM6aUO', 'chloe@roberts.com', NULL, 1);


INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva1.jpeg', '1', '1');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva2.png', '0', '1');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva3.jpg', '0', '1');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva1.jpeg', '1', '2');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva2.png', '1', '3');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva3.jpg', '1', '4');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva1.jpeg', '1', '5');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva2.png', '1', '6');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva3.jpg', '1', '7');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva1.jpeg', '1', '8');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva2.png', '1', '9');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva3.jpg', '1', '10');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva1.jpeg', '1', '11');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva2.png', '1', '12');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva3.jpg', '1', '13');
INSERT INTO `photography` (`Id`, `link`, `defaultPhoto`, `idUser`) VALUES (NULL, '/imatges_usuaris/fotoProva1.jpeg', '1', '14');


INSERT INTO `classgroup` (`id`, `className`) VALUES (NULL, 'DAW2');
INSERT INTO `classgroup` (`id`, `className`) VALUES (NULL, 'DAW1');
INSERT INTO `classgroup` (`id`, `className`) VALUES (NULL, 'SMX1');
INSERT INTO `classgroup` (`id`, `className`) VALUES (NULL, 'SMX2');

INSERT INTO `orla` (`id`, `name`, `visibility`, `idCreator`, `idClassGroup`) VALUES (NULL, 'orla1', '0', '1', '2');

INSERT INTO `user_orla` (`id`, `idUser`, `idOrla`) VALUES (NULL, '1', '1');
INSERT INTO `user_orla` (`id`, `idUser`, `idOrla`) VALUES (NULL, '2', '1');
INSERT INTO `user_orla` (`id`, `idUser`, `idOrla`) VALUES (NULL, '3', '1');
INSERT INTO `user_orla` (`id`, `idUser`, `idOrla`) VALUES (NULL, '4', '1');
INSERT INTO `user_orla` (`id`, `idUser`, `idOrla`) VALUES (NULL, '5', '1');

INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('1', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('2', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('3', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('4', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('5', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('6', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('7', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('8', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('9', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('10', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('11', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('12', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('13', '1');
INSERT INTO `users_classgroup` (`idUser`, `idGroupClass`) VALUES ('14', '1');