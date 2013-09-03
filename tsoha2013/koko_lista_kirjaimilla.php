<?php include("yla.php"); 
// Listaa työntekijälle kaikki julkaistut listat kokonaisuudessaan, merkiten vuoroja kirjain lyhentein, joilla hän on. 
?>
<h2>Koko tyovuorolistan listaus kirjain-merkinnoin</h2>
<p>Alla on listattu kaikki julkaistut tyovuorolistat, joilla olet listalla.</p>
<p>Kirjaimien selitykset: A = 07:00 - 15:00, E = 07:30 - 15:30, I = 13:00 - 21:00, J = 13:15 - 21:15, Y = 21:00 - 07:15, V = vapaapaiva. 
	* tarkoittaa, etta ko vuoro ei ole yllamainittu standardi vuoro, mutta kuuluu ko vuoron vahvuuteen.  </p>
<?php
include("yhteys.php");

$listaluettelo = $yhteys->prepare("SELECT distinct lista.id as id FROM lista, vuoro WHERE vuoro.lista_id = lista.id and lista.listan_tila = 2 
	and vuoro.tekija_id = {$_SESSION['id']}"); 
$listaluettelo->execute();

while ($listat = $listaluettelo->fetch()) {
	$yksittainenlista = $yhteys->prepare("select nimi, alkupvm, to_char(alkupvm, 'DDD') as alkaa, to_char(loppupvm, 'DDD') as loppuu, 
		to_char(alkupvm, 'DD.MM') as alkuotsikossa, to_char(loppupvm, 'DD.MM.YYYY') as loppuotsikossa from lista where id = {$listat['id']}");
	$yksittainenlista->execute();

	while($yksittainen = $yksittainenlista->fetch()){
		echo "<b class='sininen'>Lista: " . $yksittainen["nimi"] . ". Ajalla " . $yksittainen["alkuotsikossa"] . " - " . $yksittainen["loppuotsikossa"]
			. ". </b><br>"; 

		$alkupaiva = intval($yksittainen["alkaa"]);
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
				echo "<td><b>" . strtoupper($rivi["vuoro_kirjaimella"]) . "</b></td>"; 
				$yht += $rivi["tunnit"];
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

include("ala.php"); 

?>
