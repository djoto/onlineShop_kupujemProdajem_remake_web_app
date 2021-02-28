<!DOCTYPE html>
<html>
<!--
	Projekat kupujemProdajem (PIA 2020)
	-->
<head>
    <title>KP - UređivanjeProizvoda</title>
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

        $productIdToEdit = $_SESSION['productId'];
    ?>

    <ul class="topnav">
        <li><a onclick="loadSellerPage()" style="padding: 0;"><img id="logo" src="images/logoo.jpg" alt="pageLogo"></a></li>
        <li class="right"><a onclick="goBack()"><i class="fa fa-arrow-left"></i> Nazad</a></li>
    </ul>

    <?php
   
       $editTitleErr = $editPriceErr = $editCategoryErr = $editLocationErr = $editQuantityErr = $editDeliveryErr = $editAboutErr = "";
   
       $successOrErrorEdit = "";
   
       $servername = "localhost";
       $username = "root";
       $password = "password";
       $dBase = "KPdatabase";
   
       $connectToEdit = new mysqli($servername, $username, $password, $dBase);

       $selectFromProducts = "SELECT titleP, priceP, categoryP, locationP, quantityP, deliveryTypeP, aboutP FROM allProductsKP WHERE idP=$productIdToEdit";
       $selectedWithProductId = $connectToEdit->query($selectFromProducts);


       if ($selectedWithProductId ->num_rows > 0) {

           while($rowSelected = $selectedWithProductId->fetch_assoc()) {
               $editTitle = $rowSelected["titleP"];
               $editPrice = $rowSelected["priceP"];
               $editCategory = $rowSelected["categoryP"];
               $editLocation = $rowSelected["locationP"];
               $editQuantity = $rowSelected["quantityP"];
               $editDelivery = $rowSelected["deliveryTypeP"];
               if($editDelivery == "yes"){
                   $delivery = "Da";
               }
               else{
                   $delivery = "Ne";
               }
               $editAbout = $rowSelected["aboutP"];
           }
       }
       
   
       $imagePathI = "";

       $stmti = $connectToEdit->prepare("INSERT INTO allImagesP (idProductIm, imagePathIm) VALUES (?, ?)");
       $stmti->bind_param("ss", $productIdToEdit, $imagePathI);

       
       $counterCheckToEdit = 0;
       
       $counter = 0;
   
       $errorFile = "";

       $photos = array();
   
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
            if (empty($_POST["editTitle"]) || ($_POST["editTitle"] == " ")) {
                $editTitleErr = "* Polje je obavezno.";
                $successOrErrorEdit = "<span class=\"error\">Neispravan unos!</span>";
            } else {
                $editTitle = test_input($_POST["editTitle"]);
                $counterCheckToEdit++;
            }

            if (empty($_POST["editPrice"]) || ($_POST["editPrice"] == " ")) {
                $editPriceErr = "* Polje je obavezno.";
                $successOrErrorEdit = "<span class=\"error\">Neispravan unos!</span>";
            } else {
                $editPrice = test_input($_POST["editPrice"]);
                if (is_numeric($editPrice)){
                    $counterCheckToEdit++;
                }
                else {
                    $editPriceErr = "* Može sadržati samo brojeve i decimalnu tačku.";
                }
            }

            if (empty($_POST["editCategory"])) {
                $editCategoryErr = "* Polje je obavezno.";
                $successOrErrorEdit = "<span class=\"error\">Neispravan unos!</span>";
            } else {
                $editCategory = test_input($_POST["editCategory"]);
                $counterCheckToEdit++;
            }

            if (empty($_POST["editLocation"]) || ($_POST["editLocation"] == " ")) {
                $editLocationErr = "* Polje je obavezno.";
                $successOrErrorEdit = "<span class=\"error\">Neispravan unos!</span>";
            } else {
                $editLocation = test_input($_POST["editLocation"]);
                $counterCheckToEdit++;
            }

            if (empty($_POST["editQuantity"])) {
                $editQuantityErr = "* Polje je obavezno.";
                $successOrErrorEdit = "<span class=\"error\">Neispravan unos!</span>";
            } else {
                $editQuantity = test_input($_POST["editQuantity"]);
                $counterCheckToEdit++;
            }

            if (empty($_POST["editDelivery"])) {
                $editDeliveryErr = "* Polje je obavezno.";
                $successOrErrorEdit = "<span class=\"error\">Neispravan unos!</span>";
            } else {
                $editDelivery = test_input($_POST["editDelivery"]);
                $counterCheckToEdit++;
            }

            if (empty($_POST["editAbout"]) || ($_POST["editAbout"] == " ")) {
                $editAboutErr = "* Polje je obavezno.";
                $successOrErrorEdit = "<span class=\"error\">Neispravan unos!</span>";
            } else {
                $editAbout = test_input($_POST["editAbout"]);
                $counterCheckToEdit++;
            }


            foreach ($_FILES['fileToUpload']['name'] as $f => $name) {
                if ($name == ""){
                    $counter++;
                }
                else{
                    $allowedExts = array("gif", "jpeg", "jpg", "png");
                    $temp = explode(".", $name);
                    $extension = end($temp);

                    if ((($_FILES["fileToUpload"]["type"][$f] == "image/gif")
                    || ($_FILES["fileToUpload"]["type"][$f] == "image/jpeg")
                    || ($_FILES["fileToUpload"]["type"][$f] == "image/jpg")
                    || ($_FILES["fileToUpload"]["type"][$f] == "image/png"))
                    && ($_FILES["fileToUpload"]["size"][$f] < 2000000)
                    && in_array($extension, $allowedExts)) {
                        if ($_FILES["fileToUpload"]["error"][$f] > 0) {
                            // echo "Return Code: " . $_FILES["fileToUpload"]["error"][$f] . "<br>";
                        }
                        else {
                            if (file_exists("images/" . $name)){
                                //not probably to happens (because of uniqid())
                            }
                            else{
                                $imagePath = "images/" . uniqid() . "_" . $name;
                                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$f], $imagePath);
                                $photos[count($photos)] = $imagePath;
                                //$stmti->execute();
                            }
                        }
                    }
                    else {
                        $error =  "Neispravan unos fajla: ".$name;
                        $successOrErrorEdit = "<span class=\"error\">Neispravan unos!</span>";
                        $errorFile = $error;
                    }
                }
            }
            if ($counter == 10){
                $error =  "Obavezno učitavanje bar jedne slike!";
                $successOrErrorEdit = "<span class=\"error\">Neispravan unos!</span>";
                $errorFile = $error;
            }


        }


        if ($counterCheckToEdit == 7 && $errorFile == ""){
            $editTitle = $editTitle . " (izmenjeno)";
            $updateProductData = "UPDATE allProductsKP SET titleP='$editTitle', priceP='$editPrice', categoryP='$editCategory', locationP='$editLocation', quantityP='$editQuantity', deliveryTypeP='$editDelivery', aboutP='$editAbout' WHERE idP=$productIdToEdit";
            if ($connectToEdit->query($updateProductData) === TRUE) {
                //echo "Record updated successfully";
            } else {
                //echo "Error updating record: " . $conn->error;
            }


            $updateOrdersData = "UPDATE KPallOrders SET acceptedO='no' WHERE idProductO=$productIdToEdit";
            if ($connectToEdit->query($updateProductData) === TRUE) {
                //echo "Record updated successfully";
            } else {
                //echo "Error updating record: " . $conn->error;
            }

            $deleteFromImages = "DELETE FROM allImagesP WHERE idProductIm=$productIdToEdit";
            if ($connectToEdit->query($deleteFromImages) === TRUE) {
                //echo "Record deleted successfully";
            } else {
                //echo "Error deleting record: " . $connectToDelete->error;
            }


            for ($i = 0 ; $i < count($photos); $i++){
                $imagePathI = $photos[$i];
                $stmti->execute();
            }

            $stmti->close();

            $successOrErrorEdit = "<span style=\"color: green;\">Uspešno ste izmenili podatke o proizvodu.<br><b>Napomena: </b>Ukoliko ste odobrili narudžbinu ovog proizvoda pre uređivanja, sada je taj status obrisan.</span>";

            $counterCheckToEdit = 0;

        }
        else {

            $counterCheckToEdit = 0;
        }


        $connectToEdit->close();

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

    ?>



    <div id="productContent" class="container"><br>
        <div style="text-align: center; padding-bottom: 20px;">

            <h2>Uredite podatke o proizvodu:</h2>
            <span class="error"><?php echo $successOrErrorEdit;?></span><br><br>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">  
                Naslov proizvoda: <br>
                <input id="yourInput" type="text" name="editTitle" value="<?php echo $editTitle;?>">
                <br>
                <span class="error"><?php echo $editTitleErr;?></span>
                <br>
                Cena(&euro;): <br>
                <input id="yourInput" type="text" name="editPrice" value="<?php echo $editPrice;?>">
                <br>
                <span class="error"><?php echo $editPriceErr;?></span>
                <br>
                Kategorija: <br>
                <select id="yourInput" name="editCategory">
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
                <span class="error"><?php echo $editCategoryErr;?></span>
                <br>
                Lokacija (Grad): <br>
                <input id="yourInput" type="text" name="editLocation" value="<?php echo $editLocation;?>">
                <br>
                <span class="error"><?php echo $editLocationErr;?></span>
                <br>
                Količina: <br>
                <input id="yourInput" type="number" name="editQuantity" value="1" min="1" max="10000" value="<?php echo $editQuantity;?>">
                <br>
                <span class="error"><?php echo $editQuantityErr;?></span>
                <br>


                Odaberite slike proizvoda (minimalno 1 maksimalno 10):<br>
                <b>Napomena: </b>Sve prethodne slike se brišu i postavljaju se novoažurirane umesto njih.<br>
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
                <select id="yourInput" name="editDelivery">
                    <option value="yes">Da</option>
                    <option value="no">Ne</option>
                </select>
                <br>
                <span class="error"><?php echo $editDeliveryErr;?></span>
                <br>
                Detaljan opis: <br>
                <textarea id="yourInput" type="text" name="editAbout" rows="7"><?php echo $editAbout;?></textarea>
                <br>
                <span class="error"><?php echo $editAboutErr;?></span>
                <br>
                <input id="submitFormToEditProduct" type="submit" name="submit" value="Uredite proizvod">
                <br><br><b style="color: red;">Upozorenje: </b>Ukoliko ste već odobrili narudžbinu ovog proizvoda, nakon uređivanja taj status će biti poništen!  
                <br>
                Nakon izmene pored naslova se automatski generiše dodatak "(izmenjeno)".
                <br>
            </form> 
        </div>
    </div> 
</body>
</html>