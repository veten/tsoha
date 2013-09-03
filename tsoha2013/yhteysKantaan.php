<?php
header("Content-Type: text/html; charset=utf-8");

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=X",
                      "X", "YYY");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$yhteys->exec("SET NAMES 'utf-8'");
?>