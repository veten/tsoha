<?php include("yla.php"); 

	//Listaa kaikki vanhat listat. N�it� listoja listan tekij� ei p��se muokkaamaan ilman, ett� muuttaa listan tilaa. 
	//Vanhat listat n�kyv�t samanlaisena listan tekijalle ja ty�ntekij�lle, joka on ko listalla ollut t�iss�.
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
