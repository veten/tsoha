<?php
// K�ytet��n vuorolistausten tekemisen apuna.

while ($listat = $listaluettelo->fetch()) {
	$yksittainenlista = $yhteys->prepare("select nimi, alkupvm, to_char(alkupvm, 'DDD') as alkaa, to_char(loppupvm, 'DDD') as loppuu, 
		to_char(alkupvm, 'DD.MM') as alkuotsikossa, to_char(loppupvm, 'DD.MM.YYYY') as loppuotsikossa from lista where id = {$listat['id']}");
	$yksittainenlista->execute();

	while($yksittainen = $yksittainenlista->fetch()){
		echo "<b class='sininen'>Lista: " . $yksittainen["nimi"] . ". Ajalla " . $yksittainen["alkuotsikossa"] . " - " . $yksittainen["loppuotsikossa"]
			. ". </b><br>"; 

		$alkupaiva = intval($yksittainen["alkaa"]);
		$loppupaiva = intval($yksittainen["loppuu"]); // ei kaytossa..
		$listan_pituus = $loppupaiva - $alkupaiva; // ei kaytossa.. oletetaan aina 3 vk lista..
		$juokseva = $alkupaiva - 1;
		echo "<p><table border><tr><td>Rivi</td><td>Tyontekija</td><td>ammatti</td>";  
		for ($i = 1; $i <= 21; $i++) {
			$date = DateTime::createFromFormat('z', $juokseva);
			echo "<td>" . $date->format('j.n.') . "\n";
			$juokseva++;
			if($i % 7 == 1){
				echo "Ma </td>";		
			} else if($i % 7 == 2){
				echo "Ti </td>";	
			} else if($i % 7 == 3){
				echo "Ke </td>";		
			} else if($i % 7 == 4){
				echo "To </td>";		
			} else if($i % 7 == 5){
				echo "Pe </td>";		
			} else if($i % 7 == 6){
				echo "La </td>";		
			} else{
				echo "Su </td>";		
			}
		}
		echo "<td>Tunnit \n yht.</td></tr>";

		$tekijat = $yhteys->prepare ("select * from tekija where listalla = 1 order by ammatti, sukunimi");
		$tekijat->execute();
		$rivilla = 1;
		while ($tyolainen = $tekijat->fetch()){	
			$vuoroja = $yhteys->prepare("select vuoro.vuoro_kirjaimella, vuoro.tunnit, tekija.etunimi as etu, tekija.sukunimi as suku, ammatti, 
				to_char(vuoro.pvm, 'DDD') as ppvm, to_char(vuoro.alkuaika, 'HH24:MI') as alk, to_char(vuoro.loppuaika, 'HH24:MI') as lop 
				from vuoro, tekija where vuoro.tekija_id = {$tyolainen['id']} and vuoro.lista_id = {$listat['id']} and tekija.id = vuoro.tekija_id 
				order by ppvm, vuoro.alkuaika"); 
			$vuoroja->execute();
			$sarake = 1;
			$yht = 0.0;
			echo "<tr> <td> {$rivilla} </td>";
			while ($rivi = $vuoroja->fetch()) {
				if($sarake == 1) {
					echo "<td>" . $rivi["suku"] . " " . $rivi["etu"] . "</td>";
					if($rivi["ammatti"] == 1) {
						echo "<td> Sh </td>";
					} else {
						echo "<td> Hoit </td>";
					}
					$sarake += 2;
				}
				while(intval($rivi["ppvm"]) - $alkupaiva > $sarake - 3) {
					echo "<td></td>";
					$sarake++;
				}
				if($rivi["vuoro_kirjaimella"] != 'v') {
					echo "<td>" . $rivi["alk"] . " - " . $rivi["lop"] . "</td>"; 
					$yht += $rivi["tunnit"];
				} else {
					echo "<td>V</td>"; 
				}
				$sarake++;
			}
			if($sarake == 1){ // ei yhtaan vuoroa listalla
				echo "<td>" . $tyolainen["sukunimi"] . " " . $tyolainen["etunimi"] . "</td>";
				if($tyolainen["ammatti"] == 1) {
					echo "<td> Sh </td>";
				} else {
					echo "<td> Hoit </td>";
				}
				$sarake += 2;
			}
			while($sarake < 24){
				echo "<td></td>";
				$sarake++;
			}
  
			if($yht < (38.25 * 3)){
				$vari = "red";
			} else if($yht > (38.25 * 3)){
				$vari = "green";
			} else {
				$vari = "black";
			}
 
			echo "<td><b><span style=\"color:{$vari}\">{$yht}</span> / " . 38.25 * 3 . "</b></td></tr>";
			$rivilla++;
		}
		$rivilla = 1;
	
		
		echo "</table></p>"; 
	}
}
?>
