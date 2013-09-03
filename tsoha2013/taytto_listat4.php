<?php 
// Käytetään vuorolistausten tekemisen apuna.

function valintalista($nimi, $sisalto) {
	echo "<select name=\"{$nimi}\">";
	foreach ($sisalto as $kohta) {
		if($kohta < 10) {
			echo "<option value=\"0{$kohta}\">0{$kohta}";
		} else {
			echo "<option value=\"{$kohta}\">{$kohta}";
		}
	}
	echo "</select>";
}
		
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
		echo "<article >"; 
		echo "<form class='hehkuva' action='vuoron_lisays2.php' method='post'>			
			
			<p> 
			<input type='hidden' name='lista_id_h' id='lista_id_h' value={$listat['id']}>";		

			echo "Paivays: ";
			valintalista('paiva', range(1, 31));
			valintalista('kuukausi', range(1, 12));
			valintalista('vuosi', range(2013, 2050));			
			$tekijoita = $yhteys->prepare("SELECT * FROM tekija where listalla = 1 order by ammatti, sukunimi");
			$tekijoita->execute();
			echo "Tekija: <select name='tekija'>";
			while ($haetekija = $tekijoita->fetch()) {
				$nimi = $haetekija["sukunimi"] . " " . $haetekija["etunimi"];
				echo "<option value='{$haetekija['id']}'> {$nimi}";
			}
			echo "</select>
			<p class='hehku'>Valitse stardardivuoro: 
			<select name='kirjain'>
			<option value='a' >07:00 - 15:00  
			<option value='e' >07:30 - 15:30   
			<option value='i' >13:00 - 21:00   
			<option value='j' >13:15 - 21:15   
			<option value='q' >21:00 - 24:00   
			<option value='p' >00:00 - 07:15   
			<option value='y' >21:00 - 07:15   
			<option value='v' >vapaapaiva 			
			</select></p>
			
			<p class='hehku'>Tai vaihtoehtoisesti voit itse maarittaa tarkat ajat. Merkitse talloin myos minka vuoron vahvuuteen kyseinen vuoro lasketaan: <br>";
			
			echo "Ajat: ";
			valintalista('atunti', range(0, 23));
			valintalista('amin', range(0, 59));
			echo " - ";
			valintalista('ltunti', range(0, 23));
			valintalista('lmin', range(0, 59));

			echo "<br>Itse maaritetyn vuoron vahvuuslaskenta: <br>
			<select name='kirjain2'><option value='a*' >Aamu  
			<option value='i*' >Ilta  
			<option value='y*' >Yo  
			<option value='*' >Ei mihinkaan vahvuuteen   </select></p>			
			<input type='submit' value='Lisaa vuoro'>
		</form>
		</article>";
		
	}
}
?>

