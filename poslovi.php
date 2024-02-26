<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn,"SELECT * FROM tb_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
}
else{
	$row["uloga"] = "0";
} ?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>NadjiPoso</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script type="text/javascript">
		// Funkcija od korsinka trazi potvrdu brisanja
		function brisioglas(id_oglas) {
		var odgovor=confirm("Brisanje oglasa: Da li ste sigurni?");
		if (odgovor)
		window.location = "brisioglas.php?id="+id_oglas;
		
		}
		// Funkcija reaguje na pritisak na dugme "izmeni" i
		// usmerava browser na php skript za izmenu podataka o knjizi
		function izmenioglas(id_oglas) {
		window.location = "izmenioglas.php?idoglasa="+id_oglas;
		}
		function prijavise(id_oglas){
			window.location = "prijava.php?idoglasa="+id_oglas;
		}
		function komentarisi(id){
			window.location = "komentarisi.php?idposlodavca="+id;
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
			<div class="sidebar">
				<div>
					<h2>Istražuj</h2>
					<p>Došao si na pravo mesto. Ovde možeš pronaći na hiljade različitih oglasa iz svih mogućih polja delatnosti. Oglase možeš pretražiti po firmi,stručnoj spremi, lokaciji ili prosto nazivu!</p>
	
				</div>
			</div>
			<div class="main">
				<h1>Oglasi</h1>
				<form action="<?php $_SERVER["PHP_SELF"] ?>" method="get">
					<input id="pretraga" name="pretraga" type="text" size="20" />
					<input type="submit" value="Traži" id='dugme' />
					</form>
				<?php
					require_once 'reglog_db.php';
					$reglog = new reglog_db();
					// Ako je setovano $_GET['pretraga'], postavi kriterijum za filtriranje.
					// Ako je vrednost "pretraga", filtiranje se ne vrsi
					if (!isset ($_GET['pretraga']) || $_GET['pretraga']=='pretraga') {
					$reglog->listaj_oglase();
					}
					else {
					$kriterijum_za_naslov = $_GET['pretraga'];
					$reglog->listaj_oglase($kriterijum_za_naslov);
					}
					?>
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