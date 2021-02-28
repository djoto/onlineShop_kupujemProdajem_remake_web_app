<!DOCTYPE html>
<html>
<!--
	Projekat kupujemProdajem (PIA 2020)
	-->
<head>
    <title>KP - Admin - Korisnici</title>
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


    <div id="allUsers" class="container-fluid"><br><h1>SPISAK SVIH KORISNIKA:</h1><br>
        <div class="users">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "password";
            $dBase = "KPdatabase";

            $connectForAllUsers = new mysqli($servername, $username, $password, $dBase);

            $fromAllUsersSelected = "SELECT idU, firstnameU, lastnameU, emailU, usernameU, accountTypeU, blockedU FROM allUsersKP";
            $resultAllUsersSelection = $connectForAllUsers->query($fromAllUsersSelected);
            $usersAll = "<table id=\"users\"><tr><th>red. br.</th><th>IME</th><th>PREZIME</th><th>E-MAIL</th><th>KORISNIČKO IME</th><th>TIP NALOGA</th><th>BLOKIRAN (DA/NE)</th><th>BLOKIRANJE</th><th>BRISANJE</th></tr>";
            $elementIdNum = 1;
            while($rowAllUsers = $resultAllUsersSelection->fetch_assoc()) {
                $currentUserID = $rowAllUsers["idU"];

                if ($rowAllUsers["accountTypeU"]=="customer"){
                    $typeUser = "kupac";
                    $usernameLink = '<a href="#" onclick=loadCustomerProfileForOthers('.$currentUserID.')>'.$rowAllUsers["usernameU"].'</a>';
                }
                else if ($rowAllUsers["accountTypeU"]=="seller"){
                    $typeUser = "prodavac";
                    $usernameLink = '<a href="#" onclick=loadSellerProfileForAdmin('.$currentUserID.')>'.$rowAllUsers["usernameU"].'</a>';
                }
                else if ($rowAllUsers["accountTypeU"]=="admin"){
                    $typeUser = "administrator";
                    $usernameLink = $rowAllUsers["usernameU"];
                }

                if($rowAllUsers["blockedU"] == "no"){
                    $blockedStatus = "NE";
                    if ($currentId != $currentUserID){
                        $usersAll .= 
                        '<tr>
                            <td>'.$elementIdNum.'.</td>
                            <td>'.$rowAllUsers["firstnameU"].'</td>
                            <td>'.$rowAllUsers["lastnameU"].'</td>
                            <td>'.$rowAllUsers["emailU"].'</td>
                            <td>'.$usernameLink.'</td>
                            <td>'.$typeUser.'</td>
                            <td>'.$blockedStatus.'</td>
                            <td>
                            <button class="blockButton" data-toggle="modal" data-target="#block'.$currentUserID.'">Blokirajte</button>
                            <div class="modal fade" id="block'.$currentUserID.'">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <div class="modal-title-text">
                                            <h3 class="modal-title"><b><i>POTVRDA BLOKIRANJA NALOGA: '.$rowAllUsers["usernameU"].'</i></b></h3><br>
                                            </div>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="blockUser.php?block='.$currentUserID.'" method="POST" style="text-align: center;">
                                                <input type="submit" value="Blokirajte korisnika"><br><br>
                                                <span style="font-size: 14px;"><b>Napomena: </b>Nakon što blokirate korisnika, on neće biti u mogućnosti da se prijavi na svoj nalog sve dok ga administrator ne odblokira.<br></span>
                                                <br>
                                            </form>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Zatvori</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                            <td>
                            <button class="removeButton" data-toggle="modal" data-target="#remove'.$currentUserID.'">Obrišite</button>
                            <div class="modal fade" id="remove'.$currentUserID.'">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <div class="modal-title-text">
                                            <h3 class="modal-title"><b><i>POTVRDA BRISANJA NALOGA: '.$rowAllUsers["usernameU"].'</i></b></h3><br>
                                            </div>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="removeUser.php?remove='.$currentUserID.'" method="POST" style="text-align: center;">
                                                <input type="submit" value="Obrišite korisnika"><br><br>
                                                <span style="font-size: 14px;"><b>Napomena: </b>Nakon što obrišete korisnika, on više neće postojati u bazi podataka kao ni njegovi proizvodi, ocjene i narudžbine.<br></span>
                                                <br>
                                            </form>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Zatvori</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>';
                    }
                    else {
                        $usersAll .= 
                        '<tr>
                            <td>'.$elementIdNum.'.</td>
                            <td>'.$rowAllUsers["firstnameU"].'</td>
                            <td>'.$rowAllUsers["lastnameU"].'</td>
                            <td>'.$rowAllUsers["emailU"].'</td>
                            <td>'.$usernameLink.' (Vi)</td>
                            <td>'.$typeUser.'</td>
                            <td>'.$blockedStatus.'</td>
                            <td> / </td>
                            <td> / </td>
                        </tr>';
                    }
                }
                else if ($rowAllUsers["blockedU"] == "yes"){
                    $blockedStatus = "DA";
                    if ($currentId != $currentUserID){
                        $usersAll .= 
                        '<tr>
                            <td>'.$elementIdNum.'.</td>
                            <td>'.$rowAllUsers["firstnameU"].'</td>
                            <td>'.$rowAllUsers["lastnameU"].'</td>
                            <td>'.$rowAllUsers["emailU"].'</td>
                            <td>'.$usernameLink.'</td>
                            <td>'.$typeUser.'</td>
                            <td>'.$blockedStatus.'</td>
                            <td>
                            <button class="unblockButton" data-toggle="modal" data-target="#unblock'.$currentUserID.'">Odblokirajte</button>
                            <div class="modal fade" id="unblock'.$currentUserID.'">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <div class="modal-title-text">
                                            <h3 class="modal-title"><b><i>POTVRDA ODBLOKIRANJA NALOGA: '.$rowAllUsers["usernameU"].'</i></b></h3><br>
                                            </div>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="unblockUser.php?unblock='.$currentUserID.'" method="POST" style="text-align: center;">
                                                <input type="submit" value="Odblokirajte korisnika"><br><br>
                                                <span style="font-size: 14px;"><b>Napomena: </b>Nakon što odblokirate korisnika, on će ponovo biti u mogućnosti da se prijavi na svoj nalog.<br></span>
                                                <br>
                                            </form>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Zatvori</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                            <td>
                            <button class="removeButton" data-toggle="modal" data-target="#remove'.$currentUserID.'">Obrišite</button>
                            <div class="modal fade" id="remove'.$currentUserID.'">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <div class="modal-title-text">
                                            <h3 class="modal-title"><b><i>POTVRDA BRISANJA NALOGA: '.$rowAllUsers["usernameU"].'</i></b></h3><br>
                                            </div>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="removeUser.php?remove='.$currentUserID.'" method="POST" style="text-align: center;">
                                                <input type="submit" value="Obrišite korisnika"><br><br>
                                                <span style="font-size: 14px;"><b>Napomena: </b>Nakon što obrišete korisnika, on više neće postojati u bazi podataka kao ni njegovi proizvodi, ocjene i narudžbine.<br></span>
                                                <br>
                                            </form>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Zatvori</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>';
                    }
                    else{
                        $usersAll .= 
                        '<tr>
                            <td>'.$elementIdNum.'.</td>
                            <td>'.$rowAllUsers["firstnameU"].'</td>
                            <td>'.$rowAllUsers["lastnameU"].'</td>
                            <td>'.$rowAllUsers["emailU"].'</td>
                            <td>'.$usernameLink.' (Vi)</td>
                            <td>'.$typeUser.'</td>
                            <td>'.$blockedStatus.'</td>
                            <td> / </td>
                            <td> / </td>
                        </tr>';
                    }
                }
                $elementIdNum++;
            }
            echo $usersAll."</table>";
            $connectForAllUsers->close();
            ?>
        </div>
    </div> 



 
</body>
</html>