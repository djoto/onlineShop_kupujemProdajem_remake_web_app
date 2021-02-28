<!DOCTYPE html>
<html>
<!--
	Projekat kupujemProdajem (PIA 2020)
	-->
<head>
    <title>KP - Registracija</title>
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
        <li class="right"><a onclick="loadHome()"><i class="fa fa-home"></i> Početna</a></li>
    </ul>


    <?php include("signUp.php");?>

    <div class="container" id="signUpDiv">
        <h2>Registracija:</h2>
        <?php echo $invalidInput; ?><br><br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
            Ime: <br>
            <input id="yourInput" type="text" name="signUpName" value="<?php echo $signUpName;?>">
            <br>
            <span class="error"><?php echo $signUpNameErr;?></span>
            <br>
            Prezime: <br>
            <input id="yourInput" type="text" name="signUpSurname" value="<?php echo $signUpSurname;?>">
            <br>
            <span class="error"><?php echo $signUpSurnameErr;?></span>
            <br>
            E-mail: <br>
            <input id="yourInput" type="text" name="signUpEmail" value="<?php echo $signUpEmail;?>">
            <br>
            <span class="error"><?php echo $signUpEmailErr;?></span>
            <br>
            Korisničko ime: <br>
            <input id="yourInput" type="text" name="signUpUsername" value="<?php echo $signUpUsername;?>">
            <br>
            <span class="error"><?php echo $signUpUsernameErr;?></span>
            <br>
            Lozinka: <br>
            <input id="yourInput" type="password" name="signUpPassword">
            <br>
            <span class="error"><?php echo $signUpPasswordErr;?></span>
            <br>
            Tip naloga:&ensp;
            <input type="radio" name="accountType" <?php if (isset($signUpAccType) && $signUpAccType=="customer") echo "checked";?> value="customer"> Kupac
            <input type="radio" name="accountType" <?php if (isset($signUpAccType) && $signUpAccType=="seller") echo "checked";?> value="seller"> Prodavac
            <br>
            <span class="error"><?php echo $signUpAccTypeErr;?></span>
            <br>
            <br>
            <p style="color: red;"><?php echo $labelAlreadyExists;?></p>
            <input id="submitForm" type="submit" name="submit" value="Registrujte se" style="width: 130px;">  
            <br><br>
        </form> 
    </div>
 
</body>
</html>