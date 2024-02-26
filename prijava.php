<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn,"SELECT * FROM tb_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
	if ($row["uloga"] != 1) {
		header("Location: index.php");
	}
	if ($_GET['idoglasa'] == ""){
        header("Location: index.php");}
	require_once 'reglog_db.php';
	$reglog = new reglog_db();
	$podaci = $reglog->uzmi_podatke_o_oglasu($_GET['idoglasa']);
	if ($podaci==false){
		header("Location: index.php");
	}
	$prijaviose = $reglog->imaprijavu($id,$_GET['idoglasa']);
	if($prijaviose == 0){
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
<title>Prijava na oglas</title>
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
return true
}

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
// Validacija forme za unos
function validacija_submit() {
cv = document.getElementById("cv").value;
datum_rodjenja = document.getElementById("datum_rodjenja").value;
sprema = document.getElementById("sprema").value;
iskustvo = document.getElementById("iskustvo").value;
validan = isValidDate(datum_rodjenja);
forma = document.getElementById("forma");
if (cv=="" || datum_rodjenja=="" || sprema==""|| iskustvo=="") {
alert("Nije uneto zahtevano polje!");
<?php $idoglasa = $_GET['idoglasa']; 
?>
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
				<h1>Prijava na oglas</h1>
<?php

require_once 'reglog_db.php';
$reglog = new reglog_db();
// Asocijativni niz sa podacima o knjizi "id"
//$podaci = $reglog->uzmi_podatke_o_oglasu($_GET["id"]);
?>
<!-- Ne prikazuj formu ako treba da se obrade podaci -->
<div class="main"><form id="forma" action="<?php $_SERVER["PHP_SELF"] ?>" method="get">
				<input id="idoglasa" name="idoglasa" type="hidden" value="<?php echo $idoglasa?>">
                <?php /*echo "<h2>Prijava na oglas će biti poslata u ime korisnika ".$ime. ".</h2>" */?> 
				Vaš CV (curriculum vitae): <input id="cv" name="cv" type="text" size="10"><br />
				Datum rođenja: <input id="datum_rodjenja" name="datum_rodjenja" type="textarea" size="10"><br />
				Stručna sprema: <input id="sprema" name="sprema" type="text" size="10"><br />
                Prethodno radno iskustvo: <input id="iskustvo" name="iskustvo" type="text" size="10"><br /><br>
				<input type="button" value='Pošalji prijavu' id='dugme' onclick="validacija_submit()"/>
				</form></div>
<?php
 // zatvoren gornji if
if (isset ($_GET["cv"])) {
	$cv = $_GET["cv"];
	$datum_rodjenja = $_GET["datum_rodjenja"];
	$sprema = $_GET["sprema"];
	$iskustvo = $_GET["iskustvo"];
	$reglog = new reglog_db();
	if ($reglog->dodajprijavu($cv, $datum_rodjenja,$sprema,$iskustvo, intval($idoglasa),intval($id)))
	echo "<p><strong>Prijava uspesno poslata</strong></p>";
	else
	echo "<p><strong>Prijava nije uspesno poslata</strong></p>";
}
?>
<br><a href="poslovi.php" style=" background-color: #4e5944;border: none;color: white;padding: 10px 25px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;border-radius: 8px;">Vrati se</a>
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
