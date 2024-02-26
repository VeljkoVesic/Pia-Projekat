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

<html>
<head>
<title>Brisanje korisnika</title>
</head>
<body>
<h1>Brisanje korisnika</h1>
<?php
require_once 'reglog_db.php';
$id = $_GET["id"];
$reglog = new reglog_db();
header("Location: dashboard.php");
if ($reglog->brisi($id))

echo "Korisnik uspesno obrisan.";
else
echo "Doslo je do greske u brisanju.";
?>
<br><p><a href="dashboard.php" class="button" style=" background-color: #4e5944;border: none;color: white;padding: 10px 25px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;border-radius: 8px;">Vrati se</a></br>
</body>
</html>