<!DOCTYPE html>
<html>
<!--
	Projekat kupujemProdajem (PIA 2020)
	-->
<head>
    <title>KP - Proizvod</title>
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
        // if($currentUserStatus != "in"){
        //     header("Location:kp_log_in.php");
        // }
    ?>

    <?php
        $productId = $_GET["idp"];
        $pageType = $_GET["type"];
        $_SESSION['productId'] = $productId;
        $_SESSION['pageType'] = $pageType;

        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dBase = "KPdatabase";

        $connectForLoadProductInfo = new mysqli($servername, $username, $password, $dBase);

        $selectFromProducts = "SELECT idP, idS, titleP, priceP, categoryP, locationP, quantityP, deliveryTypeP, aboutP FROM allProductsKP WHERE idP=$productId";
        $selectedWithProductId = $connectForLoadProductInfo->query($selectFromProducts);

        $selectedId = "";

        if ($selectedWithProductId ->num_rows > 0) {

            while($rowSelected = $selectedWithProductId->fetch_assoc()) {
                $selectedProductId = $rowSelected["idP"];
                $selectedSellerId = $rowSelected["idS"];
                $_SESSION['sellerIdToOrder'] = $selectedSellerId;
                $selectedTitle = $rowSelected["titleP"];
                $selectedPrice = $rowSelected["priceP"];
                $_SESSION['priceForOne'] = $selectedPrice;
                $selectedCategory = $rowSelected["categoryP"];
                $selectedLocation = $rowSelected["locationP"];
                $selectedQuantity = $rowSelected["quantityP"];
                $selectedDelivery = $rowSelected["deliveryTypeP"];
                if($selectedDelivery == "yes"){
                    $delivery = "Da";
                }
                else{
                    $delivery = "Ne";
                }
                $selectedAbout = $rowSelected["aboutP"];
                $_SESSION['idP'] = $selectedProductId;
                $fromUsersSelected = "SELECT idU, usernameU FROM allUsersKP WHERE idU=$selectedSellerId";
                $resultUsersSelection = $connectForLoadProductInfo->query($fromUsersSelected);
                $currentUsernameSeller = "";
                while($rowUsers = $resultUsersSelection->fetch_assoc()){
                    $currentUsernameSeller = $rowUsers["usernameU"];
                }

            }
        }

        $connectForLoadProductInfo->close();
    ?>
    
    <ul class="topnav">
        <li><a onclick="goBack()" style="padding: 0;"><img id="logo" src="images/logoo.jpg" alt="pageLogo"></a></li>
        <li class="right"><a onclick="goBack()"><i class="fa fa-arrow-left"></i> Nazad</a></li>
    </ul>


    <div id="productContent" class="container"><br>
        <?php
            $addForType = "";
            if ($pageType == "ordinary"){
                $addForType .= '<p style="text-align: center; font-size: x-large; font-weight: bold;">'.$selectedTitle.'</p>
                <p style="text-align: center;"><b>Cena:</b>&ensp;'.$selectedPrice.'&euro;</p>
                <p><b>Prodavac:</b>&ensp;<a class="link-seller" onclick="loadLogInForm()">'.$currentUsernameSeller.'</a></p>
                <p><b>Kategorija:</b>&ensp;'.$selectedCategory.'</p>
                <p><b>Lokacija:</b>&ensp;'.$selectedLocation.'</p>
                <p><b>Količina:</b>&ensp;'.$selectedQuantity.'</p>
                <p><b>Dostava:</b>&ensp;'.$delivery.'</p>
                <p><b>Detaljan opis:</b><br>'.$selectedAbout.'</p>';
            }
            else if ($pageType == "ordinaryAdv"){
                $addForType .= '<p style="text-align: center; font-size: x-large; font-weight: bold;">'.$selectedTitle.'</p>
                <p style="text-align: center;"><b>Cena:</b>&ensp;'.$selectedPrice.'&euro;</p>
                <p><b>Prodavac:</b>&ensp;<a class="link-seller" onclick="loadSellerProfileForOthers('.$selectedSellerId.')">'.$currentUsernameSeller.'</a></p>
                <p><b>Kategorija:</b>&ensp;'.$selectedCategory.'</p>
                <p><b>Lokacija:</b>&ensp;'.$selectedLocation.'</p>
                <p><b>Količina:</b>&ensp;'.$selectedQuantity.'</p>
                <p><b>Dostava:</b>&ensp;'.$delivery.'</p>
                <p><b>Detaljan opis:</b><br>'.$selectedAbout.'</p>';
            }
            else if ($pageType == "ordinaryAdmin"){
                $addForType .= '<p style="text-align: center; font-size: x-large; font-weight: bold;">'.$selectedTitle.'</p>
                <p style="text-align: center;"><b>Cena:</b>&ensp;'.$selectedPrice.'&euro;</p>
                <p><b>Prodavac:</b>&ensp;<a class="link-seller" onclick="loadSellerProfileForAdmin('.$selectedSellerId.')">'.$currentUsernameSeller.'</a></p>
                <p><b>Kategorija:</b>&ensp;'.$selectedCategory.'</p>
                <p><b>Lokacija:</b>&ensp;'.$selectedLocation.'</p>
                <p><b>Količina:</b>&ensp;'.$selectedQuantity.'</p>
                <p><b>Dostava:</b>&ensp;'.$delivery.'</p>
                <p><b>Detaljan opis:</b><br>'.$selectedAbout.'</p>';
            }
            else if ($pageType == "customer"){
                $addForType .= 
                '<div style="display: flex;">
                    <div style="width: 50%;">
                        <p style="text-align: center; font-size: x-large; font-weight: bold;">'.$selectedTitle.'</p>
                        <p style="text-align: center;"><b>Cena:</b>&ensp;'.$selectedPrice.'&euro;</p>
                        <p><b>Prodavac:</b>&ensp;<a class="link-seller" onclick="loadSellerProfileForCustomers('.$selectedSellerId.')">'.$currentUsernameSeller.'</a></p>
                        <p><b>Kategorija:</b>&ensp;'.$selectedCategory.'</p>
                        <p><b>Lokacija:</b>&ensp;'.$selectedLocation.'</p>
                        <p><b>Količina:</b>&ensp;'.$selectedQuantity.'</p>
                        <p><b>Dostava:</b>&ensp;'.$delivery.'</p>
                        <p><b>Detaljan opis:</b><br>'.$selectedAbout.'</p>
                    </div>
                    <div style="width: 50%;">
                        <b style="font-size: xx-large;">Naručite:</b><br><br>
                        <h5>Način plaćanja:</h5><br>
                        <form method="post" action="submitPaymentType.php">
                        1. <input type="radio" name="paymentType" value="card"> Elektronski (kartica):<br>
                            Broj računa:<br><input type="text" name="cardNumber" value=""><br>
                            <span class="error">'.$_SESSION['errorAccount'].'</span>
                            <br>
                        2. <input type="radio" name="paymentType" value="cash"> Gotovina
                        <br><br>
                        <label for="quantityCustomer">Unesite količinu:</label><br>
                        <input style="width: 100px;" type="number" id="quantityCustomer" name="quantityCustomer" value="1" min="1" max="'.$selectedQuantity.'">
                        <br>
                        <input class="orderButton" type="submit" name="submit" value="Potvrdite narudžbinu"><br>
                        <span class="error">'.$_SESSION['errorEmpty'].'</span>
                        <span style="color: green;">'.$_SESSION['success'].'</span>
                        <span style="color: green;"><br>'.$_SESSION['yourBill'].'</span>
                        <span class="error">'.$_SESSION['already'].'</span>
                        </form><br>
                    </div>
                </div>';
            }
            else if ($pageType == "sellerOwn"){
                $addForType .= 
                '<div style="display: flex;">
                    <div style="width: 50%;">
                        <p style="text-align: center; font-size: x-large; font-weight: bold;">'.$selectedTitle.'</p>
                        <p style="text-align: center;"><b>Cena:</b>&ensp;'.$selectedPrice.'&euro;</p>
                        <p><b>Prodavac:</b>&ensp;<a class="link-seller" onclick="loadProfilePageSeller()">'.$currentUsernameSeller.'</a></p>
                        <p><b>Kategorija:</b>&ensp;'.$selectedCategory.'</p>
                        <p><b>Lokacija:</b>&ensp;'.$selectedLocation.'</p>
                        <p><b>Količina:</b>&ensp;'.$selectedQuantity.'</p>
                        <p><b>Dostava:</b>&ensp;'.$delivery.'</p>
                        <p><b>Detaljan opis:</b><br>'.$selectedAbout.'</p>
                    </div>
                    <div style="width: 50%;">
                        <br><br><br><button class="deleteButton" data-toggle="modal" data-target="#delete">Obrišite iz ponude</button><br><br>
                        <div class="modal fade" id="delete">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <div class="modal-title-text">
                                        <h3 class="modal-title"><b><i>POTVRDA BRISANJA</i></b></h3><br>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form action="deleteProduct.php?delete='.$productId.'" method="POST" style="text-align: center;">
                                            <input type="submit" value="Potvrdite brisanje"><br><br>
                                            <span style="font-size: 14px;"><b>Napomena: </b>Nakon što potvrdite proizvod se briše iz ponude.<br></span>
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
                        <br><button class="editButton" onclick="loadEditPage()">Uredite podatke o proizvodu</button><br>
                    </div>
                </div>';
            }
            echo $addForType;
            $_SESSION['errorEmpty'] = "";
            $_SESSION['errorAccount'] = "";
            $_SESSION['success'] = "";
            $_SESSION['already'] = "";
            $_SESSION['yourBill'] = "";
        ?>
        <br>
        <h3><b>Galerija:</b></h3><br>
        <div class="productImages">
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "password";
                $dBase = "KPdatabase";

                $connectForImages = new mysqli($servername, $username, $password, $dBase);

                $sqlImages = "SELECT idIm, idProductIm, imagePathIm FROM allImagesP WHERE idProductIm=$productId";
                $resultImages = $connectForImages->query($sqlImages);

                $imagesGallery = "";

                if ($resultImages->num_rows > 0) {
                    while($rowImages= $resultImages->fetch_assoc()) {
                        $imagesGallery .= '<a href="'.$rowImages["imagePathIm"].'"><img id="imgProduct" class="img-fluid" src="'.$rowImages["imagePathIm"].'" alt="Image of product"></a>';
                    }
                }
                echo $imagesGallery;
                $connectForImages->close();
            ?>

        </div>  
    </div> 
</body>
</html>