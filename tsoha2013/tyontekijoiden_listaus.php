<?php

----------------------

---------------------

$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$yhteys->exec("SET NAMES latin1");

$kysely = $yhteys->prepare("SELECT * FROM tekija");
$kysely->execute();

echo "<H1> Tyontekijat: <H1>";
echo "<table border>";
echo "<tr>";
echo "<td>henkilonumero</td>";
echo "<td>etunimi</td>";
echo "<td>sukunimi</td>";
echo "<td>ammatti</td>";
echo "<td>listalla</td>";
echo "</tr>";

while ($rivi = $kysely->fetch()) {
    echo "<tr>";
    echo "<td>" . $rivi["henkilonumero"] . "</td>";
    echo "<td>" . $rivi["etunimi"] . "</td>";
	echo "<td>" . $rivi["sukunimi"] . "</td>";
	echo "<td>" . $rivi["ammatti"] . "</td>";
	echo "<td>" . $rivi["listalla"] . "</td>";
    echo "</tr>";
}
echo "</table>";

?>