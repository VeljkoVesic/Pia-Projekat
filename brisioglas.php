<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn,"SELECT * FROM tb_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
	if ($row["uloga"] != 2) {
		header("Location: index.php");
	}
    if($_GET['id'] == ""){
        header('Location: index.php');
    }
    require_once 'reglog_db.php';
    $reglog = new reglog_db();
    $podaci = $reglog->uzmi_podatke_o_oglasu($_GET['id']);
    if ($podaci==false || $podaci['kandidat'] != $_GET['id']){
        header("Location: index.php");
    }
}
?>

<html>
<head>
<title>Brisanje oglasa</title>
</head>
<body>
<h1>Brisanje oglasa</h1>
<?php
require_once 'reglog_db.php';
$id = $_GET["id"];
$reglog = new reglog_db();


if ($reglog->brisioglas($id))

echo "Oglas uspesno obrisan.";
else
echo "Doslo je do greske u brisanju.";
?>
<br><p><a href="profil.php" style=" background-color: #4e5944;border: none;color: white;padding: 10px 25px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;border-radius: 8px;">Vrati se</a></p>
</body>
</html>