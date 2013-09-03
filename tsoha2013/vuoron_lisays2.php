<?php

// Lisää annetuilla tiedoilla yksittäisen vuoron tietokantaan.

include("yhteys.php");
$su = 0.0;
$la = 0.0;
$ilta = 0.0;
$yo = 0.0;
$tunnit = 8.0;
$tekija = htmlspecialchars($_POST["tekija"]); 
$listasa = htmlspecialchars($_POST["lista_id_h"]); 
$pvm = $_POST["paiva"] . '.' . $_POST["kuukausi"] . '.' . $_POST["vuosi"];
if($_POST["atunti"] != 0 || $_POST["ltunti"] != 0 || $_POST["amin"] != 0 || $_POST["lmin"] != 0) {
	$alku = $_POST["atunti"] . ':' . $_POST["amin"];
	$loppu = $_POST["ltunti"] . ':' . $_POST["lmin"];
	$kirjain = htmlspecialchars($_POST["kirjain2"]); 
	$ah = intval($_POST["atunti"]);
	$lh = intval($_POST["ltunti"]);
	$am = intval($_POST["amin"]);
	$lm = intval($_POST["lmin"]);
	if($ah <= $lh) {
		$tunnit = $lh - $ah + ($lm/60 - $am/60);
	} else {
		$tunnit = 24 - $ah + $lh + ($lm/60 - $am/60);
	}
} else {
	$kirjain = htmlspecialchars($_POST["kirjain"]); 

	if($kirjain == 'a'){
		$alku = '07:00';
		$loppu = '15:00';
	} else if($kirjain == 'e'){
		$alku = '07:30';
		$loppu = '15:30';
	} else if($kirjain == 'i'){
		$alku = '13:00';
		$loppu = '21:00';
		$ilta = 3.0;
	} else if($kirjain == 'j'){
		$alku = '13:15';
		$loppu = '21:15';
		$yo = 0.25;
		$ilta = 3.0;
	} else if($kirjain == 'q'){
		$alku = '21:00';
		$loppu = '24:00';
		$tunnit = 3;
		$yo = 3.0;
	} else if($kirjain == 'p'){
		$alku = '00:00';
		$loppu = '07:15';
		$tunnit = 7.25;	
		$yo = 6.0;
	} else if($kirjain == 'y'){
		$alku = '21:00';
		$loppu = '07:15';	
		$tunnit = 10.25;
		$yo = 9.0; //yotyotunteja tulee vain klo 06 asti
	} else {
		$alku = '00:00';
		$loppu = '00:00';	
		$tunnit = 0;
	}
}
$tehtyt = $yhteys->prepare ("select id, lista_id, tekija_id, to_char(pvm, 'DD.MM.YYYY') as pvmm from vuoro where lista_id = {$listasa} and tekija_id = {$tekija}");
$tehtyt->execute();
$tosi = false;
while ($tehty = $tehtyt->fetch()){	
	if($tehty['pvmm'] == $pvm) {
		$tosi = true;
		$kyselyja = $yhteys->prepare("update vuoro set alkuaika = '{$alku}', loppuaika = '{$loppu}', vuoro_kirjaimella = '{$kirjain}', 
			tunnit = {$tunnit}, su_tunnit = {$su}, la_tunnit = {$la}, ilta_tunnit = {$ilta}, yo_tunnit = {$yo} where id = {$tehty['id']}");
		$kyselyja->execute();
		break;
	}
}
if(!$tosi) {
	$kysely = $yhteys->prepare("INSERT INTO vuoro (tekija_id, lista_id, alkuaika, loppuaika, vuoro_kirjaimella, pvm, tunnit, su_tunnit, la_tunnit,
	ilta_tunnit, yo_tunnit) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$kysely->execute(array($tekija, $listasa, $alku, $loppu, $kirjain, $pvm, $tunnit, $su, $la, $ilta, $yo));
}
$listat = $yhteys->prepare ("select listan_tila from lista where id = {$listasa}"); 
$listat->execute();
$list = $listat->fetch();	
if($list['listan_tila'] == 0) {
	header("Location: avaamattomatListat.php");
} else if($list['listan_tila'] == 1) {
	header("Location: avatutListat.php");
} else if($list['listan_tila'] == 2) {
	header("Location: julkaistutListat.php");
}

?>