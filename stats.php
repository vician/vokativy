<?php

if ($_SERVER['HOME'] == "/var/www") die ("Not public accessible!");

function stats($db) {
        $all = $db->querySingle("SELECT COUNT(*) FROM surnames");
        $done = $db->querySingle("SELECT COUNT(*) FROM surnames WHERE surnames.vokativ is not NULL");
        $todo = $all - $done;

        $done_pct = round(($done / $all) * 100);
        $todo_pct = round(($todo / $all) * 100);

        echo "Počet příjmení: $all<br/>";
        echo "Zpracovaných: $done ($done_pct %)<br/>";
				echo "Zbývá: $todo ($todo_pct %)<br/>";

				$first_miss = $db->querySingle("SELECT COUNT(*) FROM  surnames, (SELECT * FROM surnames WHERE surnames.vokativ is NULL ORDER BY surnames.cetnost DESC LIMIT 0,1) as FIRST WHERE surnames.cetnost > FIRST.cetnost;");
				$first_miss_pct = round(($first_miss / $all) * 100);
				echo "Hotovo nejčastějších: $first_miss ($first_miss_pct %)";

	echo "<hr/>";

	echo "<a onclick=\"\$('#by_alphabet_rule').toggle();\">Počet příjmení v pravidlech dle posledního písmene</a><br/>\n";
	echo "<div id=\"by_alphabet_rule\" style=\"display: none;\">";
	$by_alphabet_rule = $db->query("SELECT rule,substr(surname,-1) char,count(*) count FROM surnames GROUP BY substr(surname,-1),rule ORDER BY char ASC,rule ASC;");
	$last = "";
	while ($row = $by_alphabet_rule->fetchArray()) {
		if($row['rule'] == NULL) $rule = "?";
		else $rule = $row['rule'];
		
		if($last != $row['char']) echo "<b>".$row['char']."</b><br/>\n";
		echo "&nbsp;&nbsp;&nbsp;".(str_replace("-",".",$rule)).": ".$row['count']."<br/>\n";

		$last = $row['char'];
	}

	echo "</div>";

	echo "<hr/>";

	$by_rule = $db->query("SELECT rule,COUNT(*) count FROM surnames GROUP BY rule");

	echo "<a onclick=\"\$('#by_rule').toggle();\">Počet příjmení pro jednotlivá pravidla</a>\n";
	echo "<div id=\"by_rule\" style=\"display: none;\">";
	echo "<ol>\n";
	$last = 0;
	$not_yet = 0;
	while ($row = $by_rule->fetchArray()) {
		if($row['rule'] == NULL) {
			$not_yet = $row['count'];
			continue;
		}
		
		$current = intval($row['rule']);

		if($last != $current) {
			if($last != 0) echo "\t</ol>\n";
			echo "\t<li></li>\n";
			echo "\t<ol>\n";
		}
		echo "\t\t<li>".$row['count']."</li>\n";

		$last = $current;
	}
	echo "\t</ol>\n";
	echo "</ol>\n";
	echo "</div>";
}

try {
        $db = new SQLite3('data/db.sqlite3');
}
catch (Exception $exception) {
                echo "ERROR: ".$exception->getMessage();
}

stats($db);

?>
