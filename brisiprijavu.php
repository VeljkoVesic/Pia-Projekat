<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn,"SELECT * FROM tb_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
	if ($row["uloga"] != 1) {
		header("Location: index.php");
	}
    if($_GET['id'] == ""){
        header('Location: index.php');
    }
    require_once 'reglog_db.php';
    $reglog = new reglog_db();
    $podaci = $reglog->uzmi_podatke_o_prijavi($_GET['id']);
    if ($podaci==false || $podaci['kandidat'] != $_GET['id']){
        header("Location: index.php");
    }
}
?>

<html>
<head>
<title>Brisanje prijave</title>
</head>
<body>
<h1>Brisanje prijave</h1>
<?php
require_once 'reglog_db.php';
$id = $_GET["id"];
$reglog = new reglog_db();


if ($reglog->brisiprijavu($id))

echo "Prijava uspesno obrisana.";
else
echo "Doslo je do greske u brisanju.";
?>
<br><p><a href="profil.php" id='dugme'>Vrati se</a></p>
</body>
</html>