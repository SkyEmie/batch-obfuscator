<style type="text/css">

* {
	outline: none!important;
	text-decoration: none!important;
}


html {
	box-shadow: inset 0 0 80px -15px #000;
	background-color: #d0d0d0;
	font-family: sans-serif;
}

body {
	margin: 10%;
}

.input {
	position: relative;
	display: block;
	width: 75%;
	height: 65px;
	padding: 20px 0;
	background-color: #fff;
	box-shadow: 0 0 80px -25px black;
	color: #555;
	font-size: 24px;
	text-align: center;
	border: 2px solid #000;
	border-radius: 10px;
	border-bottom-left-radius: 0;
	border-bottom-right-radius: 0;
	transition: .2s;
}

.version {
	position: fixed;
	top: 5px;
	right: 10px;
	color: #000;
	font-family: monospace;
	font-style: italic;
	font-weight: bold;
	text-shadow: 0 0 20px white;
}

.input:hover {
	width: 80%;
	border: 2px solid #f00;
	border-radius: 10px !important;
}

input#file {
	padding: 98px 0 0 0;
	background: url('./batch_ico.png') center center no-repeat #fff;
	background-size: 95px 95px;
	overflow: hidden;
}

.btn {
	position: relative;
	display: block;
	width: 75%;
	padding: 10px;
	min-height: 50px;
	background-color: #dd2a2a;
	box-shadow: inset 0 0 80px -25px black;
	color: #fff;
	font-size: 28px;
	text-align: center;
	border: 0;
	border-bottom-left-radius: 10px;
	border-bottom-right-radius: 10px;
	transition: .2s;
	cursor: pointer;
	-webkit-appearance: none;
}

.btn:hover {
	width: 80%;
	border-top-left-radius: 10px;
	border-top-right-radius: 10px;
	background-color: #bb2424;
}

</style>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="icon" href="favicon.ico">
<title>Batch file obfuscator</title>


<body>

	<span class="version">v1.7 stable</span>

	<br>
	<br>

	<center>
		<form enctype="multipart/form-data" action="" method="POST">
			<input type="file" name="batchfile" class="input" id="file" style="border-bottom:1px solid #000;"/>
			<input type="number" min="1" max="20" name="passage" class="input" placeholder="Number of passages (Default: 1, Max: 20)" style="border-radius: 0px;border-top:1px solid #000;" />
			<input type="submit" class="btn" value="Obfuscate!" onclick="this.value='Processing'"/>
		</form>
	</center>

</body>




<?php

ini_set('memory_limit', '-1');

if (isset($_FILES['batchfile'])) {
	if ($_FILES['batchfile']['error'] == False && $_FILES['batchfile']['size'] <= 1000000) && strtolower(substr($_FILES['batchfile']['name'], -4)) == '.bat'){

		if ($_POST['passage'] > 0 && $_POST['passage'] <= 20) {
			$passage = htmlspecialchars($_POST['passage']);
		} else {
			$passage = 1;
		}

		sleep(1);

		if (!is_dir('data')) mkdir('data', 0755);

		foreach(glob('data/'."*") as $file) {
			if (filemtime($file) < time() - 86400) {
				unlink($file);
			}
		}

		file_put_contents('data/'.$_FILES['batchfile']['name'], batchfile_obfuscate($_FILES['batchfile']['tmp_name'], $passage));

		echo '<br><br><center><a class="btn" style="padding-top: 15px;border-radius: 10px;"href="./data/'.$_FILES['batchfile']['name'].'">Récupérer <strong>'.$_FILES['batchfile']['name'].'</strong> brouillé x'.$passage.'</a></center>';

	} else {
		echo "<center><strong>An error has occured</strong><br>(No attached file, or the file is more than 1MB, or is not a Batch file)</center>";
	}
}


function batchfile_obfuscate($batchfile, $pass = 1) {

	for ($i=0; $i < $pass; $i++) {

		if ($i == 0) {
			$script = file_get_contents($batchfile);
		} else {
			$script = $batchfile_obfuscate;
		}

		$batchfile_obfuscate = '';

		$stringVar0 = '@ 0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$stringVar1 = '_ÄÅÇÉÑÖÜáàâäãåçéèêëíìîïñóòôöõúùûüabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$stringVar8 = 'abcdefghijklmnopqrstuvwxyz';
		$stringVar2 = '_¯-ஐ→あⓛⓞⓥⓔ｡°º¤εïз╬㊗⑪⑫⑬㊀㊁㊂のðabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$stringGen1 = substr(str_shuffle($stringVar1),0 , rand(3, 5));
		$stringGen2 = '';


		$arrayTable = array();
		$arrayVar0 = str_split($stringVar0);
		shuffle($arrayVar0);

		foreach ($arrayVar0 as $pos => $char) {
			$arrayTable[] = [$char,'%'.$stringGen1.':~'.$pos.',1%'];
			$stringGen2.= $char;
		}

		$arrayText = str_split($script);
		$convertWaitVar = False;
		$convertWaitLabel = False;
		$sautLigne = True;
		if ($i == $pass-1) $batchfile_obfuscate.= "\xFF\xFE".'&@cls&';
		$batchfile_obfuscate.= '@set "'.$stringGen1.'='.$stringGen2.'"'.PHP_EOL;


		foreach ($arrayText as &$charOriginal) {

			if ($sautLigne = True && $charOriginal == ':') {
				$convertWaitLabel = True;
			}


			if ($charOriginal == "\n") {
				$sautLigne = True;
				$convertWaitVar = False;
				$convertWaitLabel = False;
			} else {
				$sautLigne = False;
			}

			if ($charOriginal == ' ') {
				$convertWaitLabel = False;
			}


			if ($convertWaitVar == False && ($charOriginal == '%' || $charOriginal == '!')) {
				$convertWaitVar = True;
			} elseif ($convertWaitVar == True && ($charOriginal == '%' || $charOriginal == '!')) {
				$convertWaitVar = False;
				$convertWaitLabel = False;
			}


			if ($convertWaitVar == False && $convertWaitLabel == False && $sautLigne == False) {

				$convert = False;
				foreach ($arrayTable as list($char1, $char2)) {
					if ($charOriginal == $char1) {

						if (rand(1, 20) == 8){
							$batchfile_obfuscate.= $char2.'%'.substr(str_shuffle($stringVar1), 3, 7).'%';
						} else {
							$batchfile_obfuscate.= $char2;
						}

						$convert = True;
					}
				}

				if ($convert == False) {
					$batchfile_obfuscate.= $charOriginal;
				}

			} else {
				$batchfile_obfuscate.= $charOriginal;
			}
		}


	}


	return(html_entity_decode($batchfile_obfuscate));
}

?>
