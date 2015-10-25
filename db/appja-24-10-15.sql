ALTER TABLE `appja`.`ja_paginas`
CHANGE COLUMN `contenido` `contenido` LONGTEXT NOT NULL COMMENT '' AFTER `titulo`,
ADD COLUMN `imagen` VARCHAR(200) NULL COMMENT '' AFTER `contenido`;
