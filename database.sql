-- Estructura de la base de datos de la aplicación (sin datos sensibles)
CREATE DATABASE IF NOT EXISTS miproyecto CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE miproyecto;

CREATE TABLE IF NOT EXISTS equipos (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(100) NOT NULL,
    tipo         VARCHAR(30)  NOT NULL,
    marca        VARCHAR(60)  NOT NULL,
    numero_serie VARCHAR(60)  NOT NULL,
    ubicacion    VARCHAR(100) NOT NULL,
    estado       VARCHAR(30)  NOT NULL DEFAULT 'Operativo',
    fecha_alta   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
