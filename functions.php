<?php
	//functions.php
	require("../../config.php");
	//var_dump($GLOBALS);
	// see fail peab olema kõigil lehtedel kus tahan kasutada session muutujat
	session_start();
	
	//***************
	//*****SIGNUP******
	//****************
	
	function signUp($email, $password){
		
		$database = "if16_martkasa";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		
		$stmt->bind_param("ss", $email, $password);
		
		
		if($stmt->execute()) {
			
			echo "salvestamine õnnestus";
			
		} else {
				echo "ERROR ".$stmt->error;
		}
		
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
	function login ($email, $password){
		
		$error = "";
		
		$database = "if16_martkasa";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
					
		$stmt = $mysqli->prepare("SELECT id, email, password, created FROM user_sample WHERE email = ?");
		
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran väärtused muutjatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		//andmed tulid andmebaasist
		
		if($stmt->fetch()){
			
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb){
				echo "kasutaja logis sisse"." ".$id;
				//määran sessioooni muutujad millel saan ligi teistelt muutujatelt
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				$_SESSION["message"] = "<h1>Tere tulemast</h1>";
				
				header("Location: data.php");
				exit();
			}else{
				$error = "vale parool";
			}
			
			
			
			
		} else {
			
			//ei leidnud kasutajat selle meiliga
			$error = "ei ole sellist emaili";
		}
		
		
		return $error;
		
	}
	
	function saveWorkout ($date, $excercise, $duration){
			
		$database = "if16_martkasa";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		$stmt = $mysqli->prepare("INSERT INTO workout (date, excercise, duration) VALUES (?, ?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ssi",$date, $excercise, $duration );
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();		
		
	}
	
	function getAllWorkout(){
		
		$database = "if16_martkasa";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("
		
			SELECT id, date, excercise, duration 
			FROM workout
			
		");
		
		echo $mysqli->error;
		
		$stmt->bind_result($id, $date, $excercise, $duration);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		//tee seda seni kuni on rida andmeid
		//mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti 
			$workout = new StdClass();
			
			$workout->id = $id;
			$workout->date = $date;
			$workout->excercise = $excercise;
			$workout->duration = $duration;
			
			
			//echo $plate."<br>";
			//igakord massiivi lisanm juurse nr märgi
			array_push($result, $workout);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	
	
	function cleanInput($input){
		
		$input = trim($input);
		$input = stripcslashes($input);
		$input = htmlspecialchars($input);
		
		return $input;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*function hello($firstname, $lastname) {
		
		return "Teretulemast".$firstname." ".$lastname;
	}
		
	
	echo "<br>";
	echo hello("martin", "kasak");
	echo"<br>";
	echo hello ("juurikas", "tegelane")
	*/
	
	
	
	
?>