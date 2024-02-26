<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn,"SELECT * FROM tb_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
	if ($row["uloga"] != 2) {
		header("Location: index.php");
	}
	require_once 'reglog_db.php';
	$reglog = new reglog_db();
	if($reglog->imafirmu($id) == 0){
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
<title>Registrovanje firme</title>
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
ime_firme = document.getElementById("ime_firme").value;
if (ime_firme=="") {
alert("Nije uneto zahtevano polje!");
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
            <h1>Dodavanje firme</h1>
<form id="forma" action="<?php $_SERVER["PHP_SELF"] ?>" method="get">
<input id="id" name="id" type="hidden" size="20" value="<?php echo $_SESSION['id']?>">
Daj ime svojoj firmi (nakon dodavanja neces moci da izmenis ime): <input id="ime_firme" name="ime_firme" type="text" size="20" ><br />
<input type="button" value='Dodaj' id='dugme' onclick="validacija_submit()"/>
&nbsp<a href="profil.php" id='dugme'>Moj Profil</a>

</form>
<?php
require_once 'reglog_db.php';
if (isset ($_GET["ime_firme"])) {
$ime_firme = $_GET["ime_firme"];
$reglog = new reglog_db();
if ($reglog->dodajfirmu($ime_firme, $id))
echo "<p><strong>Firma je uspesno dodata</strong></p>";
else
echo "<p><strong>Firma nije uspesno dodata</strong></p>";
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