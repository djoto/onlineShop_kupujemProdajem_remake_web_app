<!DOCTYPE html>
<html>
<!--
	Projekat kupujemProdajem (PIA 2020)
	-->
<head>
    <title>KP - Prijava</title>
    <meta name="author" content="Ђорђе Гачић, Вељко Максимовић" />
    <meta charset="utf-8" />
    <meta name="description" content="HTML/CSS/Bootstrap/JavaScript/jQuery/mySQL/PHP project." />
    <meta name="keywords" content="pia, web programming, html, css, bootstrap, javascript, jquery, PHP, mySQL" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="kp.css">
    <script src="kp.js"></script>
</head>
<body>
    <ul class="topnav">
        <li><a onclick="loadHome()" style="padding: 0;"><img id="logo" src="images/logoo.jpg" alt="pageLogo"></a></li>
    </ul>


    <?php include("logIn.php");?>

    <div class="container" id="logInDiv">
        <h2>Uspešno ste se registrovali. Prijavite se na vaš nalog:</h2><br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
            Korisničko ime ili e-mail: <br>
            <input id="yourInput" type="text" name="logInName" value="<?php echo $logInName;?>">
            <br>
            <span class="error"><?php echo $logInNameErr;?></span>
            <br>
            Lozinka: <br>
            <input id="yourInput" type="password" name="logInPassword">
            <br>
            <span class="error"><?php echo $logInPasswdErr;?></span>
            <br>
            <input id="submitForm" type="submit" name="submit" value="Prijavite se">  
            <br>
            <p style="color: red; margin-top: 5px;"><?php echo $labelIfNotExists; ?></p>
        </form> 
    </div>
 
</body>
</html>