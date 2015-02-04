<?php
	$company_number = filter_input(INPUT_GET, 'companynumber', FILTER_SANITIZE_STRING);
	$com_stru = null;
	
	function str_parse_tva($str){
		$company_number = trim($str);
	
		preg_match("/^(BE)?[\.,-\s]?(0)?[\.,-\s]?([0-9]{2,3})[\.,-\s]?([0-9]{3})[\.,-\s]?([0-9]{3})$/", $company_number, $company_number_parts);
		return intval($company_number_parts[3] . $company_number_parts[4] . $company_number_parts[5]);
	}
	
	if(!is_null($company_number)){
		$company_number_parsed = str_parse_tva($company_number);
	
		$check_digit = ($company_number_parsed % 97);
	
		$com_stru = "0".$company_number_parsed.str_pad($check_digit, 2, "0", STR_PAD_LEFT);
		$com_stru = "+++ ".preg_replace('/^([0-9]{3})([0-9]{4})([0-9]{5})$/', '$1/$2/$3', $com_stru)." +++";
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   
   <title>Générateur de communication structurée pour la déclaration TVA belge</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.8.1/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <style type="text/css">
body { font-family: "Trebuchet MS", verdana, helvetica, sans-serif; }
#doc { width: 400px; text-align: center; border: 2px solid #85B3D1; border-radius: 8px; -moz-border-radius: 8px; -webkit-border: 8px; padding: 20px; }
label { font-weight: bold; font-size: 1.2em; }
#company-number { width: 7em; padding: 3px 6px; margin-left: 1em; font-size: 1.2em; }
.button { margin: 1.4em auto 2em auto; display: block; 
-moz-border-radius:5px 5px 5px 5px;
background:url("/css/images/gradient-white2lightblue-1x30.png") repeat-x scroll 0 0 #FFFFFF;
border:1px solid #1B4C69;
color:#1B4C69;
font-size:1.1em;
font-weight:bold;
padding:5px 10px;
}
.result { border: 1px solid yellow; background: lightyellow; margin: 10px 20px; padding: 1em; font-size: 1.4em; border-radius: 8px; -moz-border-radius: 8px; -webkit-border-radius: 8px; }
   </style>
</head>
<body>
<div id="doc" class="yui-t7">
   <div id="bd" role="main">
	<div id="converter-input" class="yui-g">
		<form action="./" method="get">
			<label for="company-number">Numéro d'entreprise:</label>
			<input type="text" name="companynumber" id="company-number" value="<?php echo is_null($company_number)?'':$company_number;?>">
			<input type="submit" class="button" value="Générer">
		</form>
	</div>
	<?php if(!is_null($com_stru)){ ?>
	<div id="converter-result" class="yui-g">
		<p class="result"><?php echo $com_stru;?></p>
	</div>
	<?php } ?>
	</div>
</div>
</body>
</html>

