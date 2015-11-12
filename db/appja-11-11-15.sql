DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `f_cortartexto`(texto text, textoalterno longtext, longitud int(10)) RETURNS text CHARSET latin1
BEGIN
	declare p1_texto text;
    declare p2_texto longtext;
    declare _logintud_texto1 int(10);
    declare _logintud_texto2 int(10);
    declare _resultado text;

    SET _logintud_texto1 = LENGTH(texto);
    SET _logintud_texto2 = LENGTH(textoalterno);

    IF _logintud_texto1 > 0 THEN BEGIN
		set _resultado = IF(longitud > 0, SUBSTRING(texto,1,longitud), texto);
	END; END IF;

    IF _logintud_texto2 > 0 AND _logintud_texto1 = 0 THEN BEGIN
		set _resultado = IF(longitud > 0, SUBSTRING(textoalterno,1,longitud), textoalterno);
	END; END IF;

RETURN f_eliminar_dobleespacios(f_eliminar_tags_html(_resultado));
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `f_eliminar_dobleespacios`(str text) RETURNS text CHARSET latin1
BEGIN
    while instr(str, '  ') > 0 do
        set str := replace(str, '  ', ' ');
    end while;
    return trim(str);
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `f_eliminar_tags_html`(x longtext) RETURNS longtext CHARSET latin1
BEGIN
	DECLARE sstart INT UNSIGNED;
	DECLARE ends INT UNSIGNED;
	SET sstart = LOCATE('<', x, 1);
	REPEAT
	SET ends = LOCATE('>', x, sstart);
	SET x = CONCAT(SUBSTRING( x, 1 ,sstart -1) ,SUBSTRING(x, ends +1 )) ;
	SET sstart = LOCATE('<', x, 1);
	UNTIL sstart < 1 END REPEAT;
return x;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `F_GETMENUHIJOS`(GivenID INT) RETURNS varchar(1024) CHARSET latin1
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
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `f_getMenuJerarquia_by_padre`(value INT) RETURNS int(11)
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
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `F_SETRUTAIMAGENUSUARIO`(imagen CHAR(250)) RETURNS char(250) CHARSET latin1
BEGIN

	DECLARE imagenUsuario CHAR(250);
	SET imagenUsuario = IF(imagen IS NULL OR IMAGEN = '', imagen, CONCAT('assets/archivos/usuarios/',imagen));
    RETURN imagenUsuario;

END$$
DELIMITER ;
