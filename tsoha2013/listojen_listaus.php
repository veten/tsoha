<?php include("yla.php"); 
// Listaa kaikki järjestelmän listat.
?>
<?php include("asetuksetPalkki.php"); ?>

<?php

include("yhteys.php");

$listat = $yhteys->prepare("select to_char(alkupvm, 'DD.MM.YYYY') as alku, to_char(loppupvm, 'DD.MM.YYYY') as loppu, listan_tila, nimi
	from lista order by listan_tila, nimi desc");
$listat->execute();

echo "<H2> Listat: </H2>";
echo "<p><table border>";
echo "<tr>";
echo "<td>nimi</td>";
echo "<td>alkupvm</td>";
echo "<td>loppupvm</td>";
echo "<td>listan tila</td>";
echo "</tr>";

while ($lista = $listat->fetch()) {

	if($lista["listan_tila"] == 0) {
		$tila = 'avaamaton lista';
	} else if($lista["listan_tila"] == 1) {
		$tila = 'avattu lista';
	} else if($lista["listan_tila"] == 2) {
		$tila = 'julkaistu lista';
	} else {
		$tila = 'vanha lista';
	}
    echo "<tr>";
    echo "<td>" . $lista["nimi"] . "</td>";
    echo "<td>" . $lista["alku"] . "</td>";
	echo "<td>" . $lista["loppu"] . "</td>";
	echo "<td>" . $tila . "</td>";
    echo "</tr>";
}
echo "</table></p>";

?>

<?php include("ala.php"); ?>