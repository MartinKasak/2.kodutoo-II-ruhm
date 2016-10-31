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

	
		
	if ( isset($_POST["date"]) && 
		isset($_POST["excercise"]) &&
		isset($_POST["duration"])&&
		!empty($_POST["date"]) && 
		!empty($_POST["excercise"])&&
		!empty($_POST["duration"])
	  ) {
		$new_date = date('Y-m-d', strtotime($_POST['date']));  
		saveWorkout($_POST["date"], $_POST["excercise"], $_POST["duration"]);
		
	}
	//saan kõik auto andmed
	$workoutData = getAllWorkout();
	echo"<pre>";
//	var_dump($workoutData);
	echo"</pre>";
	
	
?>

<H1>Treeninguplaan</H1>
<?=$msg;?>

<p>Tere tulemast !<?=$_SESSION["userEmail"];?>  <a href= "?logout=1">Logi välja</a> </p>
<form method="POST">

<h3>Andmete sisestamine</h3>
<label>Salvesta harjutuse nimi</label> <br> <input type="text" placeholder = "Nt 'ujumine'" name="excercise" ><br>
<label>Sisesta minutid</label><br> <input type="text" placeholder = "Nt '15'"name="duration" ><br>
<label>Salvesta kuupäev</label><br><input type="date" name="date"  ><br>

<br>
<input type="submit" value="Salvesta andmed">

</form>

<h2>Treeningu tabel</h2>

<?php
	
	
	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>date</th>";
		$html .= "<th>excercise</th>";
		$html .= "<th>duration</th>";
	$html .= "</tr>";
	
	//iga liikme kohta massiivis
	foreach($workoutData as $w){
		//iga auto on $cal_days_in_month
		//echo $c->plate."<br>";
		$html .= "<tr>";
			$html .= "<td>".$w->id."</td>";
			$html .= "<td>".$w->date."</td>";
			$html .= "<td>".$w->excercise."</td>";
			$html .= "<td>".$w->duration."</td>";
			//$html .= "<td style ='background-color:".$c->carColor."'>".$c->carColor."</td>";
		$html .= "</tr>";
		
	}

	$html .= "</table>";
	echo $html;
	
	$listhtml = "<br><br>";
	
	
	
	
	
?>
<br><br><br><br><br><br><br><br>











