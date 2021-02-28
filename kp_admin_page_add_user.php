<!DOCTYPE html>
<html>
<!--
	Projekat kupujemProdajem (PIA 2020)
	-->
<head>
    <title>KP - Admin - DodajKorisnika</title>
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
<body id="bodyId">
    <?php
        session_start();
        $currentId =  $_SESSION['idU'];
        $currentFirstname = $_SESSION['firstnameU'];
        $currentLastname = $_SESSION['lastnameU'];
        $currentEmail = $_SESSION['emailU'];
        $currentUsername = $_SESSION['usernameU'];
        $currentPassword = $_SESSION['passwdU'];
        $currentAccountType = $_SESSION['accountTypeU'];
        $currentUserStatus = $_SESSION['statusLogInOutU'];
        $currentBlockedStatus = $_SESSION['blockedU'];
        if($currentUserStatus != "in"){
            header("Location:kp_log_in.php");
        }
    ?>

    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a class="option" id="procuctsMenu" href="#" onclick="loadAdminPage()">Proizvodi</a>
        <a class="option" id="usersMenu" href="#" onclick="loadAdminPageUsersList()">Korisnici</a>
        <a class="option" id="addMenu" href="#" onclick="loadAdminPageAddUser()">Dodaj korisnika</a>
    </div>


    <ul class="topnav">
        <li><a onclick="loadAdminPage()" style="padding: 0;"><img id="logo" src="images/logoo.jpg" alt="pageLogo"></a></li>
        <li class="right">        
            <form action="logOut.php" method="POST" id="logOutForm">
                <input id="logOutButton" type="submit" name="logOutbutton" class="fa" value="&#xf08b; Odjava"/>
            </form></li>
        <li class="right"><button id="menuAdmin" class="openbtn" onclick="openNav()"><i class="fa fa-bars"></i> <?php echo $currentUsername." - administrator";?></button></li>
    </ul>


    <?php include("addUserByAdmin.php");?>

    <div class="container">
        <h2>DODAJTE KORISNIKA:</h2>
        <?php echo $invalidInput; ?><br><br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
            Ime: <br>
            <input id="yourInput" type="text" name="addUserName" value="<?php echo $addUserName;?>">
            <br>
            <span class="error"><?php echo $addUserNameErr;?></span>
            <br>
            Prezime: <br>
            <input id="yourInput" type="text" name="addUserSurname" value="<?php echo $addUserSurname;?>">
            <br>
            <span class="error"><?php echo $addUserSurnameErr;?></span>
            <br>
            E-mail: <br>
            <input id="yourInput" type="text" name="addUserEmail" value="<?php echo $addUserEmail;?>">
            <br>
            <span class="error"><?php echo $addUserEmailErr;?></span>
            <br>
            Korisničko ime: <br>
            <input id="yourInput" type="text" name="addUserUsername" value="<?php echo $addUserUsername;?>">
            <br>
            <span class="error"><?php echo $addUserUsernameErr;?></span>
            <br>
            Lozinka: <br>
            <input id="yourInput" type="password" name="addUserPassword">
            <br>
            <span class="error"><?php echo $addUserPasswordErr;?></span>
            <br>
            Tip naloga:&ensp;
            <input type="radio" name="accountType" <?php if (isset($addUserAccType) && $addUserAccType=="customer") echo "checked";?> value="customer"> Kupac
            <input type="radio" name="accountType" <?php if (isset($addUserAccType) && $addUserAccType=="seller") echo "checked";?> value="seller"> Prodavac
            <br>
            <span class="error"><?php echo $addUserAccTypeErr;?></span>
            <br>
            <br>
            <p style="color: red;"><?php echo $labelAlreadyExists;?></p>
            <input id="submitForm" type="submit" name="submit" value="Dodajte korisnika" style="width: 150px;">  
            <br><br>
        </form> 
    </div>



 
</body>
</html>