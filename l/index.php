<?php
ob_start();
session_start();
include "config.php";
function __autoload($className){
    //todo opravit retezec
    echo './class/.$className' . '.php';
    if(file_exists('./class/' . $className . '.php')){
        echo './class/.$className' . '.php';
        return true;
    } return false;
}
?>
<html lang="en">
<head>
    <title>PHP OOP Example</title>
</head>
<body>
<nav>
    <a href="<?= BASE_URL; ?>">Home</a>
    <a href="<?= BASE_URL . "?page=user&action=read-all" ?>">Read all user</a>
    <a href="<?= BASE_URL . "?page=user&action=by--email" ?>">By email</a>
    <a href="<?= BASE_URL . "?page=logout" ?>">Logout</a>
    <a href="<?= BASE_URL . "?page=blog" ?>">Login</a>
</nav>
<main>
    <?php
    $file = "./page/" . $_GET["page"] . ".php";
    if (file_exists($file)) {
        include $file;
    } else {
        echo "<h1>This is home page</h1>";
    }

?>
</main>
</body>
</html>