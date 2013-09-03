<?php
// Poistaa istontomuuttujat ja ohjaa käyttäjän kirjautumissivulle.

session_start();
unset($_SESSION["nimi"]);
unset($_SESSION["id"]);
unset($_SESSION["henkilonumero"]);
header("Location: kirjautuminen.php");
?>