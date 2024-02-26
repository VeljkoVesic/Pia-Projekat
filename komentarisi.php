<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn,"SELECT * FROM tb_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
	if ($row["uloga"] != 1) {
		header("Location: index.php");
	}
    $idposlodavca = $_GET['idposlodavca'];
    if ($idposlodavca == ""){
        header("Location: index.php");
    }
    require_once 'reglog_db.php';
    $reglog = new reglog_db();
    $podaci = $reglog->uzmi_podatke_o_korisniku($idposlodavca);
    if ($podaci==false){
        header("Location: index.php");
    }
}
?>

<html>
<head>
<title>Dodavanje komentara</title>
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
sadrzaj = document.getElementById("sadrzaj").value;
ocena = document.getElementById("ocena").value;

if (sadrzaj=="" || ocena=="") {
alert("Nije uneto zahtevano polje!");
return false;
}
if (!isInteger(ocena)||parseInt(ocena)<1||parseInt(ocena)>5) {
alert("Pogresna ocena!");
return false;
}
<?php $idposlodavca = $_GET["idposlodavca"];?>

// manuelni submit forme
forma.submit();

}
</script>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>NadjiPoso</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script type="text/javascript">
// Validacija forme za unos
function validacija_submit() {
sadrzaj = document.getElementById("sadrzaj").value;
ocena = document.getElementById("ocena").value;

if (sadrzaj=="" || ocena=="") {
alert("Nije uneto zahtevano polje!");
return false;
}
if (!isInteger(ocena)||parseInt(ocena)<1||parseInt(ocena)>5) {
alert("Pogresna ocena!");
return false;
}
<?php $idposlodavca = $_GET["idposlodavca"];?>

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
            <h1>Dodavanje komentara</h1>
<form id="forma" action="<?php $_SERVER["PHP_SELF"] ?>" method="get">
<input id="idposlodavca" name="idposlodavca" type="hidden" value="<?php echo $idposlodavca?>">
Sadžaj komentara: <input id="sadrzaj" name="sadrzaj" type="text" size="20"><br />
<br>Ocena:       <label for="ocena">1</label>
			<input type="radio" name="ocena" id="ocena" required value="1">
			<label for="poslodavac">2</label>
			<input type="radio" name="ocena" id="ocena" required value="2">
            <label for="ocena">3</label>
			<input type="radio" name="ocena" id="ocena" required value="3">
            <label for="ocena">4</label>
			<input type="radio" name="ocena" id="ocena" required value="4">
            <label for="ocena">5</label>
			<input type="radio" name="ocena" id="ocena" required value="5"><br><br>
<input type="button" value='Dodaj' onclick="validacija_submit()" id='dugme'/>
<a href="poslovi.php" id='dugme'>Vrati se</a>
</form>
<?php
require_once 'reglog_db.php';
if (isset($_GET["ocena"])) {
    $sadrzaj = $_GET["sadrzaj"];
    $ocena = $_GET["ocena"];
    $reglog = new reglog_db();
    if ($ocena < 6 && $ocena > 0) {
        if ($reglog->dodajkomentar($sadrzaj, $ocena, intval($id), intval($idposlodavca)))
            echo "<p><strong>Komentar je uspešno dodat</strong></p>";
        else
            echo "<p><strong>Komentar nije uspešno dodat</strong></p>";
    }
    else{
        echo '<script type="text/javascript">validacija_submit();</script>';
    }
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