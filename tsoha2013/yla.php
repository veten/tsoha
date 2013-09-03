<?php
// On kirjautumisen jälkeen jokaisen sivuun sisällytetty tiedosto, joka sisältää HTML määritykset, tarkistaa istunnon oikeellisuuden 
// ja määrittelee sivun yläosan navigointipalkkeineen.

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: kirjautuminen.php");
    die();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Tyovuorolista</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  
<?php	
if ($_SESSION["hlonum"] == 0) {
	echo "<p>Tervetuloa VUOROX -tyovuorolista-jarjestelmaan paakayttaja !</p><body><article class='palkki'>";
	echo " <a href='etusivu.php'>Etusivu</a> | <a href='julkaistutListat.php'>Julkaistut listat </a> | <a href='avatutListat.php'>Avatut listat </a> |
		<a href='avaamattomatListat.php'>Avaamattomat listat </a> |<a href='vanhatListat.php'>Vanhat listat </a> |	<a href='asetukset.php'>Asetukset </a> | ";
} else {
	echo "<p>Tervetuloa VUOROX -tyovuorolista-jarjestelmaan, {$_SESSION['nimi']} !</p><body><article class='palkki'>";
	echo
      "<a href='etusivu.php'>Etusivu</a> |
      <a href='omat_vuorot.php'>Listaa omat vuorot</a> |
      <a href='omat_vuorot_kirjaimilla.php'>Listaa omat vuorot kirjaimilla</a> |
      <a href='koko_lista.php'>Listaa koko lista</a> |
	  <a href='koko_lista_kirjaimilla.php'>Listaa koko lista kirjaimilla</a> |
	  <a href='vanhatListat.php'>Vanhat listat</a> |
	  <a href='tunnit.php'>Listojen tunnit</a> |";
}
?>	  
	  <a href='ulos.php'>Kirjaudu ulos</a>
    </article>
	
	