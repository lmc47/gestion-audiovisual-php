-- Active: 1768833508231@@127.0.0.1@3306@mysql
CREATE DATABASE IF NOT EXISTS audiovisualesfii;

USE audiovisualesfii;

CREATE TABLE user (
    idAdmin INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL, -- almacena el hash de la pwd
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE solicitudes (
    idSolicitud INT AUTO_INCREMENT PRIMARY KEY,
    nombre_solicitante VARCHAR(100),
    email VARCHAR(100),
    servicio VARCHAR(50),
    lugar VARCHAR(100),
    telefono VARCHAR(11),
    descripcion VARCHAR(100),
    entrega VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE fechas_reserva (
    idFechas INT AUTO_INCREMENT PRIMARY KEY,
    idSolicitud INT NOT NULL,
    fecha DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    FOREIGN KEY (idSolicitud) REFERENCES solicitudes (idSolicitud) ON DELETE CASCADE
);

CREATE TABLE estado (
    idEstado INT AUTO_INCREMENT PRIMARY KEY,
    idSolicitud INT NOT NULL,
    estado ENUM(
        'Pendiente',
        'Aceptado',
        'Rechazado',
        'En Proceso',
        'Completado'
    ) DEFAULT 'Pendiente',
    link_recurso TEXT NULL,
    comentario TEXT NULL,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idSolicitud) REFERENCES solicitudes (idSolicitud) ON DELETE CASCADE
);

-- Un trigger para generar el estado pendiente en la nueva solicitud
CREATE TRIGGER tras_insertar_solicitud
AFTER INSERT ON solicitudes
FOR EACH ROW
BEGIN
    INSERT INTO estado (idSolicitud, estado)
    -- Con el new agarra el id de la nueva solicitud
    VALUES (NEW.idSolicitud, 'Pendiente');
END

/* PARA ELIMINAR TODOS LOS DATOS DE LA DB --
-- BORRAR DESPUES --
USE audiovisualesfii;

SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE fechas_reserva;
TRUNCATE TABLE estado;
TRUNCATE TABLE solicitudes;

SET FOREIGN_KEY_CHECKS = 1;
*/