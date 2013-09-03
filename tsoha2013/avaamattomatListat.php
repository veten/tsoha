<?php include("yla.php"); 
// Listaa kaikki avaamattomat listat. Näihin listoihin jatkokehittelyvaiheessa työntekijät voivat lisätä vuorotoiveitaan järjestelmän kautta. 
// Listan alapuolella on aina lomake, jolla voi täyttää listaan yksittäisen vuoron joko valitsemalla normaalin kahdeksan tunnin vuoron tai 
// sitten itse tarkemmin määritellyn vuoron.
?>
<h2>Avaamattomat listat</h2>
<p>Alla on listattu kaikki avaamattomat tyovuorolistat. Naihin tyontekijat voivat viela laittaa vuorotoiveita jarjestelman kautta.
	Tarvittaessa voit luoda uuden listan asetuksista. Voit lisata vuoroja listaan listan alapuolella olevassa lomakkeessa. 
	Tayta vain tarvittavat kentat ja paina 'lisaa vuoro' -nappia</p>

<?php 
include("yhteys.php");

$listaluettelo = $yhteys->prepare("select id from lista where listan_tila = 0 order by id"); 
$listaluettelo->execute();

include("taytto_listat4.php");


?>
<?php include("ala.php"); ?>
