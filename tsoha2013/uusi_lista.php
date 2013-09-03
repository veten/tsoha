<?php

// Lomakkeella lisätään uusi lista järjestelmään.
 
include("yla.php"); 
include("asetuksetPalkki.php"); 
include("yhteys.php");
?>

		<H2> Luo uusi lista: </H2>
		<form action="uusi_lista.php" method="post">
			<p>Listan nimi: <br>
			<input type="text" name="nimi" id="nimi"></p>
			<p>Listan alkupaiva: <br>
			<input type="text" name="alku" id="alku" value='pp.kk.vvvv'></p>
			<p>Listan loppupaiva: <br>
			<input type="text" name="loppu" id="loppu" value='pp.kk.vvvv'></p>
			<input type="submit" value="Luo lista"><span class='red' id='lisaa_viesti'></span>
		</form>

<?php include("ala.php"); ?>
<?php

$listat = $yhteys->prepare ("select nimi from lista");
$listat->execute();
$loytyi = false;
$nim = htmlspecialchars($_POST["nimi"]);
while ($list = $listat->fetch()){	
	if($list['nimi'] == $nim) {
		echo "<script> asetaViesti('lisaa_viesti', '   Kyseisella nimella on jo lista jarjestelmassa. Vaihda listan nimea.'); </script>";		
		$loytyi = true; 
	}
}
if(!$loytyi) {
	$lisaa = $yhteys->prepare("insert into lista (nimi, alkupvm, loppupvm) values (?, ?, ?)");
	$lisaa->execute(array ($nim, htmlspecialchars($_POST["alku"]), htmlspecialchars($_POST["loppu"])));
	echo "<script> asetaViesti('lisaa_viesti', '   Lista lisatty jarjestelmaan onnistuneesti.'); </script>";
}

?>