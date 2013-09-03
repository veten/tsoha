<?php include("yla.php"); 
// Tällä sivulla listan tekijä pystyy muuttamaan listan tilan asetusta aina avaamattomasta listasta vanhentuneeseen listaan asti.
?>
<?php include("asetuksetPalkki.php"); ?>
	<H2> Vaihda listan tilaa: </H2>
	<form action="muokkaalistaa.php" method="post">

	
<?php			
include("yhteys.php");

$haeListat = $yhteys->prepare("select * from lista");
$haeListat->execute();
echo "<select name='lista'><option value=-1>Valitse lista";
while ($haluttuLista = $haeListat->fetch()) {
	$nimi = $haluttuLista["nimi"];
	echo "<option value='{$haluttuLista['id']}'> {$nimi}";
}
echo "</select><span class='red' id='lisaa_viesti'></span><br>";

echo "<select name='tila'><option value=-1>Valitse listalle tila";
echo "<option value=0> avaamaton lista";
echo "<option value=1> avattu lista";
echo "<option value=2> julkaistu lista";
echo "<option value=3> vanha lista";
echo "</select></p>";
echo "<input type='submit' value='Paivita tiedot'>
		</form>";
?>
<?php include("ala.php"); ?>
<?php 
if($_POST['lista'] != -1) {
	$muuta = $yhteys->prepare("update lista set listan_tila = {$_POST['tila']} where id = {$_POST['lista']}");
	$muuta->execute();
	echo "<script> asetaViesti('lisaa_viesti', '   Listan tila muutettu onnistuneesti.'); </script>";
}
	
?>		
		
