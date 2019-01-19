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
    <title>Uživatelé</title>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>

    <link rel="stylesheet" href="css/main.css">


</head>
<body>

<h1>Uživatelé</h1>



<table class="tableSl">

    <tr>
        <th>Id</th>
        <th>E-mail</th>
        <th>Jméno</th>
        <th>Přijmení</th>
        <th>Telefon</th>
        <th>Město</th>
        <th>Role</th>

    </tr>
    <?php
    require_once "config.php";
    $sql = "SELECT * FROM uzivatel ";

    $link->query('set names utf8');
    $result = $link->query($sql);
    unset($_SESSION['idUser']);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "";
            echo "<td>" . $row['id_uzivatel']. "</td>";
            echo "<td><a class='svytCer' href='register.php?idUser=".$row['id_uzivatel']."'> " . $row['email']. "</a></td>";

            echo "<td>" . $row['jmeno']. "</td>";
            echo "<td>" . $row['prijmeni']. "</td>";
            echo "<td>" . $row['telefon']. "</td>";
            echo "<td>" . $row['mesto']. "</td>";
            echo "<td>" . $row['role']. "</td>";
            //echo "<td>" . $row['popis']. "</td>";



            echo "</tr>";

        }
    }



    ?>

</table>
<br>
<a id="pridatAuto" href="register.php">Přidat uživatele</a>


</body>
</html>