<html>
<head>
	<title>Vokativy</title>
</head>
<body>
<?php
define("DEBUG", false);

mb_internal_encoding('UTF-8');

function vokativ($input,$db) {
	$from = trim(mb_strtoupper($input, 'UTF-8'));
	
	if(DEBUG) echo $input." -> '".$from."' => ";

	try {
		//var_dump($db->querySingle("SELECT vokativ FROM surnames WHERE surname = '".$from."'"));
		$resulted = $db->querySingle("SELECT * FROM surnames WHERE surname = '".$from."'",true);
	}
	catch (Exception $exception) {
		echo "ERROR: ".$exception->getMessage();
	}

	if ($resulted == false) {
		if(DEBUG) echo "Nezname prijmeni!";
		return "Nezname prijmeni!";
	}
	if ($resulted['vokativ'] != "") {

		if(DEBUG) echo $resulted['vokativ'] ." => ".$result." (".$resulted['rule'].")<br/>";

		$result = mb_substr ($resulted['vokativ'],0,1).mb_strtolower(mb_substr($resulted['vokativ'],1));

		return $result." (".$resulted['rule'].")";
	} else {
		if(DEBUG) echo "Pripravuje se.<br/>";
		return "Pripravuje se.";
	}

	return "Unknown error!";
}

function counts($db) {
	$all = $db->querySingle("SELECT COUNT(*) FROM surnames");
	$done = $db->querySingle("SELECT COUNT(*) FROM surnames WHERE surnames.vokativ is not NULL");
	$todo = $all - $done;

	$done_pct = round(($done / $all) * 100);
	$todo_pct = round(($todo / $all) * 100);

	echo "celkově příjmeních: $all<br>";
	echo "hotovo: $done ($done_pct %)<br>";
	echo "zbývá: $todo ($todo_pct %)<br>";
	echo "<hr/>";
}

try {
	$db = new SQLite3('all.sqlite3');
}
catch (Exception $exception) {
		echo "ERROR: ".$exception->getMessage();
}
//$db = new PDO('sqlite:all.sqlite3');
if (isset($_GET['from'])) {

	$to = "";

	//print_r($_GET['from']);

	$froms = explode("\n",$_GET['from']);
	//print_r($froms);

	foreach($froms as $from) {
		if(DEBUG) echo $from." -> ";
		$to .= vokativ($from,$db)."\n";
	}

	//vokativ($_GET['from'],$db);
}

if (isset($_GET['counts'])) {
	counts($db);
}

?>

<form method="get" action="">
	Příjmení:<br/>
	<textarea name="from" rows="10"><?php if(isset($_GET['from'])) echo $_GET['from']; ?></textarea>
	<textarea rows="10"><?php if(isset($to)) echo $to; ?></textarea>
	<br/>
	<input type="submit">
</form>
<a href="?counts">Statistiky</a>
</body>
</html>
