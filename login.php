<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    header("Location: index.php");
}   

if(isset($_POST["submit"])){
    $usernameemail = $_POST["usernameemail"];
    $password = $_POST["password"];
    $result = mysqli_query($conn,"SELECT * FROM tb_user WHERE username = '$usernameemail' OR email = '$usernameemail'");
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)>0){
        if($password == $row["password"]){
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: index.php");
        }
        else{
            echo "<script> alert('Netačna lozinka');</script>";
    
        }
    }
    else{
        echo "<script> alert('Ne postoji korisnik sa tim username/email-om');</script>";

    }

}
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>NadjiPoso</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>

<div id="header">
			<div class="logo">
			<a href="index.php"><img src="images/logo.png" alt="LOGO" height="30%" width="40%"></a>
			</div>
			<ul class="navigation">
				<li class="active">
					<a href="index.php">Početna</a>
				</li>
				<li>
					<a href="poslovi.php">Oglasi</a>
				</li>
				<li>
					<a href="login.php">Prijavi se</a>
				</li>
			</ul>

</div>


	<div id="contents">
		<div class="clearfix">
			<div class="main">
				<h1>Prijavi se</h1>
				<form class="" action="" method="post" autocomplete="off">
					<label for="usernameemail">Username ili Email</label>
					<input type="text" name="usernameemail" id="usernameemail" required value=""> <br>
					<label for="password">Lozinka</label>
					<input type="password" name="password" id="password" required value=""> <br>
					<button type="submit" name="submit" id='dugme'>Prijavi se</button>
				</form>
                  <br><div class="signup-link">
                     <h2>Niste član?</h2><a href="registration.php" id='dugme' >Registrujte se sad!</a>
                  </div>
		</div>
	</div>
	<div id="footer">
		<div class="clearfix">
			<div class="section">
				<h4>Poslodavci</h4>
				<p>Ovaj vebsajt je jako koristan za sve poslodavce kojima su potrebni entuzijastični radnici za njihov biznis.</p>
			</div>
			<div class="section">
				<h4>Kandidati</h4>
				<p>Ovaj vebsajt je takođe izuzetno koristan za ljude koji žele da pronađu idealnu poziciju za svoj novi posao.</p>
			</div>
			<div class="section">
				<h4>Naša poruka</h4>
				<p>Molimo i kandidate i poslodavce na ovoj platformi da se ponašaju korektno jedni prema drugima, jer bi svaka neprijatnost bila sankcionisana brisanjem naloga.</p>
			</div>
		</div>
		<div id="footnote">
			<div class="clearfix">
				<p>nadjiposo © 2023</p>
			</div>
		</div>
	</div>
</body>
</html>