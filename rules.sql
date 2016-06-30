-- 1: Beze zmeny
	-- 1.a:
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-a' WHERE length(surnames.surname) <= 2 AND surnames.vokativ is NULL;
	-- 1.b: Á, E, É, Ě, I, Y, Í, Ý, O, Ó, Ú, Ů, O
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-b' WHERE surnames.surname LIKE "%Á" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-b' WHERE surnames.surname LIKE "%E" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-b' WHERE surnames.surname LIKE "%É" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-b' WHERE surnames.surname LIKE "%Ě" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-b' WHERE surnames.surname LIKE "%I" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-b' WHERE surnames.surname LIKE "%Y" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-b' WHERE surnames.surname LIKE "%Í" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-b' WHERE surnames.surname LIKE "%Ý" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-b' WHERE surnames.surname LIKE "%O" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-b' WHERE surnames.surname LIKE "%Ó" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-b' WHERE surnames.surname LIKE "%Ú" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname, rule = '1-b' WHERE surnames.surname LIKE "%Ů" AND surnames.vokativ is NULL;


-- 2: -? -> -O
	-- 2.a: A
	UPDATE surnames SET vokativ = substr(surnames.surname,0,length(surnames.surname)) || 'O', rule = '2-a' WHERE surnames.surname LIKE "%A" AND surnames.vokativ is NULL;

-- 3: +I
	-- 3.a: Ž, Š, Č, Ř, S, J, Z
	UPDATE surnames SET vokativ = surnames.surname || 'I', rule = '3-a' WHERE surnames.surname LIKE "%Ž" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'I', rule = '3-a' WHERE surnames.surname LIKE "%Š" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'I', rule = '3-a' WHERE surnames.surname LIKE "%Č" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'I', rule = '3-a' WHERE surnames.surname LIKE "%Ř" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'I', rule = '3-a' WHERE surnames.surname LIKE "%S" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'I', rule = '3-a' WHERE surnames.surname LIKE "%J" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'I', rule = '3-a' WHERE surnames.surname LIKE "%Z" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'I', rule = '3-b' WHERE surnames.surname LIKE "%C" AND surnames.surname NOT LIKE "%EC" AND surnames.vokativ is NULL;

-- 4: +I a zmekceni
	-- 4.a: Ď, Ť, Ň
	UPDATE surnames SET vokativ = substr(surnames.surname,0,length(surnames.surname)) || 'DI', rule = '4-a' WHERE surnames.surname LIKE "%Ď" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = substr(surnames.surname,0,length(surnames.surname)) || 'TI', rule = '4-a' WHERE surnames.surname LIKE "%Ť" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = substr(surnames.surname,0,length(surnames.surname)) || 'NI', rule = '4-a' WHERE surnames.surname LIKE "%Ň" AND surnames.vokativ is NULL;

-- 5: +E
	-- 5.a: B, D, F, M, P, Q, R, T
	UPDATE surnames SET vokativ = surnames.surname || 'E', rule = '5-a' WHERE surnames.surname LIKE "%B" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'E', rule = '5-a' WHERE surnames.surname LIKE "%D" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'E', rule = '5-a' WHERE surnames.surname LIKE "%F" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'E', rule = '5-a' WHERE surnames.surname LIKE "%M" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'E', rule = '5-a' WHERE surnames.surname LIKE "%P" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'E', rule = '5-a' WHERE surnames.surname LIKE "%Q" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'E', rule = '5-a' WHERE surnames.surname LIKE "%R" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'E', rule = '5-a' WHERE surnames.surname LIKE "%T" AND surnames.vokativ is NULL;
	-- 5.b: N
	UPDATE surnames SET vokativ = surnames.surname || 'E', rule = '5-b' WHERE surnames.surname LIKE "%N" AND surnames.surname NOT LIKE "%EN" AND surnames.surname NOT LIKE "%ĚN" AND surnames.vokativ is NULL;
	-- 5.c: L
	UPDATE surnames SET vokativ = surnames.surname || 'E', rule = '5-c' WHERE surnames.surname LIKE "%L" AND surnames.surname NOT LIKE "%EL" AND surnames.surname NOT LIKE "%ĚL" AND surnames.vokativ is NULL;
	-- 5.d: H
	UPDATE surnames SET vokativ = surnames.surname || 'E', rule = '5-d' WHERE surnames.surname LIKE "%H" AND surnames.surname NOT LIKE "%CH" AND surnames.vokativ is NULL;

	-- 6: +U
	-- 6.a: K,CH
	UPDATE surnames SET vokativ = surnames.surname || 'U', rule = '6-a' WHERE surnames.surname LIKE "%K" AND surnames.surname NOT LIKE "%EK" AND surnames.surname NOT LIKE "%ĚK" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'U', rule = '6-b' WHERE surnames.surname LIKE "%CH" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = surnames.surname || 'U', rule = '6-b' WHERE surnames.surname LIKE "%G" AND surnames.vokativ is NULL;

-- 7: +U, -predp
	-- 7.a EK
	UPDATE surnames SET vokativ = substr(surnames.surname,0,length(surnames.surname)-1) || 'KU', rule = '7-a' WHERE surnames.surname LIKE "%EK" AND surnames.vokativ is NULL;

-- 8: +U, -predp, zmekc predperdp
	-- 8.a: DĚK, TĚK,NĚK
	UPDATE surnames SET vokativ = substr(surnames.surname,0,length(surnames.surname)-2) || 'ĎKU', rule = '8-a' WHERE surnames.surname LIKE "%DĚK" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = substr(surnames.surname,0,length(surnames.surname)-2) || 'ŤKU', rule = '8-a' WHERE surnames.surname LIKE "%TĚK" AND surnames.vokativ is NULL;
	UPDATE surnames SET vokativ = substr(surnames.surname,0,length(surnames.surname)-2) || 'ŇKU', rule = '8-a' WHERE surnames.surname LIKE "%NĚK" AND surnames.vokativ is NULL;

-- 9: EC -> ČE
	UPDATE surnames SET vokativ = substr(surnames.surname,0,length(surnames.surname)-1) || 'ČE', rule = '9-a' WHERE surnames.surname LIKE "%EC" AND surnames.vokativ is NULL;
