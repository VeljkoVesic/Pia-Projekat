<?php
/*
* Klasa za CRUD operacije nad tabelom "tb_user"
*/
class reglog_db {
// Konstante
const name_hosta = 'localhost';
const korisnik = 'root';
const sifra = '';
const name_baze = "reglog";
// Atributi
private $dbh; // konekcija prema bazi
// Metode
// Zadatak konstruktora je otvaranje konekcije prema bazi
function __construct() {
try {
$konekcioni_string =
"mysql:host=".self::name_hosta.";dbname=".self::name_baze;
$this->dbh = new PDO($konekcioni_string, self::korisnik, self::sifra);
}
catch(PDOException $e) {
echo "GRESKA: ";
echo $e->getMessage();
}
}
// Zadatak destruktora je zatvaranje konekcije prema bazi
function __destruct() {
$this->dbh = null;
}
/**
* Metoda koja stampa tabelu tb_user po kriterijumu pretrage za name
* ukoliko je kriterijum zadat.
*/
public function stampaj_tabelu_korisnika($name_kriterijum=NULL) {
        try {
            $sql = "SELECT id, name, username, uloga, email, password FROM tb_user";
            // Ako je zadat kriterijum dodaj ga u upit
            if (isset($name_kriterijum)) {
                $sql .= " WHERE name LIKE '%$name_kriterijum%'";
            }
            $pdo_izraz = $this->dbh->query($sql);
            $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            echo "<table cellpadding='2' border='1' >";
            echo "<tr><th>Ime</th><th>Username</th><th>Email</th><th>Lozinka</th><th>Uloga</th><th
colspan='2'>Operacije</th></tr>";
            foreach ($niz as $tb_user) {
                if ($tb_user['uloga'] != 3) {
                    echo "<tr><td><b>" . $tb_user['name'] . "</b></td>";
                    echo "<td>" . $tb_user['username'] . "</td>";
                    echo "<td>" . $tb_user['email'] . "</td>";
                    echo "<td>" . $tb_user['password'] . "</td>";
                    echo "<td>" . $tb_user['uloga'] . "</td>";
                    echo "<td><input type='button' class='dugme' id='" . $tb_user['id'] . "' value='Obriši'
onclick='brisi(this.id)'></td>";
                    echo "<td><input type='button' class='dugme' id='" . $tb_user['id'] . "' value='Izmeni'
onclick='izmeni(this.id)'></td></tr>";
                }
                
            }
            echo "</table>";
        }
catch(PDOException $e) {
echo "GRESKA: ";
echo $e->getMessage();
}
}


public function imaprijavu($id,$idoglasa){
    $pomocni = "SELECT * FROM prijava WHERE kandidat = '$id' AND oglas = '$idoglasa' ";
	$pomocni_izraz = $this->dbh->query($pomocni);
	$rezultat = $pomocni_izraz->fetch(PDO::FETCH_ASSOC);

    if ($rezultat==false){
        return 1;
    }
    else{
        return 0;
    }
}


public function imafirmu($id){
    $pomocni = "SELECT * FROM firma WHERE vlasnik = '$id'";
	$pomocni_izraz = $this->dbh->query($pomocni);
	$rezultat = $pomocni_izraz->fetch(PDO::FETCH_ASSOC);
    if ($rezultat==false){
        return 1;
    }
    else{
        return 0;
    }
}


public function listaj_komentare($id){
    $sql = "SELECT * FROM komentar WHERE poslodavac = $id";
    $pdo_izraz = $this->dbh->query($sql);
    $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
    echo "<ul class='news'>";
    if (count($niz) == 0) {
        echo "<p>Niko Vas nije komentarisao/ocenio.</p>";
    }
    else {
        foreach($niz as $komentar){
            $komentator = $komentar['kandidat'];
            $sql2 =  "SELECT * FROM tb_user WHERE id = $komentator";
            $pdo_izraz2 = $this->dbh->query($sql2);
            $korisnik = $pdo_izraz2->fetch(PDO::FETCH_ASSOC);
            echo "<p>Korisnik '".$korisnik['username']."' kaze:</p>";
            echo "<p>".$komentar['sadrzaj']."</p>";
            echo "<p>Ocena koju ste dobili: ".$komentar['ocena']."</p>";
            echo "<hr>";
        }
    }
}

public function listaj_ko_se_prijavio($id){
    
    $sql = "SELECT * FROM prijava WHERE oglas IN (SELECT id FROM oglasi WHERE poslodavac = $id)";
    $pdo_izraz = $this->dbh->query($sql);
    $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
    echo "<ul class='news'>";
    if (count($niz) == 0) {
        echo "<p>Niko se nije prijavio na vaše oglase.</p>";
    }
    else {
        foreach($niz as $prijava){
            $kandidat = $prijava['kandidat'];
            $sql2 =  "SELECT * FROM tb_user WHERE id = $kandidat";
            $pdo_izraz2 = $this->dbh->query($sql2);
            $ime_kandidata = $pdo_izraz2->fetch(PDO::FETCH_ASSOC);
            echo "<p>Kandidat: '".$ime_kandidata['name']."'</p>";
            echo "<p>Kontakt: '".$ime_kandidata['email']."'</p>";
            echo "<p>Rodjen: ".$prijava['datum_rodjenja']."</p>";
            echo "<p>CV: ".$prijava['cv']."</p>";
            echo "<p>Sprema: ".$prijava['sprema']."</p>";
            echo "<p>Iskustvo: ".$prijava['iskustvo']."</p>";
            echo "<hr>";
        }
    }
}



public function listaj_prijave($id) {
    try {
        $sql = "SELECT oglas, id FROM prijava WHERE kandidat = $id";
        $pdo_izraz = $this->dbh->query($sql);
        $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
        echo "<ul class='news'>";
        if (count($niz) == 0) {
            echo "<h2>Niste se prijavili na nijedan oglas.</h2>";
        }
        else {
            $oglasi = array();
            foreach($niz as $prijava) {
                $oglasi[] = $prijava['oglas'];
            }
            $oglasi = implode(",", $oglasi);
            $sql2 = "SELECT id, naslov, lokacija, sprema, opis, rok, poslodavac FROM oglasi WHERE id IN ($oglasi)";
            $pdo_izraz = $this->dbh->query($sql2);
            $niz2 = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            foreach($niz2 as $key => $oglas){
                $trenutniposlodavac = $oglas['poslodavac'];
                $pomocni = "SELECT * FROM firma WHERE vlasnik = '$trenutniposlodavac'";
                $pomocni_izraz = $this->dbh->query($pomocni);
                $rezultat = $pomocni_izraz->fetch(PDO::FETCH_ASSOC);
                if($rezultat == false){
                    $imefirme = 'Privatno';
                }
                else{
                $imefirme = $rezultat['ime_firme'];
                }
                
                echo "<p>Prijavili ste se na oglas: <p>";
                echo "<p>Firma: ".$imefirme."</p>";
                echo "<li><h2>" . $oglas['naslov'] . "</h2>";
                echo "<p> Mesto: " . $oglas['lokacija'] . "</p>";
                echo "<p> Opis: " . $oglas['opis'] . "</p>"; 
                echo "<p> Školska sprema: " . $oglas['sprema'] . "</p>";
                echo "<p> Rok prijave: " . $oglas['rok'] . "</p></li>";
                echo "&nbsp<input class='dugme' type='button' id='" . $niz[$key]['id'] . "' value='Otkaži' onclick='brisiprijavu(this.id)'> ";
                echo "<hr>";
            }
            echo "</ul>";

                }
                } catch(PDOException $e) {
                echo "GRESKA: " . $e->getMessage();
                }
                }




                
                



public function listaj_oglase($naslov_kriterijum=NULL) {
    try {
        require 'config.php';
        $sql = "SELECT oglasi.id, oglasi.naslov, oglasi.lokacija, oglasi.sprema, oglasi.opis, oglasi.rok, oglasi.poslodavac FROM oglasi ";
        if (isset($naslov_kriterijum)) {
            $sql .= "JOIN firma ON oglasi.poslodavac = firma.vlasnik WHERE (oglasi.naslov LIKE '%$naslov_kriterijum%' OR oglasi.poslodavac LIKE '%$naslov_kriterijum%' OR oglasi.sprema LIKE '%$naslov_kriterijum%' OR oglasi.lokacija LIKE '%$naslov_kriterijum%' OR firma.ime_firme LIKE '%$naslov_kriterijum%')";
        }
        $role = 0;
        $pdo_izraz = $this->dbh->query($sql);
        $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            if (!empty($_SESSION["id"])) {
                $id = $_SESSION["id"];
                $result = mysqli_query($conn,"SELECT * FROM tb_user WHERE id = $id");
                $row = mysqli_fetch_assoc($result);
                $role = $row['uloga'];
            } else {
                $id = 0;
            }

        echo "<ul class='news'>";
        if (count($niz) == 0) {
            echo "<h2>Trenutno nema oglasa.</h2>";
        }

        foreach ($niz as $oglasi) {
                $vlasnik = $oglasi["poslodavac"];
                $pomocni = "SELECT * FROM firma WHERE vlasnik = '$vlasnik'";
                $pomocni_izraz = $this->dbh->query($pomocni);
                $rezultat = $pomocni_izraz->fetch(PDO::FETCH_ASSOC);
                if($rezultat == false){
                    $imefirme = 'Privatno';
                }
                else{
                $imefirme = $rezultat['ime_firme'];
                }
                echo "<br><p>Firma: ".$imefirme." </p>";
                echo "<li><h2>" . $oglasi['naslov'] . "</h2>";  
                echo "<p> Mesto: " . $oglasi['lokacija'] . "</p>";
                echo "<p> Opis: " . $oglasi['opis'] . "</p>";
                echo "<p> Školska sprema: " . $oglasi['sprema'] . "</p>";
                echo "<p> Rok prijave: " . $oglasi['rok'] . "</p></li>";
                if ($vlasnik == $id) {
                    echo "&nbsp<input type='button' class='newsdugmad' id='" . $oglasi['id'] . "' value='brisi'
                onclick='brisioglas(this.id)'>&nbsp";
                    echo "<input type='button' class='newsdugmad' id='" . $oglasi['id'] . "' value='izmeni'
                onclick='izmenioglas(this.id)'>";
                }
                elseif($role == 1){
                    echo "<button class='newsdugmad' onclick='prijavise(". $oglasi['id'] .")'>Konkuriši</button>&nbsp";
                    echo "<button class='newsdugmad' onclick='komentarisi(". $oglasi['poslodavac'] .")'>Komentariši</button>";
                }
                echo "<hr>";
            }
            echo"</ul>";            
        }

        catch(PDOException $e) {
            echo "GRESKA: ";
            echo $e->getMessage();
            }
            }

public function dodaj($name, $username,$email,$password, $uloga) {
try {
$sql = "INSERT INTO tb_user(name,username,email,password,uloga) ";
$sql.= "VALUES ('$name', '$username','$email','$password', '$uloga')";
$pdo_izraz = $this->dbh->exec($sql);
return true;
}
catch(PDOException $e) {
echo "GRESKA: ";
echo $e->getMessage();
return false;
}
}

public function dodajfirmu($ime_firme, $vlasnik) {
    try {
    $sql = "INSERT INTO firma(ime_firme,vlasnik)";
    $sql.= "VALUES ('$ime_firme', '$vlasnik')";
    $pdo_izraz = $this->dbh->exec($sql);
    return true;
    }
    catch(PDOException $e) {
    echo "GRESKA: ";
    echo $e->getMessage();
    return false;
    }
    }


public function dodajkomentar($sadrzaj, $ocena,$kandidat,$poslodavac) {
    try {
    $sql = "INSERT INTO komentar(sadrzaj,ocena,kandidat,poslodavac) ";
    $sql.= "VALUES ('$sadrzaj', '$ocena','$kandidat','$poslodavac')";
    $pdo_izraz = $this->dbh->exec($sql);
    return true;
    }
    catch(PDOException $e) {
    echo "GRESKA: ";
    echo $e->getMessage();
    return false;
    }
    }


public function dodajprijavu($cv, $datum_rodjenja,$sprema,$iskustvo, $oglas,$kandidat) {
    try {
    $sql = "INSERT INTO prijava(cv,datum_rodjenja,sprema,iskustvo,oglas,kandidat) ";
    $sql.= "VALUES ('$cv', '$datum_rodjenja','$sprema','$iskustvo', '$oglas','$kandidat')";
    $pdo_izraz = $this->dbh->exec($sql);
    return true;
    }
    catch(PDOException $e) {
    echo "GRESKA: ";
    echo $e->getMessage();
    return false;
    }
    }


public function dodajoglas($naslov, $lokacija,$sprema,$opis, $rok,$poslodavac) {
    try {
    $sql = "INSERT INTO oglasi(naslov,lokacija,sprema,opis,rok,poslodavac) ";
    $sql.= "VALUES ('$naslov', '$lokacija','$sprema','$opis', '$rok','$poslodavac')";
    $pdo_izraz = $this->dbh->exec($sql);
    return true;
    }
    catch(PDOException $e) {
    echo "GRESKA: ";
    echo $e->getMessage();
    return false;
    }
    }
/*
* Metoda koja brise knjigu sa ID-om $id iz baze
*/
public function brisi($id) {
try {
$sql = "DELETE FROM tb_user WHERE id=$id";
$pdo_izraz = $this->dbh->exec($sql);
return true;
}
catch(PDOException $e) {
echo "GRESKA: ";
echo $e->getMessage();
return false;
}
}
public function brisiprijavu($id) {
    try {
    $sql = "DELETE FROM prijava WHERE id=$id";
    $pdo_izraz = $this->dbh->exec($sql);
    return true;
    }
    catch(PDOException $e) {
    echo "GRESKA: ";
    echo $e->getMessage();
    return false;
    }
    }

public function brisioglas($id) {
    try {
    $sql = "DELETE FROM oglasi WHERE id=$id";
    $pdo_izraz = $this->dbh->exec($sql);
    return true;
    }
    catch(PDOException $e) {
    echo "GRESKA: ";
    echo $e->getMessage();
    return false;
    }
    }
/*
* Metoda koja za knjigu sa ID-om $id postavlja name, usernamea i godinu
*/
public function izmeni($id, $name, $username,$email,$password, $uloga) {
try {
$sql = "UPDATE tb_user SET name=:name, ";
$sql.= "username=:username,email=:email,password=:password, uloga=:uloga ";
$sql.= "WHERE id=:id";
$pdo_izraz = $this->dbh->prepare($sql);
$pdo_izraz->bindParam(':id', $id);
$pdo_izraz->bindParam(':name', $name);
$pdo_izraz->bindParam(':username', $username);
$pdo_izraz->bindParam(':email', $email);
$pdo_izraz->bindParam(':password', $password);
$pdo_izraz->bindParam(':uloga', $uloga);
$pdo_izraz->execute();
return true;
}
catch(PDOException $e) {
echo "GRESKA: ";
echo $e->getMessage();
return false;
}
}


public function izmenioglas($id,$naslov, $lokacija,$sprema,$opis, $rok) {
    try {
    $sql = "UPDATE oglasi SET naslov=:naslov, ";
    $sql.= "naslov=:naslov,lokacija=:lokacija,sprema=:sprema, opis=:opis,rok=:rok ";
    $sql.= "WHERE id=:id";
    $pdo_izraz = $this->dbh->prepare($sql);
    $pdo_izraz->bindParam(':id', $id);
    $pdo_izraz->bindParam(':naslov', $naslov);
    $pdo_izraz->bindParam(':lokacija', $lokacija);
    $pdo_izraz->bindParam(':sprema', $sprema);
    $pdo_izraz->bindParam(':opis', $opis);
    $pdo_izraz->bindParam(':rok', $rok);
    $pdo_izraz->execute();
    return true;
    }
    catch(PDOException $e) {
    echo "GRESKA: ";
    echo $e->getMessage();
    return false;
    }
    }
/*
* Metoda koja uzima iz baze podatke (id, name, username, uloga) o knjizi
* sa ID-om $id i vraca ih u obliku asocijativnog niza
*/

public function uzmi_podatke_o_oglasu($id) {
    try {
    $sql = "SELECT * FROM oglasi WHERE id=$id";
    $pdo_izraz = $this->dbh->query($sql);
    $obj = $pdo_izraz->fetch(PDO::FETCH_ASSOC);
    return $obj;
    }
    catch(PDOException $e) {
    echo "GRESKA: ";
    echo $e->getMessage();
    return false;
    }
    }

public function uzmi_podatke_o_prijavi($id) {
        try {
        $sql = "SELECT * FROM prijava WHERE id=$id";
        $pdo_izraz = $this->dbh->query($sql);
        $obj = $pdo_izraz->fetch(PDO::FETCH_ASSOC);
        return $obj;
        }
        catch(PDOException $e) {
        echo "GRESKA: ";
        echo $e->getMessage();
        }
        }
        


public function uzmi_podatke_o_korisniku($id) {
    try {
    $sql = "SELECT * FROM tb_user WHERE id=$id";
    $pdo_izraz = $this->dbh->query($sql);
    $obj = $pdo_izraz->fetch(PDO::FETCH_ASSOC);
    return $obj;
    }
    catch(PDOException $e) {
    echo "GRESKA: ";
    echo $e->getMessage();
    }
    }
    } 
    
    
    ?>

    


