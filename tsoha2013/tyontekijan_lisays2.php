<?php include("yla.php");  //Lomakkeella lisätään uusi työntekijä järjestelmään.
include("asetuksetPalkki.php"); 
include("yhteys.php");?>

		<H2> Lisaa uusi tyontekija: </H2>
		<form action="tyontekijan_lisays2.php" method="post">
			<p>Henkilonumero: <br>
			<input type="text" name="henkilonumer" id="hlonum"><span class='red' id='hlo_viesti'></span></p>
			<p>Etunimi: <br>
			<input type="text" name="etunimi" id="etu"><span class='red' id='etu_viesti'></span></p>
			<p>Sukunimi: <br>
			<input type="text" name="sukunimi" id="suku"><span class='red' id='suku_viesti'></span></p>
			<p>Salasana: <br>
			<input type="password" name="salasana" id="sala"><span class='red' id='sala_viesti'></span></p>
			<p>Ammatti: <br>
			<input type="radio" name="ammatti" id="amm1" value=1 >Sairaanhoitaja <br>
			<input type="radio" name="ammatti" id="amm2" value=2 >Hoitaja <br><span class='red' id='ammatti_viesti'></span></p>
			<input type="submit" value="Lisaa tyontekija"><span class='red' id='lisays_viesti'></span>
		</form>
<?php include("ala.php"); ?>
<?php

$tekijat = $yhteys->prepare ("select henkilonumero from tekija");
$tekijat->execute();
$loytyi = false;
$hlon = htmlspecialchars($_POST["henkilonumer"]);
while ($tek = $tekijat->fetch()){	
	if($tek['henkilonumero'] == $hlon) {
		echo "<script> asetaViesti('hlo_viesti', '   Kyseisellä henkilonumerolla on jo tyontekija jarjestelmassa. 
			Voi palauttaa jarjestelmassa olevan tyontekijan takaisin listalle poista lisaa tyontekija listalle linkista'); </script>";		
		$loytyi = true; 
	}
}
if(!$loytyi) {
	$lisaa = $yhteys->prepare("insert into tekija (henkilonumero, etunimi, sukunimi, ammatti, salasana) values (?, ?, ?, ?, ?)");
	$lisaa->execute(array ($hlon, htmlspecialchars($_POST["etunimi"]), htmlspecialchars($_POST["sukunimi"]), 
		$_POST["ammatti"], htmlspecialchars($_POST["salasana"])));
	echo "<script> asetaViesti('lisays_viesti', '   Tyontekija lisatty jarjestelmaan onnistuneesti.'); </script>";
}
?>
		
		
