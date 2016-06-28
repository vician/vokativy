<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Vokativy.cz</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="css/styles.css" rel="stylesheet">
	</head>
	<body>
<div class="container-full">

      <div class="row">
       
        <div class="col-lg-12 text-center v-center">
          
          <h1><a id="home" href="#">Vokativy.cz</a></h1>
          <p class="lead">Jednoduchý způsob správného oslovení</p>
          
          <br><br><br>
          
          <form class="col-lg-12" method="post" action="">
            <div class="input-group" style="width:360px;text-align:center;margin:0 auto;">
            <input class="form-control input-lg" title="" placeholder="Zde napište dotazované příjmení" type="text" name="from" value="<?php if(isset($_POST['from'])) echo $_POST['from']; ?>">
              <span class="input-group-btn"><button class="btn btn-lg btn-primary" type="button">OK</button></span>
            </div>
          </form>
        </div>
        
      </div> <!-- /row -->
     <div class="row">
       
        <div class="col-lg-12 text-center v-center" style="font-size:39pt;">
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
                return "<h1><i>Chyba: Neznámé příjmení!</i></h1>";
        }
        if ($resulted['vokativ'] != "") {

                $result = mb_substr ($resulted['vokativ'],0,1).mb_strtolower(mb_substr($resulted['vokativ'],1));

		$to_return = '<p class="lead">Doporučujeme oslovení:</p><h1>';

		if( mb_substr($result,-1) == "á") {
			$to_return .= "Vážená paní ";
		} else {
			$to_return .= "Vážený pane ";
		}

		$to_return .= $result;

		$to_return .= "</h1>";
		if(isset($_GET['rules'])) {
	                $to_return .= "Pravidlo č. ".$resulted['rule']."";
		}
		return $to_return;
        } else {
                return "<h1><i>Vokativ tohoto příjmení se připravuje.</i></h1>";
        }

        return "<h1><i>Neznámá chyba!</i></h1>";
}

function stats($db) {
        $all = $db->querySingle("SELECT COUNT(*) FROM surnames");
        $done = $db->querySingle("SELECT COUNT(*) FROM surnames WHERE surnames.vokativ is not NULL");
        $todo = $all - $done;

        $done_pct = round(($done / $all) * 100);
        $todo_pct = round(($todo / $all) * 100);

        echo "Počet příjmení: $all<br>";
        echo "Zpracovaných: $done ($done_pct %)<br>";
        echo "Zbývá: $todo ($todo_pct %)<br>";
}

try {
        $db = new SQLite3('all.sqlite3');
}
catch (Exception $exception) {
                echo "ERROR: ".$exception->getMessage();
}
if (isset($_POST['from'])) {

	$to = vokativ($_POST['from'],$db);

	echo $to;
}
?>
        </div>
	</div>
  	<br><br><br><br><br>

</div> <!-- /container full -->

<div id="info" class="container">
  
  	<hr>
  
  	<div class="row">
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading"><h3>Statistiky</h3></div>
            <div class="panel-body"><?php stats($db); ?>
            </div>
          </div>
        </div>
      	<div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading"><h3>Pravidla vokativů</h3></div>
            <div class="panel-body">
		<i>Zveřejnění připravujeme.</i>
            </div>
          </div>
        </div>
      	<div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading"><h3>Autoři</h3></div>
            <div class="panel-body">
		- Lucie Medová<br/>
		- Klára Viciánová<br/>
		- <a href="https://www.vician.cz/">Martin Vicián</a> (web, technologie)
            </div>
          </div>
        </div>
      	<div class="col-md-3">
        	<div class="panel panel-default">
            <div class="panel-heading"><h3>Kontakt</h3></div>
            <div class="panel-body">
		- Obecné věci:<br/>&nbsp;&nbsp;&nbsp;<a href="mailto:&#105;&#110;&#102;&#111;&#64;&#118;&#111;&#107;&#97;&#116;&#105;&#118;&#121;&#46;&#99;&#122;">&#105;&#110;&#102;&#111;&#64;&#118;&#111;&#107;&#97;&#116;&#105;&#118;&#121;&#46;&#99;&#122;</a><br/>
		- Pravidla vokativů:<br/>&nbsp;&nbsp;&nbsp;<a href="mailto:&#112;&#114;&#97;&#118;&#105;&#100;&#108;&#97;&#64;&#118;&#111;&#107;&#97;&#116;&#105;&#118;&#121;&#46;&#99;&#122;">&#112;&#114;&#97;&#118;&#105;&#100;&#108;&#97;&#64;&#118;&#111;&#107;&#97;&#116;&#105;&#118;&#121;&#46;&#99;&#122;</a><br/>
		- Technologické záležitosti:<br/>&nbsp;&nbsp;&nbsp;<a href="mailto:&#105;&#116;&#64;&#118;&#111;&#107;&#97;&#116;&#105;&#118;&#121;&#46;&#99;&#122;">&#105;&#116;&#64;&#118;&#111;&#107;&#97;&#116;&#105;&#118;&#121;&#46;&#99;&#122;</a>
		<hr/>
		- Projekt je ke stažení na <a href="https://github.com/vician/vokativy">githubu</a>
            </div>
          </div>
        </div>
    </div>
  
	<div class="row">
        <div class="col-lg-12">
        <br><br>
          <p class="pull-right"><a href="http://www.bootply.com">Template from Bootply</a> Copyright 2016 Martin Vicián</p>
        <br><br>
        </div>
    </div>
</div>


	<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
