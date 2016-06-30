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
              <span class="input-group-btn"><button class="btn btn-lg btn-primary" type="submit">OK</button></span>
            </div>
          </form>
        </div>
        
      </div> <!-- /row -->
     <!--<div class="row">
       
        <div class="col-lg-12 text-center v-center" style="font-size:39pt;">-->
<?php
define("DEBUG", false);

mb_internal_encoding('UTF-8');

$rule = 0;

function vokativ($input,$db,&$rule) {
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
		$rule = $resulted['rule'];
		return $to_return;
        } else {
                return "<h1><i>Vokativ tohoto příjmení se připravuje.</i></h1>";
        }

        return "<h1><i>Neznámá chyba!</i></h1>";
}

try {
        $db = new SQLite3('current.sqlite3');
}
catch (Exception $exception) {
                echo "ERROR: ".$exception->getMessage();
}
if (isset($_POST['from'])) {

	echo '<div class="row"><div class="col-lg-12 text-center v-center-smaller" style="font-size:39pt;">';


	$to = vokativ($_POST['from'],$db,$rule);

	echo $to;

	echo '</div></div>';
}
?>
        <!--</div>
	</div>-->
  	<br><br><br><br><br>

</div> <!-- /container full -->

<div id="info" class="container">
  
  	<hr>
  
  	<div class="row">
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading"><h3>Statistiky</h3></div>
            <div class="panel-body"><?php echo file_get_contents("./stats.html"); ?>
            </div>
          </div>
        </div>
      	<div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading"><h3>Pravidla vokativů</h3></div>
            <div class="panel-body">
<?php

$rules = array();
$surnames[] = "<a onclick=\"\$('#rules').toggle();\">Použitá pravidla</a>";
$surnames[] = array(
"Vokativ stejný jako nominativ:",
	"příjmení jedno a dvou písmenná",
	"příjmení končící na písmena <b>Á</b>, <b>E</b>, <b>É</b>, <b>Ě</b>, <b>I</b>, <b>Í</b>, <b>Ý</b>, <b>Ó</b>, <b>Ú</b>, <b>Ů</b>, <b>O</b> nebo <b>Y</b>",
);
$surnames[] = array(
"Změna posledního písmene na písmeno <b>O</b>:",
	"příjmení končící na písmeno <b>A</b>"
);
$surnames[] = array(
"Přidání písmene <b>I</b>:",
	"příjmení končící na písmena <b>Ž</b>, <b>Š</b>, <b>Č</b>, <b>Ř</b>, <b>S</b> nebo <b>J</b>",
);
$surnames[] = array(
"Přidání písmene <b>I</b> a změkčení předposlendího písmene:",
	"příjmení končící na písmena <b>Ď</b>, <b>Ť</b> nebo <b>Ň</b>",
	"příjmení končící na písmena <b>C</b>, ale předposlední není <b>E</b>",
);
$surnames[] = array(
"Přidání písmene <b>E</b>:",
	"příjmení končící na písmena <b>B</b>, <b>D</b>, <b>F</b>, <b>M</b>, <b>P</b>, <b>Q</b>, <b>R</b> nebo <b>T</b>",
	"příjmení končící na písmeno <b>N</b>, ale předposlední není <b>E</b> nebo <b>Ě</b>",
	"příjmení končící na písmeno <b>L</b>, ale předposlední není <b>E</b> nebo <b>Ě</b>",
);
$surnames[] = array(
"Přidání písmene <b>U</b>:",
	"příjmení končící na písmeno <b>K</b>, ale předposlední není <b>E</b> nebo <b>Ě</b>",
	"příjmení končící na písmeno <b>G</b> nebo <b>CH</b>",
);
$surnames[] = array(
"Přidání písmene <b>U</b> a odebrání předposledního písmene:",
	"příjmení končící na písmena <b>EK</b>",
);
$surnames[] = array(
"Přidání písmene <b>U</b>, odebrání předposledního písmene a změkčení předpředposledního písmene:",
	"příjmení končící na písmena <b>DĚK</b>, <b>TĚK</b> nebo <b>NĚK</b>",
);
$surnames[] = array(
"Přidání písmene <b>E</b>, změkčení poslendího a odebrání předposledního:",
	"příjmení končící na písmena <b>EC</b>",
);
$surnames[] = array(
"Vyjímky",
);

$rint = intval($rule);

echo $surnames[0];
echo "<div id=\"rules\" style=\"display: none;\">";
echo "<ol>\n";
for($i = 1; $i < count($surnames); $i++) {
	echo "<li id=\"s".($i)."\"";
	if ($rint == $i) echo " style=\"background: #DDCCEE;\"";
	echo ">".$surnames[$i][0]."</li>\n<ol>\n";
	for($j = 1; $j < count($surnames[$i]); $j++) {
		echo "<li id=\"s".$i."-".chr(96+$j)."\"";
		if ($rule == $i."-".chr(96+$j)) echo " style=\"background: #DDCCEE;\"";
		echo ">".$surnames[$i][$j]."</li>\n";
	}
	echo "</ol>\n";
}
echo "</ol>\n";
echo "</div>";
?>
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
		Pokud jste nalezli chybu, nebo chcete tuto aplikaci použít v komerční sféře, nebojte se nás kontaktovat na: <a href="mailto:&#105;&#110;&#102;&#111;&#64;&#118;&#111;&#107;&#97;&#116;&#105;&#118;&#121;&#46;&#99;&#122;">&#105;&#110;&#102;&#111;&#64;&#118;&#111;&#107;&#97;&#116;&#105;&#118;&#121;&#46;&#99;&#122;</a><br/>
		<?php /*
		<hr/>
		- Projekt je ke stažení na <a href="https://github.com/vician/vokativy">githubu</a>
		*/ ?>
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
