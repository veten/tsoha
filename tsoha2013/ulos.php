<?php
// Poistaa istontomuuttujat ja ohjaa k�ytt�j�n kirjautumissivulle.

session_start();
unset($_SESSION["nimi"]);
unset($_SESSION["id"]);
unset($_SESSION["henkilonumero"]);
header("Location: kirjautuminen.php");
?>