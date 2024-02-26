<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn,"SELECT * FROM tb_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    $idoglasa = $_GET['idoglasa'];
    if ($idoglasa == ""){
        header("Location: index.php");
    }
    require_once 'reglog_db.php';
    $reglog = new reglog_db();
    $podaci = $reglog->uzmi_podatke_o_oglasu($idoglasa);
    if ($podaci==false){
        header("Location: index.php");
    }
               
              
}
elseif ($row["uloga"] != 2) {
	header("Location: index.php");
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
	<script type="text/javascript">
// Validacija forme za unos

function isValidDate(date) {
    var parts = date.split(".");
    var day = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10);
    var year = parseInt(parts[2], 10);
	var daniumesecu = [31,28,31,30,31,30,31,31,30,31,30,31];
	if(day>=0 && day<32 && month > 0 && month <13 && year > 1900 && year < 2100 && daniumesecu[month+1]>=day ){
		return true;
	}
	return false;

}





function validacija_submit() {
naslov = document.getElementById("naslov").value;
lokacija = document.getElementById("lokacija").value;
sprema = document.getElementById("sprema").value;
opis = document.getElementById("opis").value;
rok = document.getElementById("rok").value;
validan = isValidDate(rok);
forma = document.getElementById("forma");
if (naslov=="" || lokacija=="" || sprema==""|| opis=="" || rok =="") {
alert("Nije uneto zahtevano polje!");
return false;
}
if(validan==false){
	alert("Nepravilan datum!");
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
				<h1>Izmeni oglas</h1>
				<form id="forma" action="<?php $_SERVER["PHP_SELF"] ?>" method="get">
            	<?php 
                require_once 'reglog_db.php';
                $reglog = new reglog_db();
                $podaci = $reglog->uzmi_podatke_o_oglasu($idoglasa);
               
                ?>
                <input id="idoglasa" name="idoglasa" type="hidden" value="<?php echo $idoglasa?>">
				<label>Naziv oglasa:</label> <input id="naslov" name="naslov" type="text" size="20"value="<?php echo $podaci['naslov']?>"><br />
				Lokacija: <input id="lokacija" name="lokacija" type="text" size="20"value="<?php echo $podaci['lokacija']?>"><br />
				Stručna sprema: <input id="sprema" name="sprema" type="text" size="10"value="<?php echo $podaci['sprema']?>"><br />
				Opis oglasa: <input id="opis" name="opis" type="textarea" size="10"value="<?php echo $podaci['opis']?>"><br />
				Rok za prijavu: <input id="rok" name="rok" type="text" size="10" value="<?php echo $podaci['rok']?>"><br />
				<br><input type="button" value='Izmeni oglas' onclick="validacija_submit()" id='dugme'/>
				</form>
				<?php
				require_once 'reglog_db.php';
				if (isset ($_GET["naslov"])) {
				$naslov = $_GET["naslov"];
				$lokacija = $_GET["lokacija"];
				$sprema = $_GET["sprema"];
				$opis = $_GET["opis"];
				$rok = $_GET["rok"];

				$reglog = new reglog_db();
				if ($reglog->izmenioglas($idoglasa,$naslov, $lokacija,$sprema,$opis, $rok,$id))
				echo "<p><strong>Oglas uspesno izmenjen</strong></p>";
				else
				echo "<p><strong>Oglas nije uspesno izmenjen</strong></p>";
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