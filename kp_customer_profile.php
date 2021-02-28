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
        <li><a onclick="loadCustomerPage()" style="padding: 0;"><img id="logo" src="images/logoo.jpg" alt="pageLogo"></a></li>
        <li class="right">        
            <form action="logOut.php" method="POST" id="logOutForm">
                <input id="logOutButton" type="submit" name="logOutbutton" class="fa" value="&#xf08b; Odjava"/>
            </form></li>
        <li class="right"><a onclick="goBack()"><i class="fa fa-arrow-left"></i> Nazad</a></li>
    </ul>


    <div class="container" id="profilePanel">
        Ime i prezime: <b><i><?php echo $currentFirstname." ".$currentLastname;?></i></b>
        <br>
        Korisničko ime: <b><i><?php echo $currentUsername;?><br></i></b>
        E-mail: <b><i><?php echo $currentEmail;?><br></i></b>
        Tip naloga: <b><i>kupac</i></b>
        <br>
        <p style="text-align: center; margin-top: 30px;"><b>Moje narudžbine:</b></p>

        <div style="text-align: center; padding-bottom: 20px;">
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "password";
            $dBase = "KPdatabase";

            $connectForOrdersCustomer = new mysqli($servername, $username, $password, $dBase);

            $fromOrdersCustomer = "SELECT idO, idCustomerO, idSellerO, idProductO, acceptedO, deniedO, cancelledO, paymentTypeO, quantityO FROM KPallOrders WHERE idCustomerO=$currentId";
            $resultOrdersCustomer = $connectForOrdersCustomer->query($fromOrdersCustomer);
            $ordersCustomerAll = "";
            $numOrders = 0;
            while($rowOrdersCustomer = $resultOrdersCustomer->fetch_assoc()) {
                $currentOrderId = $rowOrdersCustomer["idO"];
                $currentSellerId = $rowOrdersCustomer["idSellerO"];
                $_SESSION['currentSellerId'] = $currentSellerId;
                $currentProductId = $rowOrdersCustomer["idProductO"];
                $currentAcceptedStatus = $rowOrdersCustomer["acceptedO"];
                $currentDeniedStatus = $rowOrdersCustomer["deniedO"];
                $currentCancelledStatus = $rowOrdersCustomer["cancelledO"];
                $currentPaymentType = $rowOrdersCustomer["paymentTypeO"];
                $currentQuantityO = $rowOrdersCustomer["quantityO"];

                $fromProductsSelected = "SELECT idP, titleP, priceP FROM allProductsKP WHERE idP=$currentProductId";
                $resultProductsSelection = $connectForOrdersCustomer->query($fromProductsSelected);
                $currentProductTitle = "";
                $currentProductPrice = "";
                while($rowProducts = $resultProductsSelection->fetch_assoc()){
                    $currentProductTitle = $rowProducts["titleP"];
                    $currentProductPrice = $rowProducts["priceP"];
                }

                $fromUsersSelected = "SELECT idU, usernameU FROM allUsersKP WHERE idU=$currentSellerId";
                $resultUsersSelection = $connectForOrdersCustomer->query($fromUsersSelected);
                $currentUsernameSeller = "";
                while($rowUsers = $resultUsersSelection->fetch_assoc()){
                    $currentUsernameSeller = $rowUsers["usernameU"];
                }
                $currentStatusString = "Čeka se potvrda.";
                if ($currentAcceptedStatus == "yes" && $currentDeniedStatus == "no"){
                    $currentStatusString = "Odobreno.";
                }
                else if ($currentAcceptedStatus == "no" && $currentDeniedStatus == "yes"){
                    $currentStatusString = "Odbijeno.";
                }
                $ordersCustomerAll .= '<div class="orderCustomer">
                <a class="link-orderCustomer" onclick="loadProductPageCustomer('.$currentProductId.')">'.$currentProductTitle.' '.$currentProductPrice.'&euro;</a>, Količina: '.$currentQuantityO.', 
                Prodavac: <a class="link-seller" onclick="loadSellerProfileForCustomers('.$currentSellerId.')">'.$currentUsernameSeller.'</a><span>, Način plaćanja: '.$currentPaymentType.', Status: '.$currentStatusString.'</span>';
                    if ($currentStatusString == "Čeka se potvrda." || $currentStatusString == "Odbijeno."){
                        if($currentStatusString == "Čeka se potvrda."){
                            $forButtonValue = "Otkažite narudžbinu";
                        }
                        else if ($currentStatusString == "Odbijeno."){
                            $forButtonValue = "Obrišite narudžbinu";
                        }
                        $ordersCustomerAll .= '
                        <br><button class="confirmButton" data-toggle="modal" data-target="#accept'.$numOrders.'">'.$forButtonValue.'</button><br><br>
                            <div class="modal fade" id="accept'.$numOrders.'">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <div class="modal-title-text">
                                            <h3 class="modal-title"><b><i>OTKAZIVANJE NARUDŽBINE</i></b></h3><br>
                                            </div>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="cancelOrder.php?cancel='.$currentOrderId.'" method="POST" id="cancelForm">
                                                <input id="cancelButton" type="submit" name="cancelButton" value="'.$forButtonValue.'"><br><br>
                                                <span style="font-size: 14px;"><b>Napomena:</b> Narudžbina će biti obrisana.</span><br>
                                            </form>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Zatvori</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                    else if ($currentStatusString == "Odobreno."){
                        $ordersCustomerAll .= '<br><button class="confirmButton" data-toggle="modal" data-target="#confirm'.$numOrders.'">Potvrdite prijem</button><br><br>
                            <div class="modal fade" id="confirm'.$numOrders.'">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <div class="modal-title-text">
                                            <h3 class="modal-title"><b><i>POTVRDA PRIJEMA</i></b></h3><br>
                                            </div>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <h5>Ocenite prodavca (neobavezno):</h5><br>
                                            <form action="gradeSeller.php?delete='.$currentOrderId.'" method="POST" style="text-align: center;">
                                                Ocena (1-10): <input type="number" name="yourGrade" min="0" max="10" value="0" style="width: 60px;"><br><br>
                                                Komentar:<br>
                                                <textarea id="yourComment" type="text" name="yourComment" rows="4"></textarea><br>
                                                <input type="submit" value="Potvrdite prijem"><br>
                                                <span style="font-size: 14px;"><b>Napomena: </b>Nakon što potvrdite prijem narudžbina se briše.<br>
                                                Istog prodavca možete oceniti samo jednom!</span>
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
                        </div>';
                    }
            $numOrders++;
            }
            if($ordersCustomerAll == ""){
                $ordersCustomerAll = "Još nema narudžbina.";
            }
            echo $ordersCustomerAll;
            $connectForordersCustomer->close();
            ?>
        </div>



        <!-- <ul class="nav nav-tabs sticky-top" role="tablist">
            <li class="nav-item" id="about">
                <a class="nav-link active" data-toggle="tab" href="#myProducts">Moji proizvodi</a>
            </li>
            <li class="nav-item" id="menu">
                <a class="nav-link" data-toggle="tab" href="orders">Narudžbine</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kontakt">Ocene i komentari</a>
            </li>
        </ul> -->
    </div>


 
</body>
</html>