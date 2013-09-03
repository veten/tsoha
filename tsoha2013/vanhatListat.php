<?php include("yla.php"); 

	//Listaa kaikki vanhat listat. Näitä listoja listan tekijä ei pääse muokkaamaan ilman, että muuttaa listan tilaa. 
	//Vanhat listat näkyvät samanlaisena listan tekijalle ja työntekijälle, joka on ko listalla ollut töissä.
?>

<h2>Vanhat listat</h2>
<p>Alla on listattu kaikki vanhat tyovuorolistat. </p>

<?php 
include("yhteys.php");

$listaluettelo = $yhteys->prepare("select id from lista where listan_tila = 3 order by id"); 
$listaluettelo->execute();

include("taytto.php");
include("ala.php"); 
?>
