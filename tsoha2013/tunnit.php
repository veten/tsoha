<?php include("yla.php"); ?>

<?php
// Listaa työntekijän tunnit / lisätunnit.

include("yhteys.php");

$listat = $yhteys->prepare("select lista.id, lista.nimi, to_char(vuoro.pvm, 'DD.MM.YYYY') as pvm, vuoro.tunnit, vuoro.su_tunnit, vuoro.la_tunnit,
	vuoro.ilta_tunnit, vuoro.yo_tunnit from lista, vuoro where lista.id = vuoro.lista_id and vuoro.tekija_id = {$_SESSION["id"]} and 
	lista.listan_tila > 1 order by lista.id, vuoro.pvm");
$listat->execute();

echo "<H2> Listat: </H2>";
echo "<p><table border>";
echo "<tr>";
echo "<td>Listan nimi</td>";
echo "<td>Pvm</td>";
echo "<td>Tunnit</td>";
echo "<td>Sunnuntai</td>";
echo "<td>Lauantai</td>";
echo "<td>Ilta</td>";
echo "<td>Yo</td>";
echo "</tr>";

while ($lista = $listat->fetch()) {
    echo "<tr>";
    echo "<td>" . $lista["nimi"] . "</td>";
    echo "<td>" . $lista["pvm"] . "</td>";
    echo "<td>" . $lista["tunnit"] . "</td>";
    echo "<td>" . $lista["su_tunnit"] . "</td>";
    echo "<td>" . $lista["la_tunnit"] . "</td>";
    echo "<td>" . $lista["ilta_tunnit"] . "</td>";
    echo "<td>" . $lista["yo_tunnit"] . "</td>";
    echo "</tr>";
}
echo "</table></p>";


?>

<?php include("ala.php"); ?>