<?php 
	
	//require("../../config.php");
	//echo hash("sha512", "b");
	require("functions.php");
	
	//kui on juba sisse loginud siis suunan data lehele
	if (isset ($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location: data.php");
		exit();
		
	}
	
	
	
	
	//GET ja POSTi muutujad
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	//echo strlen("?);
	
	// MUUTUJAD
	$signupEmailError = "";
	$loginEmailError = "";
	$signupPasswordError = "";
	$loginPasswordError = "";
	$weightError= "";
	$signupEmail = "";
	$loginEmail = "";
	$ageError = "";
	
	$firstNameError = "";
	$lastNameError = "";
	$gender = "";
	$firstName = "";
	$lastName = "";
	$weight = "";
	$age = "";
	
	
	
	// on ??e olemas selline muutja
	if( isset( $_POST["signupEmail"] ) ){
		
		//jah on olemas
		//kas on t??
		if( empty( $_POST["signupEmail"] ) ){
			$signupEmailError = "See väli on kohustuslik";
		} else {
			// email olemas 
			$signupEmail = $_POST["signupEmail"];
		}
	} 
	
	if( isset( $_POST["firstName"] ) ){
		if( empty( $_POST["firstName"] ) ){
			$firstNameError = "See väli on kohustuslik";
		} else {
			// sisselogimise email olemas 
			$firstName = $_POST["firstName"];
		}
	}
	
	if( isset( $_POST["lastName"] ) ){
		if( empty( $_POST["lastName"] ) ){
			$lastNameError = "See väli on kohustuslik";
		} else { 
			$lastName = $_POST["lastName"];
		}
	}
	
	if(isset($_POST["weight"])){
		if(empty($_POST["weight"])){
		$weightError = "kohustuslik";
	}else{	
		$weight = $_POST["weight"];	
		}
	}
	
	if(isset($_POST["age"])){
		if(empty($_POST["age"])){
		$ageError = "kohustuslik";
	}else{	
		$age = $_POST["age"];	
		}
	}
	
	
	
	if( isset( $_POST["loginEmail"] ) ){
		//jah on olemas, kas on t??
		if( empty( $_POST["loginEmail"] ) ){
			$loginEmailError = "E-post on kohustuslik";
		} else {
			// sisselogimise email olemas 
			$loginEmail = $_POST["loginEmail"];
		}
	}
	
	
	if( isset( $_POST["signupPassword"] ) ){
		
		if( empty( $_POST["signupPassword"] ) ){
			
			$signupPasswordError = "Parool on kohustuslik";
			
		} else {
			
			// siia j?? siis kui parool oli olemas - isset
			// parool ei olnud t??-empty
			
			// kas parooli pikkus on v?sem kui 8 
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema v?malt 8 t?m?ki pikk";
			
			}
			
		}
		
	}
	if( isset( $_POST["loginPassword"] ) ){
		
		//jah on olemas, kas on t??
		if( empty( $_POST["loginPassword"] ) ){
			
			$loginPasswordError = "Salasõna on kohustuslik";
			
		} else {
			
			// kui password on olemas 
			$loginPassword = $_POST["loginPassword"];
			
		}
	}
	
	
	// GENDER
	if( isset( $_POST["gender"] ) ){
		if(empty( $_POST["gender"] ) ){
			$genderError = "";
			}else {
			$gender = $_POST["gender"];
		}
	} 
	
	// peab olema email ja parool
	// ??gi errorit
	
	if ( isset($_POST["signupEmail"]) && 
		 isset($_POST["signupPassword"]) && 
		 isset($_POST["firstName"]) &&
		 isset($_POST["lastName"]) &&
		 isset($_POST["weight"]) &&
		 isset($_POST["age"])&&
		 $signupEmailError == "" && 
		 empty($signupPasswordError) &&
		 empty($firstNameError)&&
		 empty($lastNameError)&&
		 empty($weightError)&&
		 empty($ageError)
		) {
		
		// salvestame ab'i
		echo "Salvestan... <br>";
		
		
		echo "email: ".$signupEmail."<br>";
		echo "password: ".$_POST["signupPassword"]."<br>";
		$password = hash("sha512", $_POST["signupPassword"]);
		echo "password hashed: ".$password."<br>";
		//echo $serverUsername;
		//kasutan funtionni
		$signupEmail = cleanInput($signupEmail);
		signUp($signupEmail, cleanInput($password),cleanInput($firstName), cleanInput($lastName), cleanInput($age), cleanInput($weight), cleanInput($gender));	
		
	}
	
	
	$error = "";
	if(isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) &&
		 !empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"])
		){
			$error = login(cleanInput($_POST["loginEmail"]), cleanInput($_POST["loginPassword"]));
			
			
		}
	
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Logi sisse või loo kasutaja</title>
</head>
<body>

	<h1>Logi sisse</h1>
	<form method="POST">
		<p style="color:red;"><?=$error;?></p>
		<label>E-post</label>
		<br>
		
		<input name="loginEmail" type="text" value="<?=$loginEmail;?>"> <?php  echo "<font color='red'>$loginEmailError</font>";?>
		
			<br><br>
			
			<input type="password" name="loginPassword" placeholder="Parool" > <?php echo "<font color = 'red'>$loginPasswordError</font>";?>
		
		<br><br>
		
		<input type="submit" value="Logi sisse">
		
		
	</form>
	
	
	<h1>Loo kasutaja</h1>
	<form method="POST">
		<label>E-post</label>
		<br>
		
		<input name="signupEmail" type="text" value="<?=$signupEmail;?>"> <?=$signupEmailError;?>
		<br>
		<br>
		
		<label>Parool</label>
		<br>
		<input type="password" name="signupPassword" placeholder="Parool"> <?php echo $signupPasswordError; ?>
		<br><br>
		
		<label> Eesnimi</label>
		<br>
		<input name="firstName" type="text" value= "<?=$firstName;?>"> <?php echo $firstNameError; ?>
		<br>
		<label> Perekonnanimi</label>
		<br>
		<input name="lastName" type="text" value= "<?=$lastName;?>"> <?php echo $lastNameError; ?>
		<br>
		<label>Vanus</label>
		<br>
		<input name="age" type="text" value= "<?=$age;?>"> <?php echo $ageError; ?>
		<br>
		<label>Kaal</label>
		<br>
		<input name="weight" type="text" value= "<?=$weight;?>"> <?php echo $weightError; ?>
		
		
		
		
		
		
		<br>
		<?php if($gender == "male") { ?>
			<input type="radio" name="gender" value="male" checked> Male<br>
		<?php }else { ?>
			<input type="radio" name="gender" value="male"> Male<br>
		<?php } ?>
		
		<?php if($gender == "female") { ?>
			<input type="radio" name="gender" value="female" checked> Female<br>
		<?php }else { ?>
			<input type="radio" name="gender" value="female"> Female<br>
		<?php } ?>
		
		<?php if($gender == "other") { ?>
			<input type="radio" name="gender" value="other" checked> Other<br>
		<?php }else { ?>
			<input type="radio" name="gender" value="other"> Other<br>
		<?php } ?>
		
		
		<br>
	
		
		
		<input type="submit" value="Loo kasutaja">
		
		
	</form>

</body>
</html>