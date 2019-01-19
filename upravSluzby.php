<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 18.01.2019
 * Time: 20:07
 */
session_start();

if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] != "Admin") {
        $aa = $_SESSION["role"];
        header("location: index_pr.php?page=domu");
    }
}else {
    $param_role = "Uzivatel";
    header("location: index.php?page=domu");
}
?>





<!DOCTYPE html>
<html lang="cs" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>

    <link rel="stylesheet" href="css/main.css">


</head>
<body>

<h1>Služby</h1>



<table class="tableSl">

    <tr>
        <th>Id</th>
        <th>Název</th>
        <th>Cena</th>
        <th>Čas</th>
    </tr>
<?php
require_once "config.php";
$sql = "SELECT * FROM sluzba ";

$link->query('set names utf8');
$result = $link->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "";
        echo "<td>" . $row['id_sluzba']. "</td>";
        echo "<td><a class='svytCer' href='upravSluzbu.php?idsl=".$row['id_sluzba']."&typ=up '> " . $row['sluzba']. "</a></td>";
        echo "<td>" . $row['cena']. "</td>";
        echo "<td>" . $row['cas']. "</td>";
        //echo "<td>" . $row['popis']. "</td>";



        echo "</tr>";

    }
}



?>

</table>
<br>
<a id="pridatAuto" href="upravSluzbu.php">Přidat Službu</a>


</body>
</html>