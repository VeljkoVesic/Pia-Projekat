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
	<script type="text/javascript">
		// Funkcija od korsinka trazi potvrdu brisanja
		function brisi(id_korisnik) {
		var odgovor=confirm("Brisanje korisnika: Da li ste sigurni?");
		if (odgovor)
		window.location = "brisi.php?id="+id_korisnik;
		}
		// Funkcija reaguje na pritisak na dugme "izmeni" i
		// usmerava browser na php skript za izmenu podataka o knjizi
		function izmeni(id_korisnik) {
		window.location = "izmeni.php?id="+id_korisnik;
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
				<li>
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
			<div class="sidebar">
				<div>
					<h2>Dashboard</h2>
				</div>
			</div>
			<div class="main">
				<h1>Upravljaj korisnicima</h1>
				<!-- Forma za pretragu -->
				<form action="<?php $_SERVER["PHP_SELF"] ?>" method="get">
					<input id="pretraga" name="pretraga" type="text"/>
					<input type="submit" id='dugme' value="Traži" />
					</form>
					<!-- Kraj forme za pretragu -->
					<?php
					require_once 'reglog_db.php';
					$reglog = new reglog_db();
					// Ako je setovano $_GET['pretraga'], postavi kriterijum za filtriranje.
					// Ako je vrednost "pretraga", filtiranje se ne vrsi
					if (!isset ($_GET['pretraga']) || $_GET['pretraga']=='pretraga') {
					$reglog->stampaj_tabelu_korisnika();
					}
					else {
					$kriterijum_za_naslov = $_GET['pretraga'];
					$reglog->stampaj_tabelu_korisnika($kriterijum_za_naslov);
					}
					?>
					<!-- Kratka forma koja vodi na stranicu dodaj.php -->
					<form action="dodaj.php" method="get">
					<br><input id='dugme' type="submit" value="Dodaj">
				</form>
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