<?php

----------------------

-------------------

$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$yhteys->exec("SET NAMES latin1");

$kysely2 = $yhteys->prepare("SELECT nimi, to_char(alkupvm, 'DD.MM') as alku, to_char(loppupvm, 'DD.MM.YYYY') as loppu FROM lista WHERE lista.id = 1");
$kysely2->execute();

$tulos = $kysely2->fetch();
echo "<b>Lista: " . $tulos["nimi"] . ". Ajalla " . $tulos["alku"] . " - " . $tulos["loppu"] . ". </b>"; 


$kysely = $yhteys->prepare("SELECT * FROM vuoro, lista, tekija WHERE vuoro.tekija_id = tekija.id AND lista.id = 1 order by tekija.ammatti, tekija.sukunimi");
$kysely->execute();



echo "<table border>";
echo "<tr>";
echo "<td>Tyontekija</td>";
echo "<td>ammatti</td>";
echo "<td>paivays tahan..</td>";
echo "</tr>";

while ($rivi = $kysely->fetch()) {
    echo "<tr>";
    echo "<td>" . $rivi["sukunimi"] . " " . $rivi["etunimi"] . "</td>";
	if($rivi["ammatti"] == 1) {
		echo "<td> Sh </td>";
	} else {
		echo "<td> Hoit </td>";
	}
	echo "<td>" . $rivi["alkuaika"] . " - " . $rivi["loppuaika"] . "</td>";
	echo "<td>" . $rivi["pvm"] . "</td>";
	echo "<td>" . $rivi["tunnit"] . "</td>";
    echo "</tr>";
}
echo "</table>";

?>