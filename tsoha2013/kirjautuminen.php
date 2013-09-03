<?php
// On järjestelmän aloitussivu, minne käyttäjä ohjautuu, jos istuntomuuttuja ei salli halutulle sivulle menoa. Myös uloskirjautumisesta 
// ohjautuu tänne. Sivu sisältää kentät henkilönumerolle ja salasanalle. Jos työntekijä ei ole parhaillaan listalla töissä, tai muutoin 
// syötteet ei täsmää, ei järjestelmään pääse sisälle.
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Kirjautuminen</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
		<article class='kirj'>
		<H2> Kirjautuminen: </H2>
		
		<form action="kirjautuminen.php" method="post">
			<p>Henkilonumero: <br>
				<input type="text" name="hlonro">
				<span class="red" id="tunnus_viesti"></span>
			</p>
			<p>Sanasana: <br>
				<input type="password" name="ssana">
				<span class="red" id="salasana_viesti"></span>
			</p>
            <input type="submit" value="Kirjaudu">
		</form>
		</article>
		<script src="code.js"></script>
    </body>
</html>

<?php

include("yhteys.php");

$kysely = $yhteys->prepare("select * from tekija");
$kysely->execute();

$tunnu = htmlspecialchars($_POST["hlonro"]);
$salas = htmlspecialchars($_POST["ssana"]);
$loytyi = false;

while ($rivi = $kysely->fetch()) {
	if($rivi["henkilonumero"] == $tunnu) {
		$loytyi = true;
		if($rivi["salasana"] == $salas && ($rivi["listalla"] == 1 || $rivi["henkilonumero"] == 000)){ 
			$_SESSION["nimi"] = $rivi["etunimi"];
			$_SESSION["id"] = $rivi["id"];
			$_SESSION["hlonum"] = $rivi["henkilonumero"];
			header("Location: etusivu.php");
			die();			
		} else if ($rivi["listalla"] != 1 && $rivi["henkilonumero"] != 0) { // 0 = listan tekija
			echo "<script> asetaViesti('tunnus_viesti', 'Et ole listalla toissa, joten et paase jarjestelmaan.'); </script>";
		} else if($rivi["salasana"] != $salas & $salas != null){
			echo "<script> asetaViesti('salasana_viesti', 'Salasana ei tasmaa. Yrita uudelleen.'); </script>";
		}
	} 
}
if($tunnu != null && !$loytyi) {
	echo "<script> asetaViesti('tunnus_viesti', 'tunnus ei tasmaa. Yrita uudelleen.'); </script>";	
}

?>