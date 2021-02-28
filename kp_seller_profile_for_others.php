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
        <?php 
            $homeLink = "";
            if ($_GET["user"] == "other"){
                $homeLink .= '<li><a onclick="loadSellerPage()" style="padding: 0;"><img id="logo" src="images/logoo.jpg" alt="pageLogo"></a></li>'; 
            }
            else if ($_GET["user"] == "customer"){
                $homeLink .= '<li><a onclick="loadCustomerPage()" style="padding: 0;"><img id="logo" src="images/logoo.jpg" alt="pageLogo"></a></li>';
            }
            else if ($_GET["user"] == "admin") {
                $homeLink .= '<li><a onclick="loadAdminPage()" style="padding: 0;"><img id="logo" src="images/logoo.jpg" alt="pageLogo"></a></li>';
            }
            echo $homeLink;
        ?>
        <li class="right"><a onclick="goBack()"><i class="fa fa-arrow-left"></i> Nazad</a></li>
    </ul>

    <?php
        $IdSellerToView = $_GET["ids"];
        $userTypeToView = $_GET["user"];
        
        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dBase = "KPdatabase";

        $connectToViewSeller = new mysqli($servername, $username, $password, $dBase);

        $fromUsersToViewSeller = "SELECT idU, firstnameU, lastnameU, emailU, usernameU FROM allUsersKP WHERE idU=$IdSellerToView";
        $resultUsersToViewSeller = $connectToViewSeller->query($fromUsersToViewSeller);

        while($rowUsersToViewSeller = $resultUsersToViewSeller->fetch_assoc()){
            $sellerFirstnameToView = $rowUsersToViewSeller["firstnameU"];
            $sellerLastnameToView = $rowUsersToViewSeller["lastnameU"];
            $sellerEmailToView = $rowUsersToViewSeller["emailU"];
            $sellerUsernameToView = $rowUsersToViewSeller["usernameU"];
        }
                
    ?>

    <div class="container" id="profilePanel">
        Ime i prezime: <b><i><?php echo $sellerFirstnameToView." ".$sellerLastnameToView;?></i></b>
        <br>
        Korisničko ime: <b><i><?php echo $sellerUsernameToView;?><br></i></b>
        E-mail: <b><i><?php echo $sellerEmailToView;?><br></i></b>
        Tip naloga: <b><i>prodavac</i></b>
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "password";
            $dBase = "KPdatabase";

            $connectForAverageGrade = new mysqli($servername, $username, $password, $dBase);

            $sqlForAverageGrade = "SELECT idR, idCustomerR, idSellerR, gradeR, commentR FROM ratesKP WHERE idSellerR=$IdSellerToView";
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
                <a class="nav-link" data-toggle="tab" href="#rates">Ocene i komentari</a>
            </li>
        </ul>

        <div class="tab-content" style="background-color: #ccc;">

            <div id="myProducts" class="container tab-pane active" style="background-color: #ccc; margin: 0px;"><br>
                <div class="products">
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "password";
                    $dBase = "KPdatabase";

                    $connectForProducts = new mysqli($servername, $username, $password, $dBase);

                    $fromProductsSelected = "SELECT idP, idS, titleP, priceP, categoryP, locationP, quantityP, deliveryTypeP, aboutP FROM allProductsKP WHERE idS=$IdSellerToView";
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
                        if ($userTypeToView == "other"){
                            $productsSellerOwn .= '<div class="product" id="product'.$elementIdNum.'"><a class="link-product" id="'.$rowProducts["idP"].'" onclick="loadProductPageOrdinaryAdvanced('.$idPr.')">
                            <img src="'.$homeImagePath.'" alt="productPicture">
                                <div class="describe-product">
                                    <div class="describeTitle" id="describeTitle"><span id="ProductTitle'.$elementIdNum.'">'.$rowProducts["titleP"].'</span></div>
                                    <div class="describePrice">'.$rowProducts["priceP"].'&euro;</div>
                                </div>
                                </a>
                            </div>';
                        }
                        if ($userTypeToView == "admin"){
                            $productsSellerOwn .= '<div class="product" id="product'.$elementIdNum.'"><a class="link-product" id="'.$rowProducts["idP"].'" onclick="loadProductPageOrdinaryAdmin('.$idPr.')">
                            <img src="'.$homeImagePath.'" alt="productPicture">
                                <div class="describe-product">
                                    <div class="describeTitle" id="describeTitle"><span id="ProductTitle'.$elementIdNum.'">'.$rowProducts["titleP"].'</span></div>
                                    <div class="describePrice">'.$rowProducts["priceP"].'&euro;</div>
                                </div>
                                </a>
                            </div>';
                        }
                        else if ($userTypeToView == "customer"){
                            $productsSellerOwn .= '<div class="product" id="product'.$elementIdNum.'"><a class="link-product" id="'.$rowProducts["idP"].'" onclick="loadProductPageCustomer('.$idPr.')">
                            <img src="'.$homeImagePath.'" alt="productPicture">
                                <div class="describe-product">
                                    <div class="describeTitle" id="describeTitle"><span id="ProductTitle'.$elementIdNum.'">'.$rowProducts["titleP"].'</span></div>
                                    <div class="describePrice">'.$rowProducts["priceP"].'&euro;</div>
                                </div>
                                </a>
                            </div>';
                        }
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

            <div id="rates" class="container tab-pane fade" style="background-color: #ccc; margin: 0px;"><br>
                <div style="text-align: center; padding-bottom: 20px;">
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "password";
                    $dBase = "KPdatabase";

                    $connectForRates = new mysqli($servername, $username, $password, $dBase);

                    $fromRatesSelected = "SELECT idR, idCustomerR, idSellerR, gradeR, commentR FROM ratesKP WHERE idSellerR=$IdSellerToView";
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

        </div>

    </div>
 
</body>
</html>