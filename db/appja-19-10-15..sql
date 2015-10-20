CREATE TABLE `ja_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `clave` varchar(200) NOT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `fechacreado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=latin1;


USE `appja`;
DROP function IF EXISTS `f_setRutaImagenUsuario`;

DELIMITER $$
USE `appja`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `f_setRutaImagenUsuario`(imagen CHAR(250)) RETURNS char(250) CHARSET latin1
BEGIN

	DECLARE imagenUsuario CHAR(250);
	SET imagenUsuario = IF(imagen IS NULL OR IMAGEN = '', imagen, CONCAT('assets/archivos/usuarios/',imagen));
    RETURN imagenUsuario;

END$$
DELIMITER ;


USE `appja`;
CREATE  OR REPLACE VIEW `v_getusuarios` AS
select
	id,
    usuario,
    f_setRutaImagenUsuario(imagen) as imagen,
    nombre,
    apellidos,
    correo,
    telefono,
    clave,
    direccion,
    ciudad,
    pais,
    fechacreado
 from ja_usuarios;

