<!DOCTYPE html>
<html>
<!--
	Projekat kupujemProdajem (PIA 2020)
	-->
<head>
    <title>KP - Prodavac - Profil</title>
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
        <li><a onclick="loadSellerPage()" style="padding: 0;"><img id="logo" src="images/logoo.jpg" alt="pageLogo"></a></li>
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
        Tip naloga: <b><i>prodavac</i></b>
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "password";
            $dBase = "KPdatabase";

            $connectForAverageGrade = new mysqli($servername, $username, $password, $dBase);

            $sqlForAverageGrade = "SELECT idR, idCustomerR, idSellerR, gradeR, commentR FROM ratesKP WHERE idSellerR=$currentId";
            $resultForAverageGrade = $connectForAverageGrade->query($sqlForAverageGrade);
            
            $numOfGrades = 0;
            $sumOfGrades = 0;

            if ($resultForAverageGrade->num_rows > 0) {
                while($rowForAverageGrade = $resultForAverageGrade->fetch_assoc()) {
                    $sumOfGrades += (int)$rowForAverageGrade["gradeR"];
                    $numOfGrades++;
                }
            }

            if($numOfGrades == 0){
                $averageGradeStr = "Bez ocena.";
            }
            else{
                $averageGrade = (float)$sumOfGrades / $numOfGrades;
                $averageGradeStr = number_format((float)$averageGrade , 2, '.', '')." / 10.00";
            }
            $connectForAverageGrade->close();
        ?>
        <br>
        Prosečna ocena: <b><i><?php echo $averageGradeStr; ?></i></b>
        <br>
        <br>
        <!-- <p style="text-align: center; margin-top: 30px;"><b>Moje narudžbine:</b></p> -->
        
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" id="myP">
                <a class="nav-link" data-toggle="tab" href="#myProducts">Moja ponuda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#orders">Narudžbine</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#rates">Ocene i komentari</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#add">Dodaj proizvod</a>
            </li>
        </ul>

        <div class="tab-content" style="background-color: #ccc;">
            <div id="myProducts" class="container tab-pane fade" style="background-color: #ccc; margin: 0px;"><br>
                <div class="products">
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "password";
                    $dBase = "KPdatabase";

                    $connectForProducts = new mysqli($servername, $username, $password, $dBase);

                    $fromProductsSelected = "SELECT idP, idS, titleP, priceP, categoryP, locationP, quantityP, deliveryTypeP, aboutP FROM allProductsKP WHERE idS=$currentId";
                    $resultProductsSelection = $connectForProducts->query($fromProductsSelected);
                    $productsSellerOwn = "";
                    $elementIdNum = 1;
                    while($rowProducts = $resultProductsSelection->fetch_assoc()) {
                        $currentSellerId = $rowProducts["idS"];
                        $currentProductId = $rowProducts["idP"];
                        $fromImagesSelected = "SELECT idProductIm, imagePathIm FROM allImagesP WHERE idProductIm=$currentProductId";
                        $resultImagesSelection = $connectForProducts->query($fromImagesSelected);
                        $toGetFirst = 0;
                        $homeImagePath = "";
                        while($rowImages = $resultImagesSelection->fetch_assoc()){
                            if ($toGetFirst == 0){
                                $homeImagePath = $rowImages["imagePathIm"];
                            }
                            $toGetFirst++;
                        }
                        $idPr = $rowProducts["idP"];
                        $productsSellerOwn .= '<div class="product" id="product'.$elementIdNum.'"><a class="link-product" id="'.$rowProducts["idP"].'" onclick="loadProductPageSellerOwn('.$idPr.')">
                        <img src="'.$homeImagePath.'" alt="productPicture">
                            <div class="describe-product">
                                <div class="describeTitle" id="describeTitle"><span id="ProductTitle'.$elementIdNum.'">'.$rowProducts["titleP"].'</span></div>
                                <div class="describePrice">'.$rowProducts["priceP"].'&euro;</div>
                            </div>
                            </a>
                        </div>';
                        $elementIdNum++;
                    }
                    if($productsSellerOwn == ""){
                        $productsSellerOwn = "Još nema objavljenih proizvoda.";
                    }
                    echo $productsSellerOwn;
                    $connectForProducts->close();
                    ?>
                </div>
            </div>

            <div id="orders" class="container tab-pane fade"  style="background-color: #ccc; margin: 0px;"><br>
                <div style="text-align: center; padding-bottom: 20px;">
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "password";
                    $dBase = "KPdatabase";

                    $connectForOrdersSeller = new mysqli($servername, $username, $password, $dBase);

                    $fromOrdersSeller = "SELECT idO, idCustomerO, idSellerO, idProductO, acceptedO, deniedO, cancelledO, paymentTypeO, quantityO FROM KPallOrders WHERE idSellerO=$currentId";
                    $resultOrdersSeller = $connectForOrdersSeller->query($fromOrdersSeller);
                    $ordersSellerAll = "";
                    $numOrders = 0;
                    while($rowOrdersSeller = $resultOrdersSeller->fetch_assoc()) {
                        $currentOrderId = $rowOrdersSeller["idO"];
                        $currentCustomerId = $rowOrdersSeller["idCustomerO"];
                        $currentSellerId = $rowOrdersSeller["idSellerO"];
                        $_SESSION['currentSellerId'] = $currentSellerId;
                        $currentProductId = $rowOrdersSeller["idProductO"];
                        $currentAcceptedStatus = $rowOrdersSeller["acceptedO"];
                        $currentDeniedStatus = $rowOrdersSeller["deniedO"];
                        $currentCancelledStatus = $rowOrdersSeller["cancelledO"];
                        $currentPaymentType = $rowOrdersSeller["paymentTypeO"];
                        $currentQuantityO = $rowOrdersSeller["quantityO"];

                        $fromProductsSelected = "SELECT idP, titleP, priceP FROM allProductsKP WHERE idP=$currentProductId";
                        $resultProductsSelection = $connectForOrdersSeller->query($fromProductsSelected);
                        $currentProductTitle = "";
                        $currentProductPrice = "";
                        while($rowProducts = $resultProductsSelection->fetch_assoc()){
                            $currentProductTitle = $rowProducts["titleP"];
                            $currentProductPrice = $rowProducts["priceP"];
                        }

                        $fromUsersSelected = "SELECT idU, usernameU FROM allUsersKP WHERE idU=$currentCustomerId";
                        $resultUsersSelection = $connectForOrdersSeller->query($fromUsersSelected);
                        $currentUsernameCustomer = "";
                        while($rowUsers = $resultUsersSelection->fetch_assoc()){
                            $currentUsernameCustomer = $rowUsers["usernameU"];
                        }
                        $currentStatusString = "Čeka se potvrda.";
                        if ($currentAcceptedStatus == "yes" && $currentDeniedStatus == "no"){
                            $currentStatusString = "Odobreno.";
                        }
                        else if ($currentAcceptedStatus == "no" && $currentDeniedStatus == "yes"){
                            $currentStatusString = "Odbijeno.";
                        }
                        $ordersSellerAll .= '<div class="orderSeller">
                        <a class="link-orderSeller" onclick="loadProductPageSellerOwn('.$currentProductId.')">'.$currentProductTitle.' '.$currentProductPrice.'&euro;</a>, Količina: '.$currentQuantityO.', 
                        Kupac: <a class="link-seller" onclick="loadCustomerProfileForOthers('.$currentCustomerId.')">'.$currentUsernameCustomer.'</a><span>, Način plaćanja: '.$currentPaymentType.', Status: '.$currentStatusString.'</span>';
                        if ($currentStatusString == "Čeka se potvrda."){
                            $ordersSellerAll .= '
                                <br><button class="confirmButton" data-toggle="modal" data-target="#accept'.$numOrders.'">Odobrite narudžbinu</button>
                                <div class="modal fade" id="accept'.$numOrders.'">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <div class="modal-title-text">
                                                <h3 class="modal-title"><b><i>ODOBRAVANJE NARUDŽBINE</i></b></h3><br>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form action="acceptOrder.php?accept='.$currentOrderId.'" method="POST" style="text-align: center;">
                                                    <input id="acceptButton" type="submit" name="acceptButton" value="Odobrite narudžbinu"><br><br>
                                                    <span style="font-size: 14px;"><b>Napomena:</b> Kada odobrite narudžbinu više je ne možete odbiti.</span>
                                                </form>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Zatvori</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="confirmButton" data-toggle="modal" data-target="#deny'.$numOrders.'">Odbijte narudžbinu</button><br><br>
                                <div class="modal fade" id="deny'.$numOrders.'">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <div class="modal-title-text">
                                                <h3 class="modal-title"><b><i>ODBIJANJE NARUDŽBINE</i></b></h3><br>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form action="denyOrder.php?deny='.$currentOrderId.'" method="POST" style="text-align: center;">
                                                    <input id="denyButton" type="submit" name="denyButton" value="Odbijte narudžbinu"><br><br>
                                                    <span style="font-size: 14px;"><b>Napomena:</b> Nakon što odbijete narudžbinu više je ne možete prihvatiti.</span>
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
                            else{
                                $ordersSellerAll .= '<br>
                                </div>';
                            }
                    $numOrders++;
                    }

                    if($ordersSellerAll == ""){
                        $ordersSellerAll = "Još nema narudžbina.";
                    }
                    echo $ordersSellerAll;
                    $connectForOrdersSeller->close();
                    ?>
                </div>
            </div>

            <div id="rates" class="container tab-pane fade" style="background-color: #ccc; margin: 0px;"><br>
                <div style="text-align: center; padding-bottom: 20px;">
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "password";
                    $dBase = "KPdatabase";

                    $connectForRates = new mysqli($servername, $username, $password, $dBase);

                    $fromRatesSelected = "SELECT idR, idCustomerR, idSellerR, gradeR, commentR FROM ratesKP WHERE idSellerR=$currentId";
                    $resultRatesSelection = $connectForRates->query($fromRatesSelected);
                    $ratesSeller = "";
                    while($rowRates = $resultRatesSelection->fetch_assoc()) {
                        $currentCustomerId = $rowRates["idCustomerR"];
                        $fromUsersSelected = "SELECT idU, usernameU FROM allUsersKP WHERE idU=$currentCustomerId";
                        $resultUsersSelection = $connectForRates->query($fromUsersSelected);

                        while($rowUsers = $resultUsersSelection->fetch_assoc()){
                            $currentCustomerUsername = $rowUsers["usernameU"];

                        }
                
                        if($rowRates["commentR"] == ""){
                            $comment = "Bez komentara.";
                        }
                        else{
                            $comment = $rowRates["commentR"];
                        }

                        $ratesSeller .= '<div class="ratesSeller">
                        Ocena od kupca <a class="link-customer" onclick="loadCustomerProfileForOthers('.$currentCustomerId.')">'.$currentCustomerUsername.'</a>: '.$rowRates["gradeR"].'<br>
                        Komentar: '.$comment.'<br>
                        </div><br>';
                    }
                    if($ratesSeller == ""){
                        $ratesSeller = "Još nema ocena.";
                    }
                    echo $ratesSeller;
                    $connectForRates->close();
                    ?>
                </div>
            </div>

            <div id="add" class="container tab-pane active" style="background-color: #ccc; margin: 0px;"><br>
                <div style="text-align: center; padding-bottom: 20px;">
                    <?php
                        include("addProduct.php");
                    ?>
                    <h2>Dodajte proizvod u ponudu:</h2>
                    <span class="error"><?php echo $successOrError;?></span><br><br>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">  
                        Naslov proizvoda: <br>
                        <input id="yourInput" type="text" name="addTitle">
                        <br>
                        <span class="error"><?php echo $addTitleErr;?></span>
                        <br>
                        Cena(&euro;): <br>
                        <input id="yourInput" type="text" name="addPrice">
                        <br>
                        <span class="error"><?php echo $addPriceErr;?></span>
                        <br>
                        Kategorija: <br>
                        <select id="yourInput" name="addCategory" >
                            <option value="Alati i oruđa">Alati i oruđa</option>
                            <option value="Antikviteti">Antikviteti</option>
                            <option value="Audio uređaji">Audio uređaji</option>
                            <option value="Automobili i oprema">Automobili i oprema</option>
                            <option value="Bebi oprema i stvari">Bebi oprema i stvari</option>
                            <option value="Bela tehnika i kucni aparati">Bela tehnika i kucni aparati</option>
                            <option value="Bicikli i oprema">Bicikli i oprema</option>
                            <option value="Časopisi i stripovi">Časopisi i stripovi</option>
                            <option value="Cveće">Cveće</option>
                            <option value="Domaća hrana">Domaća hrana</option>
                            <option value="Domaće životinje">Domaće životinje</option>
                            <option value="Dvorište i bašta">Dvorište i bašta</option>
                            <option value="Elektronika i komponente">Elektronika i komponente</option>
                            <option value="Firme">Firme</option>
                            <option value="Foto">Foto</option>
                            <option value="Građevinarstvo">Građevinarstvo</option>
                            <option value="Igračke i igre">Igračke i igre</option>
                            <option value="Industrijska oprema">Industrijska oprema</option>
                            <option value="Kamioni">Kamioni</option>
                            <option value="Knjige">Knjige</option>
                            <option value="Kolekcionarstvo">Kolekcionarstvo</option>
                            <option value="Konzole i igrice">Konzole i igrice</option>
                            <option value="Kozmetika">Kozmetika</option>
                            <option value="Kućni ljubimci">Kućni ljubimci</option>
                            <option value="Kupatilo i oprema">Kupatilo i oprema</option>
                            <option value="Lov i ribolov">Lov i ribolov</option>
                            <option value="Mobilni telefoni i oprema">Mobilni telefoni i oprema</option>
                            <option value="Motocikli i oprema">Motocikli i oprema</option>
                            <option value="Muzika i instrumenti">Muzika i instrumenti</option>
                            <option value="Nakit, satovi i dragocenosti">Nakit, satovi i dragocenosti</option>
                            <option value="Nameštaj">Nameštaj</option>
                            <option value="Nega lica i tela">Nega lica i tela</option>
                            <option value="Nekretnine">Nekretnine</option>
                            <option value="Obuća">Obuća</option>
                            <option value="Odeća">Odeća</option>
                            <option value="Odmor">Odmor</option>
                            <option value="Oprema za poslovanje">Oprema za poslovanje</option>
                            <option value="Oprema u zdravstvu">Oprema u zdravstvu</option>
                            <option value="Plovni objekti">Plovni objekti</option>
                            <option value="Poljoprivreda">Poljoprivreda</option>
                            <option value="Računari i oprema">Računari i oprema</option>
                            <option value="Sport i razonoda">Sport i razonoda</option>
                            <option value="Školski pribor i udžbenici">Školski pribor i udžbenici</option>
                            <option value="Torbe, novčanici i asesoari">Torbe, novčanici i asesoari</option>
                            <option value="TV i video uređaji">TV i video uređaji</option>
                            <option value="Ugostiteljstvo i oprema">Ugostiteljstvo i oprema</option>
                            <option value="Umetnička dela">Umetnička dela</option>
                            <option value="Uređenje kuće">Uređenje kuće</option>
                            <option value="OSTALO">OSTALO</option>
                        </select>
                        <br>
                        <span class="error"><?php echo $addCategoryErr;?></span>
                        <br>
                        Lokacija (Grad): <br>
                        <input id="yourInput" type="text" name="addLocation">
                        <br>
                        <span class="error"><?php echo $addLocationErr;?></span>
                        <br>
                        Količina: <br>
                        <input id="yourInput" type="number" name="addQuantity" value="1" min="1" max="10000">
                        <br>
                        <span class="error"><?php echo $addQuantityErr;?></span>
                        <br>


                        Odaberite slike proizvoda (minimalno 1 maksimalno 10):<br>
                        <input type="file" name="fileToUpload[]" id="fileToUpload"><br>
                        <input type="file" name="fileToUpload[]" id="fileToUpload"><br>
                        <input type="file" name="fileToUpload[]" id="fileToUpload"><br>
                        <input type="file" name="fileToUpload[]" id="fileToUpload"><br>
                        <input type="file" name="fileToUpload[]" id="fileToUpload"><br>
                        <input type="file" name="fileToUpload[]" id="fileToUpload"><br>
                        <input type="file" name="fileToUpload[]" id="fileToUpload"><br>
                        <input type="file" name="fileToUpload[]" id="fileToUpload"><br>
                        <input type="file" name="fileToUpload[]" id="fileToUpload"><br>
                        <input type="file" name="fileToUpload[]" id="fileToUpload"><br>
                        <span class="error"><?php echo $errorFile;?></span>
                        <br>
                        <br>
                        Dostava: <br>
                        <select id="yourInput" name="addDelivery">
                            <option value="yes">Da</option>
                            <option value="no">Ne</option>
                        </select>
                        <br>
                        <span class="error"><?php echo $addDeliveryErr;?></span>
                        <br>
                        Detaljan opis: <br>
                        <textarea id="yourInput" type="text" name="addAbout" rows="7"></textarea>
                        <br>
                        <span class="error"><?php echo $addAboutErr;?></span>
                        <br>
                        <input id="submitFormToAddProduct" type="submit" name="submit" value="Dodajte u ponudu">  
                        <br><br>
                    </form> 
                </div>
            </div>

        </div>

    </div>
 
</body>
</html>