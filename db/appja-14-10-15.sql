DROP table IF EXISTS `ja_menu`;
CREATE TABLE `ja_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `clase` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `enlace` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#',
  `tipo_enlace` enum('interno','externo','_top') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'interno',
  `target` enum('_self','_blank','_top') COLLATE utf8_unicode_ci NOT NULL DEFAULT '_self',
  `padre` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ix_hierarchy_parent` (`padre`,`id`)
); 


DROP FUNCTION IF EXISTS f_getMenuHijos;
DELIMITER $$  
CREATE FUNCTION f_getMenuHijos (GivenID INT) RETURNS varchar(1024)
DETERMINISTIC
BEGIN

	DECLARE rv,q,queue,queue_children VARCHAR(1024);
	DECLARE queue_length,front_id,pos INT;
	SET rv = '';
	SET queue = GivenID;
	SET queue_length = 1;

	WHILE queue_length > 0 DO
		SET front_id = FORMAT(queue,0);
		IF queue_length = 1 THEN
			SET queue = '';
		ELSE
			SET pos = LOCATE(',',queue) + 1;
			SET q = SUBSTR(queue,pos);
			SET queue = q;
		END IF;
		SET queue_length = queue_length - 1;
		SELECT IFNULL(qc,'') INTO queue_children
		FROM (SELECT GROUP_CONCAT(id) qc
		FROM ja_menu WHERE padre = front_id) A;
		IF LENGTH(queue_children) = 0 THEN
			IF LENGTH(queue) = 0 THEN
				SET queue_length = 0;
			END IF;
		ELSE
			IF LENGTH(rv) = 0 THEN
				SET rv = queue_children;
			ELSE
				SET rv = CONCAT(rv,',',queue_children);
			END IF;
			IF LENGTH(queue) = 0 THEN
				SET queue = queue_children;
			ELSE
				SET queue = CONCAT(queue,',',queue_children);
			END IF;
			SET queue_length = LENGTH(queue) - LENGTH(REPLACE(queue,',','')) + 1;
		END IF;
	END WHILE;
	RETURN rv;
END;
$$
DELIMITER ;


DROP FUNCTION IF EXISTS f_getMenuJerarquia_by_padre;
DELIMITER $$ 
CREATE FUNCTION f_getMenuJerarquia_by_padre (value INT) RETURNS int(11)
	READS SQL DATA
BEGIN
	DECLARE _id INT;
	DECLARE _parent INT;
	DECLARE _next INT;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET @id = NULL;

	SET _parent = @id;
	SET _id = -1;

	IF @id IS NULL THEN
		RETURN NULL;
	END IF;
	 
	LOOP
		SELECT  MIN(id) INTO @id
		FROM    ja_menu
		WHERE   padre = _parent
		AND id > _id;

		IF @id IS NOT NULL OR _parent = @start_with THEN
			SET @level = @level + 1;
			RETURN @id;
		END IF;

		SET @level := @level - 1;
		SELECT  id, padre INTO    _id, _parent
		FROM    ja_menu
		WHERE   id = _parent;
	END LOOP;      
END;
$$
DELIMITER ;

DROP VIEW IF EXISTS v_getMenuDetallado;
CREATE VIEW v_getMenuDetallado AS
SELECT id, nombre, clase, enlace, tipo_enlace, target, padre, f_getMenuHijos(id) as hijos FROM ja_menu;


DROP PROCEDURE IF EXISTS sp_getMenuJerarquia;
DELIMITER $$ 
CREATE PROCEDURE sp_getMenuJerarquia()
BEGIN
	SELECT  CONCAT(REPEAT('', level - 1), CAST(mj.id AS CHAR)) as id, 
		md.nombre, md.enlace, md.clase, md.tipo_enlace, md.target, 
		mj.padre, md.hijos,  mj.level as nivel
	FROM    (
			SELECT  id, padre, IF(ancestry, @cl := @cl + 1, level + @cl) AS level
			FROM    (
					SELECT  TRUE AS ancestry, _id AS id, padre, level
					FROM    (
							SELECT  @r AS _id,
									(SELECT  @r := padre
									FROM    ja_menu
									WHERE   id = _id
									) AS padre,
									@l := @l + 1 AS level
							FROM    (SELECT  @r := 0, @l := 0, @cl := 0) vars,
									ja_menu h
							WHERE   @r <> 0
							ORDER BY level DESC
							) qi
					UNION ALL
					SELECT  FALSE, hi.id, padre, level
					FROM    (
							SELECT  f_getMenuJerarquia_by_padre(id) AS id, @level AS level
							FROM    (SELECT  @start_with := 0, @id := @start_with, @level := 0) vars, ja_menu
							WHERE   @id IS NOT NULL
							) ho
					JOIN    ja_menu hi ON hi.id = ho.id
					) q
			) mj
			
			inner join v_getmenudetallado md on mj.id = md.id
			order by id;
	   END;
$$
DELIMITER ;