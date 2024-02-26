<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    header("Location: index.php");
}



if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $uloga = $_POST["uloga"];
    $duplicate = mysqli_query($conn,"SELECT * FROM tb_user WHERE username = '$username' OR email = '$email'");
    if(mysqli_num_rows($duplicate) > 0){
    echo "<script> alert('Traženo korisničko ime ili email je već zauzeto');</script>";}
    else{
        if($password == $confirmpassword){
            $query = "INSERT INTO tb_user(id, name, username, email, password,uloga) VALUES (NULL,'$name','$username','$email','$password','$uloga')";
            mysqli_query($conn,$query);
            echo "<script> alert('Uspešno ste se registrovali! Možete da se prijavite.');</script>";
        }
        else{
            echo "<script>alert('Lozinke se ne podudaraju');</script>";
        }
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
				<h1>Postanite nas član</h1>
				<p>Postanite član najboljeg sajta u Srbiji za oglašavanje konkursa za posao, kao i za pronalaženje pozicija za širok spektar poslova. Registruj se danas kao poslodavac ili kandidat!</p>
                <form class="" action="" method="post" autocomplete="off">
			<label for="name">Ime: </label>
			<input type="text" name="name" id="name" required value=""><br>
			<label for="username">Username: </label>
			<input type="text" name="username" id="username" required value=""><br>
			<label for="email">Email: </label>
			<input type="text" name="email" id="email" required value=""><br>
			<label for="password">Lozinka: </label>
			<input type="password" name="password" id="password" required value="" ><br>
			<label for="confirmpassword">Potvrdi lozinku: </label>
			<input type="password" name="confirmpassword" id="confirmpassword" required value=""><br>
			<label for="kandidat">Kandidat</label>
			<input type="radio" name="uloga" id="uloga" required value="1">
			<label for="poslodavac">Poslodavac</label>
			<input type="radio" name="uloga" id="uloga" required value="2"><br><br>
			<button type="submit" name="submit" id="dugme">Registruj se</button><br>
			<br><div class="signup-link">
                <h2>Već imate nalog?</h2><a href="login.php" id='dugme'>Prijavite se!</a>
            </div>
</div>	
		</form>
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