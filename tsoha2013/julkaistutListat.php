<?php include("yla.php"); 
// Listaa kaikki julkaistut listat. Listan alapuolella on aina lomake, jolla voi täyttää listaan yksittäisen vuoron joko valitsemalla 
// normaalin kahdeksan tunnin vuoron tai sitten itse tarkemmin määritellyn vuoron.
?>
<h2>Julkaistut listat</h2>
<p>Alla on listattu kaikki julkaistut tyovuorolistat. Jos teet naihin muutoksia, muista informoida myos asianosaisia tyontekijoita.
	Tarvittaessa voit luoda uuden listan asetuksista. Voit lisata vuoroja listaan listan alapuolella olevassa lomakkeessa. 
	Tayta vain tarvittavat kentat ja paina 'lisaa vuoro' -nappia</p>

<?php 
include("yhteys.php");

$listaluettelo = $yhteys->prepare("select id from lista where listan_tila = 2 order by id"); 
$listaluettelo->execute();

include("taytto_listat4.php");

?>
<?php include("ala.php"); ?>
