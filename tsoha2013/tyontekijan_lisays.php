<?php

------------
// yhteyden muodostus tietokantaan


---------------

$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$yhteys->exec("SET NAMES latin1");

//$listaus = $_POST;
//for ($i = 0; $i < count($listaus); $i++) {
  //  if($listaus[$i] == ""){
	//	echo "Jatit kohdan " . $listaus[$i] . $i . " tayttamatta. Yrita uudelleen.";
		// palaa lisays.html -sivulle
//	}
//}

	//if($_POST["ammatti"] == null){
		//echo "Jatit kohdan ammatti merkitsematta. Yrita uudelleen.";
		// palaa lisays.html -sivulle
	//}
    


// kyselyn suoritus
$kysely = $yhteys->prepare("INSERT INTO tekija (henkilonumero, etunimi, sukunimi, ammatti, salasana) VALUES (?, ?, ?, ?, ?)");
$kysely->execute(array(htmlspecialchars($_POST["henkilonumero"]), htmlspecialchars($_POST["etunimi"]), htmlspecialchars($_POST["sukunimi"]), $_POST["ammatti"], htmlspecialchars($_POST["salasana"])));



//		<script src="tyontekijan_lisays.js"></script>

?>