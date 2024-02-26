<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn,"SELECT * FROM tb_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
	if ($row["uloga"] != 3) {
		header("Location: index.php");
	}
}
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>NadjiPoso</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
<title>Dodavanje korisnika</title>
<script type="text/javascript">
// Provera da li je argument unet ceo broj
function isInteger(val)
{
// Ako nije setovana, vrati false
if(val==null)
return false;
// duzina stringa nula, vrati false
if (val.length==0)
return false;
for (var i=0; i<val.length; i++)
{
var ch = val.charAt(i)
if (i == 0 && ch == "-")
continue;
if (ch < "0" || ch > "9")
return false;
}
return true;
}
// Validacija forme za unos
function validacija_submit() {
ime = document.getElementById("ime").value;
username = document.getElementById("username").value;
email = document.getElementById("email").value;
password = document.getElementById("password").value;
uloga = document.getElementById("uloga").value;
forma = document.getElementById("forma");
if (ime=="" || username=="" || uloga==""||email==""|| password=="") {
alert("Nije uneto zahtevano polje!");
return false;
}
if (!isInteger(uloga)||parseInt(uloga)<1||parseInt(uloga)>3) {
alert("Pogresna uloga!");
return false;
}
// manuelni submit forme
forma.submit();
}
</script>
</head>
<body>
<div id="header">
			<div class="logo">
			<a href="index.php"><img src="images/logo.png" alt="LOGO" height="30%" width="40%"></a>
			</div>
			<?php if($row["uloga"] == "1") : ?>
				<ul class="navigation">
				<li class="active">
					<a href="index.php">Početna</a>
				</li>
				<li>
					<a href="poslovi.php">Oglasi</a>
				</li>
				<li>
					<a href="profil.php">Moj Profil</a>
				</li>
				<li>
					<a href="logout.php">Odjavi se</a>
				</li>
			</ul>
			<?php elseif($row["uloga"] == "2") : ?>
				<ul class="navigation">
				<li class="active">
					<a href="index.php">Početna</a>
				</li>
				<li>
					<a href="poslovi.php">Oglasi</a>
				</li>
				<li>
					<a href="oglas.php">Okači oglas</a>
				</li>
				<li>
					<a href="profil.php">Moj Profil</a>
				</li>
				<li>
					<a href="logout.php">Odjavi se</a>
				</li>
			</ul>
			<?php elseif($row["uloga"] == "3") : ?>
				<ul class="navigation">
				<li class="active">
					<a href="index.php">Početna</a>
				</li>
				<li>
					<a href="poslovi.php">Oglasi</a>
				</li>
				<li>
					<a href="dashboard.php">Dashboard</a>
				</li>
				<li>
					<a href="logout.php">Odjavi se</a>
				</li>
			</ul>

			<?php else : ?>
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
			<?php endif; ?>

</div>

<div id="contents">
		
		<div class="clearfix">
			<div class="main">
			<h1>Dodavanje korisnika</h1>
			<form id="forma" action="<?php $_SERVER["PHP_SELF"] ?>" method="get">
			<label>ime:</label> <input id="ime" name="ime" type="text"size="20"><br />
			username: <input id="username" name="username" type="text" size="20"><br />
			email: <input id="email" name="email" type="text" size="10"><br />
			password: <input id="password" name="password" type="text" size="20"><br />
						<label for="kandidat">Kandidat</label>
						<input type="radio" name="uloga" id="uloga" required value="1">
						<label for="poslodavac">Poslodavac</label>
						<input type="radio" name="uloga" id="uloga" required value="2">
						<label for="admin">Admin</label>
						<input type="radio" name="uloga" id="uloga" required value="3"><br>
			<br><input type="button" value='Dodaj' onclick="validacija_submit()" id='dugme'/>
			&nbsp<a href="dashboard.php" id='dugme'>Dashboard</a>

			</form>
			<?php
			require_once 'reglog_db.php';
			if (isset ($_GET["ime"])) {
			$ime = $_GET["ime"];
			$username = $_GET["username"];
			$email = $_GET["email"];
			$password = $_GET["password"];
			$uloga = $_GET["uloga"];
			$reglog = new reglog_db();
			if ($reglog->dodaj($ime, $username,$email,$password, $uloga))
			echo "<p><strong>Korisnik je uspesno dodat</strong></p>";
			else
			echo "<p><strong>Korisnk nije uspesno dodat</strong></p>";
			}
			?>
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