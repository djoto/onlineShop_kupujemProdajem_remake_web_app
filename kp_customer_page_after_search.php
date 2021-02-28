<!DOCTYPE html>
<html>
<!--
	Projekat kupujemProdajem (PIA 2020)
	-->
<head>
    <title>KP - Kupac</title>
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
        <li><a class="searchButton"><i class="fa fa-fw fa-search"></i> Pretraga</a></li>
        <li class="right">        
            <form action="logOut.php" method="POST" id="logOutForm">
                <input id="logOutButton" type="submit" name="logOutbutton" class="fa" value="&#xf08b; Odjava"/>
            </form></li>
        <li class="right"><a onclick="loadProfilePageCustomer()"><i class="fa fa-fw fa-home"></i> <?php echo $currentUsername;?></a></li>
    </ul>

    <div id="searchPanel">
        <div class="searchTitle">
            <form action="#">
                <input id="yourTitleToSearch" type="text" placeholder="Pretraži po nazivu..." name="search">
                <button type="button" class="submitSearch" onclick="searchByTitleCustomer()">Pretraži</button>
            </form>
        </div>
        <div class="searchCategory">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" style="background-color: #ccc; border: none;">Kategorije
                    <span class="caret"></span>
                </button>
                <div class="dropdown-menu">
                    <div class="categories" style="display: flex;">
                        <div id="col" style="margin: 5px 15px 5px 15px;">
                        <a href="#" onclick="loadCustomerPage()">SVE</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Alati i oruđa')">Alati i oruđa</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Antikviteti')">Antikviteti</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Audio uređaji')">Audio uređaji</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Automobili i oprema')">Automobili i oprema</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Bebi oprema i stvari')">Bebi oprema i stvari</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Bela tehnika i kucni aparati')">Bela tehnika i kucni aparati</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Bicikli i oprema')">Bicikli i oprema</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Časopisi i stripovi')">Časopisi i stripovi</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Cveće')">Cveće</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Domaća hrana')">Domaća hrana</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Domaće životinje')">Domaće životinje</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Dvorište i bašta')">Dvorište i bašta</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Elektronika i komponente')">Elektronika i komponente</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Firme')">Firme</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Foto')">Foto</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Građevinarstvo')">Građevinarstvo</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Igračke i igre')">Igračke i igre</a><br>
                        </div>
                        <div id="col" style="margin: 5px 10px 5px 10px;">
                        <a href="#" onclick="searchByCategoryCustomer('Industrijska oprema')">Industrijska oprema</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Kamioni')">Kamioni</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Knjige')">Knjige</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Kolekcionarstvo')">Kolekcionarstvo</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Konzole i igrice')">Konzole i igrice</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Kozmetika')">Kozmetika</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Kućni ljubimci')">Kućni ljubimci</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Kupatilo i oprema')">Kupatilo i oprema</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Lov i ribolov')">Lov i ribolov</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Mobilni telefoni i oprema')">Mobilni telefoni i oprema</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Motocikli i oprema')">Motocikli i oprema</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Muzika i instrumenti')">Muzika i instrumenti</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Nakit, satovi i dragocenosti')">Nakit, satovi i dragocenosti</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Nameštaj')">Nameštaj</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Nega lica i tela')">Nega lica i tela</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Nekretnine')">Nekretnine</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Obuća')">Obuća</a><br>
                        </div>    
                        <div id="col" style="margin: 5px 10px 5px 10px;">
                        <a href="#" onclick="searchByCategoryCustomer('Odeća')">Odeća</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Odmor')">Odmor</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Oprema za poslovanje')">Oprema za poslovanje</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Oprema u zdravstvu')">Oprema u zdravstvu</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Plovni objekti')">Plovni objekti</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Poljoprivreda')">Poljoprivreda</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Računari i oprema')">Računari i oprema</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Sport i razonoda')">Sport i razonoda</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Školski pribor i udžbenici')">Školski pribor i udžbenici</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Torbe, novčanici i asesoari')">Torbe, novčanici i asesoari</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('TV i video uređaji')">TV i video uređaji</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Ugostiteljstvo i oprema')">Ugostiteljstvo i oprema</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Umetnička dela')">Umetnička dela</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('Uređenje kuće')">Uređenje kuće</a><br>
                        <a href="#" onclick="searchByCategoryCustomer('OSTALO')">OSTALO</a><br>
                        </div>           
                    </div>
                </div>
            </div>
        </div>
        <div class="searchPrice">
            <form action="#">
                <span style="font-size: 15px; color: black;">Cena(EUR):<span>
                <input id="priceFrom" type="text" placeholder="od" name="search" style="width: 50px;">
                <span style="font-size: 15px; color: black;"> - <span>
                <input id="priceTo" type="text" placeholder="do" name="search" style="width: 50px;">
                <button type="button" class="submitSearch" onclick="searchByPriceCustomer()">Pretraži</button>
            </form>
        </div>
    </div>



    <div id="allProducts" class="container-fluid"><br>
    <div class="products">
            <?php
            $searchType = $_GET["type"];
            if ($searchType == "byTitle" || $searchType == "byCategory"){
                $regexStr = $_GET["regex"];
                $regexStrLowerCase = strtolower($regexStr);
                $pattern = "/".$regexStrLowerCase."/i";
            }
            else if ($searchType == "byPrice"){
                $regexFrom = $_GET["from"];
                $numberFrom = (float)$regexFrom;
                $regexTo = $_GET["to"];
                $numberTo = (float)$regexTo;
            }


            $servername = "localhost";
            $username = "root";
            $password = "password";
            $dBase = "KPdatabase";

            $connectForProducts = new mysqli($servername, $username, $password, $dBase);

            $fromProductsSelected = "SELECT idP, idS, titleP, priceP, categoryP, locationP, quantityP, deliveryTypeP, aboutP FROM allProductsKP";
            $resultProductsSelection = $connectForProducts->query($fromProductsSelected);
            $productsAll = "";
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
                $customer = "customer";
                $idPr = $rowProducts["idP"];

                $lowerCaseStrTitle = strtolower($rowProducts["titleP"]);
                $lowerCaseStrCategory = strtolower($rowProducts["categoryP"]);
                $numberPrice = (float)$rowProducts["priceP"];

                if ($searchType == "byTitle" && (preg_match($pattern, $lowerCaseStrTitle) != 0)){
                    $productsAll .= '<div class="product" id="product'.$elementIdNum.'"><a class="link-product" id="'.$rowProducts["idP"].'" onclick="loadProductPageCustomer('.$idPr.')">
                    <img src="'.$homeImagePath.'" alt="productPicture">
                        <div class="describe-product">
                            <div class="describeTitle" id="describeTitle"><span id="ProductTitle'.$elementIdNum.'">'.$rowProducts["titleP"].'</span></div>
                            <div class="describePrice">'.$rowProducts["priceP"].'&euro;</div>
                        </div>
                        </a>
                    </div>';
                    $elementIdNum++;
                }
                if ($searchType == "byCategory" && (preg_match($pattern, $lowerCaseStrCategory) != 0)){
                    $productsAll .= '<div class="product" id="product'.$elementIdNum.'"><a class="link-product" id="'.$rowProducts["idP"].'" onclick="loadProductPageCustomer('.$idPr.')">
                    <img src="'.$homeImagePath.'" alt="productPicture">
                        <div class="describe-product">
                            <div class="describeTitle" id="describeTitle"><span id="ProductTitle'.$elementIdNum.'">'.$rowProducts["titleP"].'</span></div>
                            <div class="describePrice">'.$rowProducts["priceP"].'&euro;</div>
                        </div>
                        </a>
                    </div>';
                    $elementIdNum++;
                }
                if ($searchType == "byPrice" && $numberPrice >= $numberFrom && $numberPrice <= $numberTo){
                    $productsAll .= '<div class="product" id="product'.$elementIdNum.'"><a class="link-product" id="'.$rowProducts["idP"].'" onclick="loadProductPageCustomer('.$idPr.')">
                    <img src="'.$homeImagePath.'" alt="productPicture">
                        <div class="describe-product">
                            <div class="describeTitle" id="describeTitle"><span id="ProductTitle'.$elementIdNum.'">'.$rowProducts["titleP"].'</span></div>
                            <div class="describePrice">'.$rowProducts["priceP"].'&euro;</div>
                        </div>
                        </a>
                    </div>';
                    $elementIdNum++;
                }
            }
            echo $productsAll;
            $connectForProducts->close();
            ?>
        </div>
    </div> 


 
</body>
</html>