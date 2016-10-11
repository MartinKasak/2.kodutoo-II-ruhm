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
		  
		saveCar(cleanInput($_POST["plate"]), $_POST["color"]);
		
	}
	//saan kõik auto andmed
	$carData = getAllCars();
	echo"<pre>";
	var_dump($carData);
	echo"</pre>";
	
	
?>

<H1>Data</H1>
<?=$msg;?>

<p>Tere tulemast <?=$_SESSION["userEmail"];?> ! <a href= "?logout=1">Logi välja</a> </p>
<form method="POST">
<h2>Salvesta auto nr</h2><input type="text" name="plate" >
<h2>Salvesta auto värv</h2> <input type="color" name="color" >
<br><br>
<input type="submit" value="Salvesta andmed">

</form>

<h2>Autod</h2>

<?php
	
	
	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>plate</th>";
		$html .= "<th>color</th>";
	$html .= "</tr>";
	
	//iga liikme kohta massiivis
	foreach($carData as $c){
		//iga auto on $cal_days_in_month
		//echo $c->plate."<br>";
		$html .= "<tr>";
			$html .= "<td>".$c->id."</td>";
			$html .= "<td>".$c->plate."</td>";
			$html .= "<td style ='background-color:".$c->carColor."'>".$c->carColor."</td>";
		$html .= "</tr>";
		
	}

	$html .= "</table>";
	echo $html;
	
	$listhtml = "<br><br>";
	
	foreach($carData as $c){
		
		$listhtml .= "<h1 style='color:".$c->carColor."'>".$c->plate."</h1>";
		$listhtml .="<p>color = ".$c->carColor."</p>";
		
	}
	echo $listhtml;
	
	
	
?>
<br><br><br><br><br><br><br><br>











