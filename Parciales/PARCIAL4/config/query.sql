create schema Parcial4;

use Parcial4;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- Identificador único del usuario
    email VARCHAR(255) NOT NULL UNIQUE,        -- Correo electrónico único
    nombre VARCHAR(255) NOT NULL,              -- Nombre del usuario
    google_id VARCHAR(255) UNIQUE,             -- ID de Google para OAuth 2.0
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Fecha y hora de registro

);


CREATE TABLE libros_guardados (
    id INT AUTO_INCREMENT PRIMARY KEY,               -- Identificador único del libro guardado
    user_id INT NOT NULL,                             -- Referencia al usuario que guardó el libro (clave foránea)
    google_books_id VARCHAR(255) NOT NULL UNIQUE,     -- ID único de Google Books
    titulo VARCHAR(255) NOT NULL,                     -- Título del libro
    autor VARCHAR(255),                               -- Autor del libro
    imagen_portada VARCHAR(255),                      -- URL o ruta de la imagen de portada
    reseña_personal TEXT,                             -- Reseña personal del usuario
    fecha_guardado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Fecha y hora de cuando se guardó el libro
    FOREIGN KEY (user_id) REFERENCES usuarios(id)    -- Relación con la tabla de usuarios
);
