<?php include("yla.php"); ?>
<?php include("asetuksetPalkki.php"); ?>

<?php
// Listaa kaikki järjestelmässä olevat työntekijät. Myös ne jotka eivät ole parhaillaan listalla, eli aktiivisia.

include("yhteys.php");

$tekijat = $yhteys->prepare("select * from tekija order by listalla desc, ammatti, sukunimi");
$tekijat->execute();

echo "<H2> Tyontekijat: </H2>";
echo "<table border>";
echo "<tr>";
echo "<td>henkilonumero</td>";
echo "<td>etunimi</td>";
echo "<td>sukunimi</td>";
echo "<td>ammatti</td>";
echo "<td>listalla</td>";
echo "</tr>";

while ($rivi = $tekijat->fetch()) {

	if($rivi["ammatti"] == 1) {
		$amm = 'Sairaanhoitaja';
	} else {
		$amm = 'Hoitaja';
	}
	if($rivi["listalla"] == 0) {
		$lis = 'ei';
	} else {
		$lis = 'on';
	}
    echo "<tr>";
    echo "<td>" . $rivi["henkilonumero"] . "</td>";
    echo "<td>" . $rivi["etunimi"] . "</td>";
	echo "<td>" . $rivi["sukunimi"] . "</td>";
	echo "<td>" . $amm . "</td>";
	echo "<td>" . $lis . "</td>";
    echo "</tr>";
}
echo "</table>";

?>

<?php include("ala.php"); ?>