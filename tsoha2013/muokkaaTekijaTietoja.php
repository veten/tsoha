<?php include("yla.php"); 
// Lomakkeella voi poistaa työntekijän listalta, tai palauttaa passiivisen työntekijän takaisin listalle.
?>
<?php include("asetuksetPalkki.php"); ?>
	<H2> Muokkaa tyontekija tietoja: </H2>
	<form action="muokkaaTekijaTietoja.php" method="post">

	<p>Poista tyontekija listalta: <br>
<?php			
 

include("yhteys.php");

$poistaTekijat = $yhteys->prepare("select * from tekija where listalla = 1 order by ammatti, sukunimi");
$poistaTekijat->execute();
echo "<select name='potekija'><option value=-1>Valitse tyontekija";
while ($potekijat = $poistaTekijat->fetch()) {
	$nimi = $potekijat["sukunimi"] . " " . $potekijat["etunimi"];
	echo "<option value='{$potekijat['id']}'> {$nimi}";
}
echo "</select><span class='red' id='poistettu_viesti'></span></p><p>Palauta tyontekija listalle: <br>";

$palautaTekijat = $yhteys->prepare("select * from tekija where listalla = 0 order by ammatti, sukunimi");
$palautaTekijat->execute();
echo "<select name='patekija'><option value=-1>Valitse tyontekija";
while ($patekijat = $palautaTekijat->fetch()) {
	$nimi = $patekijat["sukunimi"] . " " . $patekijat["etunimi"];
	echo "<option value='{$patekijat['id']}'> {$nimi}";
}
echo "</select><span class='red' id='palautettu_viesti'></span></p>";


echo "<input type='submit' value='Paivita tiedot'>
		</form>";
?>
<?php include("ala.php"); ?>
<?php 
if($_POST['potekija'] != -1) {
	$poista = $yhteys->prepare("update tekija set listalla = 0 where id = {$_POST['potekija']}");
	$poista->execute();
	echo "<script> asetaViesti('poistettu_viesti', '   Tyontekija poistettu listalta onnistuneesti.'); </script>";
}
if($_POST['patekija'] != -1) {
	$palauta = $yhteys->prepare("update tekija set listalla = 1 where id = {$_POST['patekija']}");
	$palauta->execute();
	echo "<script> asetaViesti('palautettu_viesti', '   Tyontekija palautettu listalle onnistuneesti.'); </script>";
}
	
?>		
		
