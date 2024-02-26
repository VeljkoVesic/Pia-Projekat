<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn,"SELECT * FROM tb_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
}
else{
    header("Location: login.php");
} ?>


<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>NadjiPoso</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script src="js/jspdf.min.js"></script>

	<script type="text/javascript">

function preuzmiprijave() {
    var specialElementHandlers = {
        '#editor': function (element, renderer) {
            return true;}};
    var div = document.getElementById("prijave");
    var pdf = new jsPDF();
    pdf.setProperties({
        title: "Prijave",
        subject: "Lista prijava",
    });
    var margins = {
        top: 15,
        bottom: 15,
        left: 15,
        width: 170
    };
    pdf.fromHTML(div, margins.left, margins.top, {
        'width': margins.width,
        'elementHandlers': specialElementHandlers,
		'fontSize': 4,
		'font': "Arial",
        'pagesplit': true
    });
    pdf.save("prijave.pdf");
}




// Funkcija od korsinka trazi potvrdu brisanja
function brisioglas(id_oglas) {
		var odgovor=confirm("Brisanje oglasa: Da li ste sigurni?");
		if (odgovor)
		window.location = "brisioglas.php?id="+id_oglas;
		}
function brisiprijavu(id_prijave) {
		var odgovor=confirm("Otkazivanje prijave: Da li ste sigurni?");
		if (odgovor)
		window.location = "brisiprijavu.php?id="+id_prijave;
		}
		
		// Funkcija reaguje na pritisak na dugme "izmeni" i
		// usmerava browser na php skript za izmenu podataka o knjizi
function izmenioglas(id_oglas) {
		window.location = "izmenioglas.php?idoglasa="+id_oglas;
		}

function dodajfirmu(id) {
		window.location = "mojafirma.php?id="+id;
		}

function prikazikomentare() {
			var div = document.getElementById("komentari");
			if (div.style.display === "block") {
			document.getElementById('openkom').innerHTML = 'Pogledaj komentare i ocene';
    		div.style.display = "none";} 
			else {
    		div.style.display = "block";
			document.getElementById('openkom').innerHTML = 'Zatvori komentare i ocene';
		}}

		
function prikaziprijave() {
			var div = document.getElementById("prijave");
			if (div.style.display === "block") {
			document.getElementById('openprij').innerHTML = 'Pogledaj prijave';
    		div.style.display = "none";} 
			else {
			document.getElementById('openprij').innerHTML = 'Zatvori prijave';
    		div.style.display = "block";}
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
					<a href="oglas.php">Okaci Oglas</a>
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
					<h2>Moj Profil</h2>
						<img src="images/avatar.png" alt="Img" height="320" width="305">
						<br>						
						<?php if ($row['uloga'] == 2) { ?>
							<?php if ($row['uloga'] == 2) { ?>
							<p  id='dugme' onclick='dodajfirmu(<?php echo $_SESSION["id"] ?>)'>Prijavi firmu</p>
							<br>
							<?php } ?>
        					<br><p id='openkom' onclick="prikazikomentare()">Pogledaj komentare i ocene</p>
							<div id='komentari' style="display:none">
							<br>
							<?php 		
							require_once 'reglog_db.php';
							$reglog = new reglog_db(); 
							$reglog->listaj_komentare($_SESSION['id']);?>
							</div>
							<br><br><p id='openprij' onclick="prikaziprijave()">Pogledaj prijave</p>
							<div id='prijave' style='display:none'>
							<br>
							<?php 		
							require_once 'reglog_db.php';
							$reglog = new reglog_db(); 
							$reglog->listaj_ko_se_prijavio($_SESSION['id']);?>
							&nbsp<button id='uzmiprijave' onclick='preuzmiprijave()' >Preuzmi podatke o prijavama</button><hr>

							</div>
							

						<?php } ?>

				</div>
			</div>
			<?php if($row["uloga"] == "2") : ?>			
				<div class="main">
				<h1 >Moji oglasi</h1>
				<div>
				<br>
			<?php
					require_once 'reglog_db.php';
					$reglog = new reglog_db();
					// Ako je setovano $_GET['pretraga'], postavi kriterijum za filtriranje.
					// Ako je vrednost "pretraga", filtiranje se ne vrsi
					//$kriterijum_za_naslov =  $row["id"];
					//$reglog->listaj_oglase($kriterijum_za_naslov);
					$reglog->listaj_oglase($id);
					?>
					</div>
			

			</div>

			<?php elseif($row["uloga"] == "1") : ?>
				<div class="main">
				<?php require_once 'reglog_db.php';
				$reglog = new reglog_db();
				$reglog->listaj_prijave($id);

				?>
				<div>
				</div>
			<?php else : ?>
			<!-- html kod -->
			<?php endif; ?>
			<!-- html kod -->

			
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