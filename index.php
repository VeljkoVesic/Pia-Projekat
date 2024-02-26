<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn,"SELECT * FROM tb_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
}
else{
    header("Location: login.php");
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
		<div class="highlight">
			<div class="clearfix">
				<div class="testimonial">
					<h2>Pitaš se ko smo mi?</h2>
					<p>
					Mi smo dva studenata Fakulteta Inženjerskih Nauka iz Kragujevca koja su odlučila da znanje stečeno na fakultetu (prevashodno predmet Programiranje Internet Aplikacija) sprovedu u jedan koristan projekat. 
					</p>
				</div>
				<h1>Dobro došli, <?php echo $row["name"] ?>!</h1></h1>
				<p>
				Jako nam je drago što koristiš našu platformu! Mi smo jedan od giganata na srpskom tržištu, kada je reč o vebsajtovima koji se bave oglašavanjem konkursa za različite poslove!
				</p>
			</div>
		</div>
		<div class="featured">
			<h2>Sa kim mi sarađujemo?</h2>
			<ul class="clearfix">
				<li>
					<div class="frame">
						<div class="box">
							<img src="images/slika1" alt="Img" height="130" width="197">
						</div>
					</div>
					<p>
						<b>Sample4</b>
					</p>
				</li>
				<li>
					<div class="frame">
						<div class="box">
							<img src="images/slika2" alt="Img" height="130" width="197">
						</div>
					</div>
					<p>
						<b>Sample2</b>
					</p>
				</li>
				<li>
					<div class="frame">
						<div class="box">
							<img src="images/slika3" alt="Img" height="130" width="197">
						</div>
					</div>
					<p>
						<b>Sample3</b>
					</p>
				</li>
				<li>
					<div class="frame">
						<div class="box">
							<img src="images/slika4" alt="Img" height="130" width="197">
						</div>
					</div>
					<p>
						<b>Sample4</b>
					</p>
				</li>
			</ul>
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