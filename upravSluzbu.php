<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] != "Admin") {
        $aa = $_SESSION["role"];
        header("location: index_pr.php?page=domu");
    }
}else {
    $param_role = "Uzivatel";
    header("location: index.php?page=domu");
}
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$nazev = $cena= $doba=$popis= "";
$nazev_err = $cena_err = $doba_err = $popis_err="";


if(isset($_POST["vymaz"])) {

    $sql = "DELETE FROM sluzba WHERE sluzba='".$_POST["nazev"]."'";

    if (mysqli_query($link, $sql)) {
        echo "Record updated successfully";
        header("location: upravSluzby.php");

    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if(isset($_GET['idsl'])) {
    $sql = "SELECT * FROM sluzba WHERE id_sluzba= '" . $_GET["idsl"] . "'";

    $link->query('set names utf8');
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $nazev = $row['sluzba'];
            $cena = $row['cena'];
            $doba = $row['cas'];
            $popis = $row['popis'];


        }

    }
    $result->close();
}


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if nazev is empty
    if(empty(trim($_POST["nazev"]))){
        $nazev_err = "Prosím zadejte název služby";
    } else{

        if(isset($_POST["vytvor"])) {

            $sql = "SELECT * FROM sluzba where sluzba.sluzba='" . $_POST["nazev"] . "'";

            $link->query('set names utf8');
            $result = $link->query($sql);


            //if ($result == false) {
            if($result->num_rows==0){
                $nazev = trim($_POST["nazev"]);
            } else {
                $nazev_err = "Tento název je již použit";
            }
        }
        else{
            $nazev = trim($_POST["nazev"]);
        }


    }



    // Check if password is empty
    if(empty(trim($_POST["cena"]))){
        $cena_err = "Prosím zadejte Cenu";
    } else{
        $cena = trim($_POST["cena"]);
    }

    if(empty(trim($_POST["doba"]))){
        $doba_err = "Prosím zadejte dobu trvání";
    } else{
        $doba = trim($_POST["doba"]);
    }

    if(empty(trim($_POST["popis"]))){
        $popis_err = "Prosím zadejte Popis služby";
    } else{
        $popis = trim($_POST["popis"]);
    }

    // Validate credentials
    if(empty($nazev_err) && empty($cena_err) && empty($doba_err) && empty($popis_err)){
        // Prepare a select statement

        if(isset($_POST["vytvor"])) {
            $sql = "INSERT INTO sluzba ( sluzba, cena, cas, popis) VALUES ( ?,?,?,?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "siis", $nazev, $cena, $doba, $popis);

            }
        }
            if(isset($_POST["uprav"])) {
                $sql = "UPDATE sluzba SET  cena=?, cas=?, popis=? WHERE  sluzba=?";

                if ($stmt = mysqli_prepare($link, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "iiss", $cena, $doba, $popis, $nazev);

                }
            }

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: upravSluzby.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

        // Close statement


        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="css/stylesheet.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Služba</h2>
    <p>Vyplňte všechna pole</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($nazev_err)) ? 'has-error' : ''; ?>">
            <label>Název</label>
            <input type="text" name="nazev" class="form-control" value="<?php echo $nazev;?>"
                <?php
                if(isset($_POST["uprav"]) || isset($_GET["typ"]))
                echo " readonly";?>>

            <span class="help-block"><?php echo $nazev_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($cena_err)) ? 'has-error' : ''; ?>">
            <label>Cena</label>
            <input type="text" name="cena" class="form-control"  value="<?php echo $cena;?>">
            <span class="help-block"><?php echo $cena_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($doba_err)) ? 'has-error' : ''; ?>">
            <label>Dobra trvání</label>
            <input type="text" name="doba" class="form-control" value="<?php echo $doba;?>">
            <span class="help-block"><?php echo $doba_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($popis_err)) ? 'has-error' : ''; ?>">
            <label>Popis</label>
            <textarea name="popis" rows="8" cols="50"><?php echo $popis;?></textarea>
            <span class="help-block"><?php echo $popis_err; ?></span>
        </div>
        <div class="form-group">
            <?php
            if (isset($_GET["typ"])) {
                echo "<input type='submit' name='uprav' class='btn btn-primary' value='Upravit'>    ";
                echo "<input type='submit' name='vymaz' class='btn btn-primary' value='Vymazat'>";
            }else{
                echo "<input type='submit' name='vytvor' class='btn btn-primary' value='Vytvoř'>";
            }
            ?>

        </div>


    </form>
</div>
</body>
</html>