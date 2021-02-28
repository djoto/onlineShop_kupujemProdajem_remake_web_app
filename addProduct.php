<?php
    $sellerId = $_SESSION['idU'];

    $addTitleErr = $addPriceErr = $addCategoryErr = $addLocationErr = $addQuantityErr = $addDeliveryErr = $addAboutErr = "";
    $addTitle = $addPrice = $addCategory = $addLocation = $addQuantity = $addDelivery = $addAbout = "";

    $successOrError = "";

    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dBase = "KPdatabase";

    $connectToAdd = new mysqli($servername, $username, $password, $dBase);


    $sqlToGetLast = "SELECT idL, lastId FROM lastProductId";
    $resultToGetLast = $connectToAdd->query($sqlToGetLast);
    $lastId = "";
    if ($resultToGetLast->num_rows > 0) {
        while($rowToGetLast = $resultToGetLast->fetch_assoc()) {
            $lastId = $rowToGetLast["lastId"]; 
        }
    }
    $nextId = (int)$lastId + 1;



    $stmtA = $connectToAdd->prepare("INSERT INTO allProductsKP (idS, titleP, priceP, categoryP, locationP, quantityP, deliveryTypeP, aboutP) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtA->bind_param("ssssssss", $sellerId, $addTitle, $addPrice, $addCategory , $addLocation, $addQuantity, $addDelivery, $addAbout);
    

    $stmti = $connectToAdd->prepare("INSERT INTO allImagesP (idProductIm, imagePathIm) VALUES (?, ?)");
    $stmti->bind_param("ss", $idProductI, $imagePathI);
    $idProductI = $nextId;


    
    $counterCheckToAdd = 0;
    
    $counter = 0;

    $errorFile = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["addTitle"]) || ($_POST["addTitle"] == " ")) {
            $addTitleErr = "* Polje je obavezno.";
            $successOrError = "<span class=\"error\">Neispravan unos!</span>";
        } else {
            $addTitle = test_input($_POST["addTitle"]);
            $counterCheckToAdd++;
        }

        if (empty($_POST["addPrice"]) || ($_POST["addPrice"] == " ")) {
            $addPriceErr = "* Polje je obavezno.";
            $successOrError = "<span class=\"error\">Neispravan unos!</span>";
        } else {
            $addPrice = test_input($_POST["addPrice"]);
            if (is_numeric($addPrice)){
                $counterCheckToAdd++;
            }
            else {
                $addPriceErr = "* Može sadržati samo brojeve i decimalnu tačku.";
            }
        }

        if (empty($_POST["addCategory"])) {
            $addCategoryErr = "* Polje je obavezno.";
            $successOrError = "<span class=\"error\">Neispravan unos!</span>";
        } else {
            $addCategory = test_input($_POST["addCategory"]);
            $counterCheckToAdd++;
        }

        if (empty($_POST["addLocation"]) || ($_POST["addLocation"] == " ")) {
            $addLocationErr = "* Polje je obavezno.";
            $successOrError = "<span class=\"error\">Neispravan unos!</span>";
        } else {
            $addLocation = test_input($_POST["addLocation"]);
            $counterCheckToAdd++;
        }

        if (empty($_POST["addQuantity"])) {
            $addQuantityErr = "* Polje je obavezno.";
            $successOrError = "<span class=\"error\">Neispravan unos!</span>";
        } else {
            $addQuantity = test_input($_POST["addQuantity"]);
            $counterCheckToAdd++;
        }

        if (empty($_POST["addDelivery"])) {
            $addDeliveryErr = "* Polje je obavezno.";
            $successOrError = "<span class=\"error\">Neispravan unos!</span>";
        } else {
            $addDelivery = test_input($_POST["addDelivery"]);
            $counterCheckToAdd++;
        }

        if (empty($_POST["addAbout"]) || ($_POST["addAbout"] == " ")) {
            $addAboutErr = "* Polje je obavezno.";
            $successOrError = "<span class=\"error\">Neispravan unos!</span>";
        } else {
            $addAbout = test_input($_POST["addAbout"]);
            $counterCheckToAdd++;
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
                            $imagePathI = "images/" . uniqid() . "_" . $name;
                            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$f], $imagePathI);
                            $stmti->execute();
                        }
                    }
                }
                else {
                    $error =  "Neispravan unos fajla: ".$name;
                    $successOrError = "<span class=\"error\">Neispravan unos!</span>";
                    $errorFile = $error;
                }
            }
        }
        if ($counter == 10){
            $error =  "Obavezno učitavanje bar jedne slike!";
            $successOrError = "<span class=\"error\">Neispravan unos!</span>";
            $errorFile = $error;
        }


    }
    $stmti->close();

    if ($counterCheckToAdd == 7 && $errorFile == ""){
        $stmtA->execute();
        $last_id = $connectToAdd->insert_id;

        $sqlToLast = "UPDATE lastProductId SET lastId='$last_id' WHERE idL=1";
        if ($connectToAdd->query($sqlToLast) === TRUE) {
            //echo "Record updated successfully";
        } else {
            //echo "Error updating record: " . $conn->error;
        }

        $successOrError = "<span style=\"color: green;\">Uspešno ste dodali proizvod u ponudu.<br><b>Napomena: </b>Dodati proizvod će se prikazati u Vašoj ponudi nakon što osvežite početnu stranicu (klik na logo u gornjem levom uglu).</span>";

        $counterCheckToAdd = 0;
        header("Location:kp_seller_profile.php");

    }
    else {
        $sqlDel = "DELETE FROM allImagesP WHERE idProductIm=$nextId";
        if ($connectToAdd->query($sqlDel) === TRUE) {
          //echo "Record deleted successfully";
        } else {
          //echo "Error deleting record: " . $connec->error;
        }
        $counterCheckToAdd = 0;
    }
    
    $stmtA->close();

    $connectToAdd->close();

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>