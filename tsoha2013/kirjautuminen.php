<!DOCTYPE html>
<html>
    <head>
        <title>Kirjautuminen</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
		<H1> Kirjautuminen: </H1>
		
		<form action="kirjautuminen.php" method="post">
			<p>Henkilonumero: <br>
				<input type="text" name="henkilonumero">
				<span class="red" id="tunnus_viesti"></span>
			</p>
			<p>Sanasana: <br>
				<input type="password" name="salasana">
				<span class="red" id="salasana_viesti"></span>
			</p>
            <input type="submit" value="Kirjaudu">
		</form>
		<script src="code.js"></script>
    </body>
</html>

<?php

-------------------
// yhteyden muodostus tietokantaan POISTETTU


-----------

$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// merkisto: kaytetaan latin1-merkistoa; toinen yleinen vaihtoehto on utf8.
$yhteys->exec("SET NAMES 'utf8'");

// kyselyn suoritus
$kysely = $yhteys->prepare("select henkilonumero, salasana, listalla from tekija");
$kysely->execute();

$tunnus = htmlspecialchars($_POST["henkilonumero"]);
$salasana = htmlspecialchars($_POST["salasana"]);
$loytyi = false;

while ($rivi = $kysely->fetch()) {
	if($rivi["henkilonumero"] == $tunnus) {
		$loytyi = true;
		if($rivi["salasana"] == $salasana && ($rivi["listalla"] == 1 || $rivi["henkilonumero"] == 000)){ 
			$tyolainen = $rivi["henkilonumero"];  // tata tietoa tarvinnettaneen..
			header("Location: etusivu.php");
			exit;	
		} else if ($rivi["listalla"] != 1 && $rivi["henkilonumero"] != 000) { // 000 = listan tekija
			echo "<script> asetaViesti('tunnus_viesti', 'Et ole listalla toissa, joten et paase jarjestelmaan.'); </script>";
		} else if($rivi["salasana"] != $salasana){
			echo "<script> asetaViesti('salasana_viesti', 'Salasana ei tasmaa. Yrita uudelleen.'); </script>";
		}
	} 
}
if($tunnus != null && !$loytyi) {
	echo "<script> asetaViesti('tunnus_viesti', 'tunnus ei tasmaa. Yrita uudelleen.'); </script>";	
}

?>