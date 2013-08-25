<?php

-----------------------
// yhteyden muodostus tietokantaan

--------------------

$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$kirjain = htmlspecialchars($_POST["kirjain"]);
$alku = htmlspecialchars($_POST["alku"]);
$loppu = htmlspecialchars($_POST["loppu"]);
$tekija = htmlspecialchars($_POST["tekija_id"]);
$lista = htmlspecialchars($_POST["lista_id"]);
$pvm = htmlspecialchars($_POST["pvm"]);
$tunnit = 8.0;
if($kirjain == 'a'){
	$alku = '07:00';
	$loppu = '15:00';
} else if($kirjain == 'e'){
	$alku = '07:30';
	$loppu = '15:30';
} else if($kirjain == 'i'){
	$alku = '13:00';
	$loppu = '21:00';	
} else if($kirjain == 'j'){
	$alku = '13:15';
	$loppu = '21:15';	
} else if($kirjain == '.y'){
	$alku = '21:00';
	$loppu = '24:00';
	$tunnit = 3;
} else if($kirjain == 'y.'){
	$alku = '00:00';
	$loppu = '07:15';
	$tunnit = 7.25;	
} else if($kirjain == 'y'){
	$alku = '21:00';
	$loppu = '07:15';	
	$tunnit = 10.25;
} else if($kirjain == 'v'){
	$alku = '00:00';
	$loppu = '00:00';	
	$tunnit = 0;
} else 
	//laske tunnit ajoista..
	if($loppu > $alku){
	$tunnit = $loppu*
}

// kyselyn suoritus
$kysely = $yhteys->prepare("INSERT INTO vuoro (tekija_id, lista_id, alkuaika, loppuaika, pvm, vuoro_kirjaimella, tunnit) VALUES (?, ?, ?, ?, ?, ?, ?)");
$kysely->execute(array($tekija, $lista, $alku, $loppu, $pvm, $kirjain, $tunnit));



?>