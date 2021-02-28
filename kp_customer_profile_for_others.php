<!DOCTYPE html>
<html>
<!--
	Projekat kupujemProdajem (PIA 2020)
	-->
<head>
    <title>KP - Kupac - Profil</title>
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
    <ul class="topnav">
        <li><a onclick="goBack()" style="padding: 0;"><img id="logo" src="images/logoo.jpg" alt="pageLogo"></a></li>
        <li class="right"><a onclick="goBack()"><i class="fa fa-arrow-left"></i> Nazad</a></li>
    </ul>

    <?php
        $IdCustomerToView = $_GET["idc"];
        
        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dBase = "KPdatabase";

        $connectToView = new mysqli($servername, $username, $password, $dBase);

        $fromUsersToView = "SELECT idU, firstnameU, lastnameU, emailU, usernameU FROM allUsersKP WHERE idU=$IdCustomerToView";
        $resultUsersToView = $connectToView->query($fromUsersToView);

        while($rowUsersToView = $resultUsersToView->fetch_assoc()){
            $customerFirstnameToView = $rowUsersToView["firstnameU"];
            $customerLastnameToView = $rowUsersToView["lastnameU"];
            $customerEmailToView = $rowUsersToView["emailU"];
            $customerUsernameToView = $rowUsersToView["usernameU"];
        }
                
    ?>

    <div class="container" id="profilePanel" style="text-align: center;">
        <h3>PODACI O KUPCU:</h3>
        Ime i prezime: <b><i><?php echo $customerFirstnameToView." ".$customerLastnameToView;?></i></b>
        <br>
        Korisničko ime: <b><i><?php echo $customerUsernameToView;?><br></i></b>
        E-mail: <b><i><?php echo $customerEmailToView;?><br></i></b>
        Tip naloga: <b><i>kupac</i></b>
        <br>   
    </div>

    </div>


 
</body>
</html>