<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 17.01.2019
 * Time: 19:17
 */

$auto;
session_start();
require_once "config.php";

if(isset($_POST["zpet"])){
    header("location: index_pr.php?page=rezervace_pr");
}


if(isset($_POST["vymaz"])){
    $idr = $_SESSION["idr"];
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "DELETE FROM rezervace_sluzba WHERE rezervace_id_rezervace='".$idr."'";


    if (mysqli_query($link, $sql)) {

        $sql = "DELETE FROM rezervace WHERE id_rezervace='".$idr."'";

        if (mysqli_query($link, $sql)) {
            echo "Record updated successfully";
            unset($_SESSION['idr']);
            header("location: index_pr.php?page=rezervace_pr");
        }
        else {
            echo "Error updating record: " . mysqli_error($conn);
        }


    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }




    // Close connection
    mysqli_close($link);

}







?>
<!DOCTYPE html>
<html lang="cs" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/rezervace.css">

</head>
<body>


<br><br> <br>
<div id="newRezMiddle">
    <h2>Přehled rezervace</h2>
<?php
    // Prepare a select statement
    $sql = "SELECT datum_rezervace,rezervace_do,automobil_id_pneuservis FROM rezervace WHERE id_rezervace = ".$_GET['idr'];


    $result = $link->query($sql);

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {


    echo "<b>Začátek: </b>" . $row['datum_rezervace'] . " <br>";
    echo "<b>Konec: </b>" . $row['rezervace_do'] . "<br>";
    $auto = $row['automobil_id_pneuservis'];
        }
    }

    echo "<h2>Služby: </h2>";

echo "<div id='sl'>";
// Prepare a select statement
$sql = "SELECT * FROM sluzba LEFT JOIN rezervace_sluzba ON rezervace_sluzba.sluzba_id_sluzba = id_sluzba WHERE rezervace_id_rezervace =".$_GET['idr'];

$link->query('set names utf8');
$result = $link->query($sql);
//  echo "<form >";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        echo" <label class='btnNewRez'>  ";
        echo $row['sluzba']. "";
        echo "<br> cas: " . $row['cas']. " min, cena: ".$row['cena']. "Kč";
        echo "<br> ";
        echo $row['popis']." </label>";
        //echo  "Letní kola: <br>".$row['letni'] . "<br> ";


    }

}

// Close statement
echo "</div>";
$_SESSION["idr"]=$_GET['idr'];
?>

    <br> <br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group">

        <input type="submit" name="vymaz" class="cudl" value="Zrušit rezervaci ">
        <input type="submit" name="zpet" class="cudl" value="Zpět">
    </div>
    </form>
    <?php

echo "</div>";

    echo "<div id='menuLevoNRez'>";
    echo "<h3> Automobil: </h3>";
    // Prepare a select statement
    $sql = "SELECT spz,znacka,model,letni,zimni, jmeno, prijmeni, telefon FROM automobil 
LEFT JOIN uzivatel ON uzivatel_id_uzivatel = uzivatel.id_uzivatel WHERE id_pneuservis = '".$auto."'";

    $link->query('set names utf8');
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            echo "<a class='notDec vis' ><div class='autaMenu'>SPZ: " . $row['spz'] . "<br><br>";
            echo  $row['znacka'] . " ";
            echo  $row['model'] . "<br><br>";
            echo  "Letní kola: <br>".$row['letni'] . "<br> ";
            echo  "Zimní kola: <br>".$row['zimni'] . "</div></a>";
            echo "<h3> Majitel: </h3>";
            echo "<a class='notDec vis' ><div class='autaMenu'>" . $row['jmeno'] ." ".$row['prijmeni'] . "<br><br>";
            echo  "tel: ".$row['telefon'] . " ";


            echo  "</div></a>";


        }

    }
echo "</div>";
    // Close statement





    ?>











</body>
</html>