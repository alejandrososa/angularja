ALTER TABLE `appja`.`ja_usuarios`
ADD COLUMN `imagen` VARCHAR(100) NULL COMMENT '' AFTER `id`;

ALTER TABLE `appja`.`ja_usuarios`
ADD COLUMN `usuario` VARCHAR(45) NULL COMMENT '' AFTER `id`,
ADD UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC)  COMMENT '';