<?php
if ($_SESSION["hlonum"] == 0) {
	echo "<p class='palkki'><a href='uusi_lista.php'>Luo uusi lista</a> | <a href='muokkaalistaa.php'>Muokkaa lista tietoja</a> | <a href='tyontekijan_lisays2.php'>Lisaa uusi tyontekija </a> | 
	<a href='muokkaaTekijaTietoja.php'>Muokkaa tyontekija tietoja </a> | <a href='tyontekijoiden_listaus.php'>Listaa tyontekijat </a> 
	| <a href='listojen_listaus.php'>Listaa listat </a> </p>";
}
?>