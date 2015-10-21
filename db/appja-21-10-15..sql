 CREATE  TABLE IF NOT EXISTS `ja_acl_perfiles` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'llave primaria de la tabla' ,
  `nombre` VARCHAR(45) NULL COMMENT 'Descripción del perfil' ,
  `fecha_registro` DATETIME NULL COMMENT 'fecha de registro' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- Table `usuarios_perfiles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ja_acl_usuarios_perfiles` (
  `usuario_id` INT NOT NULL ,
  `perfil_id` INT NOT NULL ,
  INDEX `fk_usuarios_perfiles_usuarios_idx` (`usuario_id` ASC) ,
  INDEX `fk_usuarios_perfiles_perfiles1_idx` (`perfil_id` ASC) ,
  CONSTRAINT `fk_usuarios_perfiles_usuarios`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `ja_usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_perfiles_perfiles1`
    FOREIGN KEY (`perfil_id` )
    REFERENCES `ja_acl_perfiles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `recursos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ja_acl_recursos` (
  `id` INT NOT NULL ,
  `nombre` VARCHAR(100) NULL COMMENT 'nombre del recurso' ,
  `fecha_registro` DATETIME NULL COMMENT 'Fecha en la que se registro el recurso' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `perfiles_recursos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `perfiles_recursos` (
  `consultar` TINYINT(1) NULL DEFAULT 0 ,
  `agregar` TINYINT(1) NULL DEFAULT 0 ,
  `editar` TINYINT(1) NULL DEFAULT 0 ,
  `eliminar` TINYINT(1) NULL DEFAULT 0 ,
  `recurso_id` INT NOT NULL ,
  `perfil_id` INT NOT NULL ,
  INDEX `fk_perfiles_recursos_recursos1_idx` (`recurso_id` ASC) ,
  INDEX `fk_perfiles_recursos_perfiles1_idx` (`perfil_id` ASC) ,
  CONSTRAINT `fk_perfiles_recursos_recursos1`
    FOREIGN KEY (`recurso_id` )
    REFERENCES `recursos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfiles_recursos_perfiles1`
    FOREIGN KEY (`perfil_id` )
    REFERENCES `perfiles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `perfiles_recursos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ja_acl_perfiles_recursos` (
  `consultar` TINYINT(1) NULL DEFAULT 0 ,
  `agregar` TINYINT(1) NULL DEFAULT 0 ,
  `editar` TINYINT(1) NULL DEFAULT 0 ,
  `eliminar` TINYINT(1) NULL DEFAULT 0 ,
  `recurso_id` INT NOT NULL ,
  `perfil_id` INT NOT NULL ,
  INDEX `fk_perfiles_recursos_recursos1_idx` (`recurso_id` ASC) ,
  INDEX `fk_perfiles_recursos_perfiles1_idx` (`perfil_id` ASC) ,
  CONSTRAINT `fk_perfiles_recursos_recursos1`
    FOREIGN KEY (`recurso_id` )
    REFERENCES `ja_acl_recursos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfiles_recursos_perfiles1`
    FOREIGN KEY (`perfil_id` )
    REFERENCES `ja_acl_perfiles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


INSERT INTO `appja`.`ja_acl_perfiles` (`nombre`, `fecha_registro`)
VALUES ('Administrador', now()),
		('Editor', now()),
		('Escritor', now()),
    ('Marketing', now());

INSERT INTO ja_acl_recursos (id, nombre, fecha_registro)
 VALUES (1,'Gestion Articulos', now()),
		(2,'Publicar Articulos', now()),
		(3,'Gestion Usuarios', now()),
    (4,'Gestion Configuracion', now());


INSERT INTO `appja`.`ja_acl_perfiles_recursos` (`consultar`, `agregar`, `editar`, `eliminar`, `recurso_id`, `perfil_id`) VALUES ('1', '1', '1', '1', '1', '1');
INSERT INTO `appja`.`ja_acl_perfiles_recursos` (`consultar`, `agregar`, `editar`, `eliminar`, `recurso_id`, `perfil_id`) VALUES ('1', '1', '1', '1', '2', '1');
INSERT INTO `appja`.`ja_acl_perfiles_recursos` (`consultar`, `agregar`, `editar`, `eliminar`, `recurso_id`, `perfil_id`) VALUES ('1', '1', '1', '1', '3', '1');
INSERT INTO `appja`.`ja_acl_perfiles_recursos` (`consultar`, `agregar`, `editar`, `eliminar`, `recurso_id`, `perfil_id`) VALUES ('1', '1', '1', '1', '4', '1');
INSERT INTO `appja`.`ja_acl_perfiles_recursos` (`consultar`, `agregar`, `editar`, `eliminar`, `recurso_id`, `perfil_id`) VALUES ('1', '1', '1', '1', '1', '3');
INSERT INTO `appja`.`ja_acl_perfiles_recursos` (`consultar`, `agregar`, `editar`, `eliminar`, `recurso_id`, `perfil_id`) VALUES ('1', '1', '1', '1', '1', '4');
INSERT INTO `appja`.`ja_acl_perfiles_recursos` (`consultar`, `agregar`, `editar`, `eliminar`, `recurso_id`, `perfil_id`) VALUES ('1', '1', '1', '1', '2', '4');
INSERT INTO `appja`.`ja_acl_perfiles_recursos` (`consultar`, `agregar`, `editar`, `eliminar`, `recurso_id`, `perfil_id`) VALUES ('1', '1', '1', '1', '3', '2');


UPDATE `appja`.`ja_usuarios` SET `id`='1', `nombre`='Alex', `apellidos`='Sosa', `pais`='repdominicana' WHERE `id`='188';
UPDATE `appja`.`ja_usuarios` SET usuario = 'admin', `clave`='$2y$11$wJBCb6M1X03StqdWDXoYUeaXvVHzziSez6L3jbO3mDrCWPZYYriEW' WHERE `id`='1';

INSERT INTO `appja`.`ja_acl_usuarios_perfiles` (`usuario_id`, `perfil_id`) VALUES ('1', '1');



USE `appja`;
DROP procedure IF EXISTS `sp_getPermisosUsuario`;

DELIMITER $$
USE `appja`$$
CREATE PROCEDURE `sp_getPermisosUsuario`
(
	idusuario int(4),
    idrecurso int(4)
)
BEGIN

	IF idusuario IS NOT NULL AND idusuario > 0 AND idrecurso IS NOT NULL AND idrecurso > 0 THEN

		SELECT IF(SUM(consultar) >= 1, 1,0) as consultar,
			   IF(SUM(agregar) >= 1, 1,0) as agregar,
			   IF(SUM(editar) >= 1, 1,0) as editar,
			   IF(SUM(eliminar) >= 1, 1,0) as eliminar
		FROM ja_acl_perfiles_recursos
		WHERE recurso_id = idrecurso
		AND perfil_id IN (
			/* SELECCIONO LOS PERFILES DEL USUARIO*/
			SELECT perfil_id
			FROM ja_acl_usuarios_perfiles
			WHERE usuario_id = idusuario
		)
		GROUP BY recurso_id;

    END IF;

END;$$

DELIMITER ;


INSERT INTO `appja`.`ja_acl_usuarios_perfiles` (`usuario_id`, `perfil_id`) VALUES ('214', '4');
INSERT INTO `appja`.`ja_acl_usuarios_perfiles` (`usuario_id`, `perfil_id`) VALUES ('214', '3');

USE `appja`;
CREATE
     OR REPLACE ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `v_getperfilusuario` AS
    SELECT
		`u`.`id` as `id`,
        `p`.`nombre` AS `nombre`
    FROM
        ((`ja_usuarios` `u`
        JOIN `ja_acl_usuarios_perfiles` `up` ON ((`u`.`id` = `up`.`usuario_id`)))
        JOIN `ja_acl_perfiles` `p` ON ((`p`.`id` = `up`.`perfil_id`)));
