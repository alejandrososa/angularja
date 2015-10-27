ALTER TABLE `appja`.`ja_paginas`
ADD COLUMN `configuracion` TEXT NULL COMMENT '' AFTER `fecha_modificado`;

ALTER TABLE `appja`.`ja_paginas`
CHANGE COLUMN `tipo` `tipo` ENUM('pagina', 'articulo', 'portada', 'contacto') NOT NULL DEFAULT 'articulo' COMMENT '' ;

ALTER TABLE `appja`.`ja_paginas`
CHANGE COLUMN `contenido` `contenido` LONGTEXT NULL COMMENT '' ;



