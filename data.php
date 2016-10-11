<?php

	require("functions.php");
	
	//kui ei ol ekasutaja id
	if (!isset ($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location:login.php");
		
	}
	
	
	//kui on ? logout adress real siis login välja
	if(isset($_GET["logout"])){
		
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		
		//kui 1 korra näitame siis kustuta ära et pärast
		//ferfeshi ei näitaks
		unset($_SESSION["message"]); 
	}

	
		
	if ( isset($_POST["plate"]) && 
		isset($_POST["plate"]) && 
		!empty($_POST["color"]) && 
		!empty($_POST["color"])
	  ) {
		  
		saveWorkout(cleanInput($_POST["paev"]), $_POST["harjutus"], $_POST["harjutus"]);
		
	}
	//saan kõik auto andmed
	$workoutData = getAllWorkout();
	echo"<pre>";
//	var_dump($workoutData);
	echo"</pre>";
	
	
?>

<H1>Data</H1>
<?=$msg;?>

<p>Tere tulemast <?=$_SESSION["userEmail"];?> ! <a href= "?logout=1">Logi välja</a> </p>
<form method="POST">
<h2>Salvesta harjutuse paev</h2><input type="text" name="paev" >
<h2>Salvesta harjutuse nimi</h2> <input type="text" name="harjutus" >
<h2>Sisesta minutid</h2> <input type="text" name="minutid" >
<br><br>
<input type="submit" value="Salvesta andmed">

</form>

<h2>Autod</h2>

<?php
	
	
	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>paev</th>";
		$html .= "<th>harjutus</th>";
		$html .= "<th>minutid</th>";
	$html .= "</tr>";
	
	//iga liikme kohta massiivis
	foreach($workoutData as $w){
		//iga auto on $cal_days_in_month
		//echo $c->plate."<br>";
		$html .= "<tr>";
			$html .= "<td>".$w->id."</td>";
			$html .= "<td>".$w->paev."</td>";
			$html .= "<td>".$w->harjutus."</td>";
			$html .= "<td>".$w->minutid."</td>";
			//$html .= "<td style ='background-color:".$c->carColor."'>".$c->carColor."</td>";
		$html .= "</tr>";
		
	}

	$html .= "</table>";
	echo $html;
	
	$listhtml = "<br><br>";
	
	/*foreach($carData as $c){
		
		$listhtml .= "<h1 style='color:".$c->carColor."'>".$c->plate."</h1>";
		$listhtml .="<p>color = ".$c->carColor."</p>";
		
	}
	echo $listhtml;*/
	
	
	
?>
<br><br><br><br><br><br><br><br>











