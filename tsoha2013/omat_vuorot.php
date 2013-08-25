<?php include("yla.php"); ?>
<h2>Omien tyovuorojen listaus</h2>
<p>Alla on listattu kaikki julkaistut tyovuorolistat, joilla olet listalla. Valitse linkkia klikkaamalla lista, jonka vuorot haluat listata.</p>

<?php

----------------
poistettu..
---------------
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$yhteys->exec("SET NAMES latin1");

$kysely2 = $yhteys->prepare("SELECT nimi, alkupvm, to_char(alkupvm, 'DDD') as numpaivays_alku, to_char(loppupvm, 'DDD') as numpaivays_loppu, 
	to_char(alkupvm, 'DD.MM') as alku, to_char(loppupvm, 'DD.MM.YYYY') as loppu FROM lista WHERE lista.id = 1");
$kysely2->execute();

$tulos = $kysely2->fetch();
echo "<b>Lista: " . $tulos["nimi"] . ". Ajalla " . $tulos["alku"] . " - " . $tulos["loppu"] . ". </b>"; 

$alkupaiva = intval($tulos["numpaivays_alku"]);
$loppupaiva = intval($tulos["numpaivays_loppu"]);
$listan_pituus = $loppupaiva - $alkupaiva;
$juokseva = $alkupaiva - 1;
echo "<table border>";
echo "<tr>";
echo "<td>Tyontekija</td>";
echo "<td>ammatti</td>";
for ($i = 1; $i <= 21; $i++) {
	$date = DateTime::createFromFormat('z', $juokseva);
	echo "<td>" . $date->format('j. n.') . "\n";
	$juokseva++;
	if($i % 7 == 1){
		echo "Ma </td>";		
	} else if($i % 7 == 2){
		echo "Ti </td>";	
	} else if($i % 7 == 3){
		echo "Ke </td>";		
	} else if($i % 7 == 4){
		echo "To </td>";		
	} else if($i % 7 == 5){
		echo "Pe </td>";		
	} else if($i % 7 == 6){
		echo "La </td>";		
	} else{
		echo "Su </td>";		
	}
}
echo "<td>Tunnit \n yht.</td>";
echo "</tr>";

$kysely = $yhteys->prepare("SELECT vuoro.vuoro_kirjaimella, vuoro.tunnit, tekija.etunimi as etu, tekija.sukunimi as suku, tekija.ammatti, 
	to_char(vuoro.pvm, 'DDD') as pvm, to_char(vuoro.alkuaika, 'HH24:MI') as alku, to_char(vuoro.loppuaika, 'HH24:MI') as loppu 
	FROM vuoro, tekija WHERE vuoro.tekija_id = 5 AND vuoro.lista_id = 1 and tekija.id = vuoro.tekija_id order by vuoro.pvm, vuoro.alkuaika");
$kysely->execute();
$lask = $alkupaiva;
$yht = 0.0;
while ($rivi = $kysely->fetch()) {
    if($lask == $alkupaiva) {
		echo "<tr>";
		echo "<td>" . $rivi["suku"] . " " . $rivi["etu"] . "</td>";
		if($rivi["tekija.ammatti"] == 1) {
			echo "<td> Sh </td>";
		} else {
			echo "<td> Hoit </td>";
		}
	}
	if($rivi["pvm"] != $lask){
		echo "<td> </td>";
	} else if($rivi["vuoro_kirjaimella"] != 'v') {
		echo "<td>" . $rivi["alku"] . " - " . $rivi["loppu"] . "</td>"; 
		$yht += $rivi["tunnit"];
	} else {
		echo "<td>v</td>"; 
	}
	$lask++;
}
if($yht < (38.25 * 3)){
	$vari = "red";
} else if($yht > (38.25 * 3)){
	$vari = "green";
} else {
	$vari = "black";
}

echo "<td><b><span style=\"color:{$vari}\">{$yht}</span> / " . 38.25 * 3 . "</b></td></tr>";
echo "</table>";

?>

<?php include("ala.php"); ?>
