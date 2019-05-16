-- SQL Import File Example
-- Tested on MySQL 5.0.67
-- Ruben Crespo Álvarez - http://peachep.wordpress.com

create database if not exists prueba;
use prueba;

CREATE TABLE if not exists `nombre` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
  `nombre` VARCHAR(60) NOT NULL, 
  `apellidos` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`)
)
TYPE = myisam;


CREATE TABLE if not exists `facturas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
  `factura` VARCHAR(60) NOT NULL, 
  `fecha` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`)
)
TYPE = myisam;


CREATE TABLE if not exists `direcciones` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
  `calle` VARCHAR(60) NOT NULL, 
  `numero` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)
TYPE = myisam;