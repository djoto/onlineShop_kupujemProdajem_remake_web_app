<?php
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dBase = "KPdatabase";

    // Create connection
    $conn = new mysqli($servername, $username, $password);


    $db = "CREATE DATABASE IF NOT EXISTS KPdatabase";

    if ($conn->query($db) === TRUE) {
        //echo "Database created successfully";
    }
    else {
        //echo "Error creating database: " . $conn->error;
    }

    $conn->close();
    $connec = new mysqli($servername, $username, $password, $dBase);



    $tableAllUsers = "CREATE TABLE IF NOT EXISTS allUsersKP (
        idU INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstnameU VARCHAR(50) NOT NULL,
        lastnameU VARCHAR(50) NOT NULL,
        emailU VARCHAR(50) NOT NULL,
        usernameU VARCHAR(50) NOT NULL,
        passwdU VARCHAR(100) NOT NULL,
        accountTypeU VARCHAR(20) NOT NULL,
        statusLogInOutU VARCHAR(10) NOT NULL,
        blockedU VARCHAR(10) NOT NULL
    )";

    if ($connec->query($tableAllUsers) === TRUE) {
        //echo "Table allUsersKP created successfully";
    }
    else {
        //echo "Error creating table: " . $connec->error;
    }


    $tableAllProducts = "CREATE TABLE IF NOT EXISTS allProductsKP (
        idP INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        idS INT(10) NOT NULL,
        titleP VARCHAR(150) NOT NULL,
        priceP VARCHAR(20) NOT NULL,
        categoryP VARCHAR(250) NOT NULL,
        locationP VARCHAR(250) NOT NULL,
        quantityP VARCHAR(250) NOT NULL,
        deliveryTypeP VARCHAR(250) NOT NULL,
        aboutP VARCHAR(6000) NOT NULL
    )";
    if ($connec->query($tableAllProducts) === TRUE) {
        //echo "Table allProductsKP created successfully";
    }
    else {
        //echo "Error creating table: " . $connec->error;
    }


    // $stmtp = $connec->prepare("INSERT INTO allProductsKP (idS, titleP, priceP, categoryP, locationP, quantityP, deliveryTypeP, aboutP) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    // $stmtp->bind_param("ssssssss", $idSellerP, $titleProduct, $price, $category, $location, $quantity, $delivery, $about);
    // $idSellerP = 3;
    // $titleProduct = "Audi A8";
    // $price = "18000";
    // $category = "automobili";
    // $location = "Kragujevac";
    // $quantity = "2";
    // $delivery = "yes";
    // $about = "U odlicnom stanju";
    // $stmtp->execute();
    // $stmtp->close();

    // $sqlDel = "DELETE FROM allProductsKP WHERE idS=2";
    // if ($connec->query($sqlDel) === TRUE) {
    //   //echo "Record deleted successfully";
    // } else {
    //   //echo "Error deleting record: " . $connec->error;
    // }



    $tableImagesP = "CREATE TABLE IF NOT EXISTS allImagesP (
        idIm INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        idProductIm INT(10) NOT NULL,
        imagePathIm VARCHAR(500) NOT NULL
    )";
    if ($connec->query($tableImagesP) === TRUE) {
        //echo "Table allImagesP created successfully";
    }
    else {
        //echo "Error creating table: " . $connec->error;
    }



    // $stmti = $connec->prepare("INSERT INTO allImagesP (idProductIm, imagePathIm) VALUES (?, ?)");
    // $stmti->bind_param("ss", $idProductI, $imagePathI);
    // $idProductI = 8;
    // $imagePathI = "images/logoo.jpg";
    // $stmti->execute();
    // $stmti->close();

    // $sqlDel = "DELETE FROM allImagesP WHERE idProductIm=30";
    // if ($connec->query($sqlDel) === TRUE) {
    //   echo "Record deleted successfully";
    // } else {
    //   echo "Error deleting record: " . $connec->error;
    // }




    $tableOrders = "CREATE TABLE IF NOT EXISTS KPallOrders (
        idO INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        idCustomerO INT(10) NOT NULL,
        idSellerO INT(10) NOT NULL,
        idProductO INT(10) NOT NULL,
        acceptedO VARCHAR(250) NOT NULL,
        deniedO VARCHAR(250) NOT NULL,
        cancelledO VARCHAR(250) NOT NULL,
        paymentTypeO VARCHAR(250) NOT NULL,
        quantityO INT(5) NOT NULL
    )";
    if ($connec->query($tableOrders) === TRUE) {
        //echo "Table KPallOrders created successfully";
    }
    else {
        //echo "Error creating table: " . $connec->error;
    }


    // $stmto = $connec->prepare("INSERT INTO KPallOrders (idCustomerO, idSellerO, idProductO, acceptedO, deniedO, cancelledO, paymentTypeO, quantityO) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    // $stmto->bind_param("ssssssss", $idCustomerO, $idSellerO, $idProductO, $acceptedO, $deniedO, $cancelledO, $paymentTypeO, $quantityO);
    // $idCustomerO = 2;
    // $idSellerO = 3;
    // $idProductO = 3;
    // $acceptedO = "no";
    // $deniedO = "no";
    // $cancelledO = "no";
    // $paymentTypeO = "gotovina";
    // $quantityO = "3";
    // $stmto->execute();
    // $stmto->close();

    // MANUALY DELETE USER FROM DATABASE:
    // $sqlDel = "DELETE FROM KPallOrders WHERE idO=1";
    // if ($connec->query($sqlDel) === TRUE) {
    //   echo "Record deleted successfully";
    // } else {
    //   echo "Error deleting record: " . $connec->error;
    // }



    $tableRates = "CREATE TABLE IF NOT EXISTS ratesKP (
        idR INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        idCustomerR INT(10) NOT NULL,
        idSellerR INT(10) NOT NULL,
        gradeR INT(5) NOT NULL,
        commentR VARCHAR(5000) NOT NULL
    )";
    if ($connec->query($tableRates) === TRUE) {
        //echo "Table ratesKP created successfully";
    }
    else {
        //echo "Error creating table: " . $connec->error;
    }


    $tableLast = "CREATE TABLE IF NOT EXISTS lastProductId (
        idL INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        lastId INT(10) NOT NULL
    )";
    if ($connec->query($tableLast) === TRUE) {
        //echo "Table lastProductId created successfully";
    }
    else {
        //echo "Error creating table: " . $connec->error;
    }
    // $stmtL = $connec->prepare("INSERT INTO lastProductId (lastId) VALUES (?)");
    // $stmtL->bind_param("s", $lastL);
    // $lastL = 0;
    // $stmtL->execute();
    // $stmtL->close();



    //MANUALY DELETE USER FROM DATABASE:
    // $sqlDel = "DELETE FROM allUsersKP WHERE idU=7";
    // if ($connec->query($sqlDel) === TRUE) {
    //   //echo "Record deleted successfully";
    // } else {
    //   //echo "Error deleting record: " . $connec->error;
    // }

    //ADD ADMINISTRATOR IN DATABASE IF NOT EXISTS SOMEONE WITH SAME EMAIL OR USERNAME (only way to add admin!):
    //THIS WILL ADD ONE ADMIN ON FIRST LOAD
    $stmta = $connec->prepare("INSERT INTO allUsersKP (firstnameU, lastnameU, emailU, usernameU, passwdU, accountTypeU, statusLogInOutU, blockedU) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmta->bind_param("ssssssss", $signUpNameAdmin, $signUpSurnameAdmin, $signUpEmailAdmin, $signUpUsernameAdmin, $signUpPasswordAdmin, $usertypeAdmin, $signUpStatus, $blockedStatus);
    $signUpNameAdmin = "Đorđe";
    $signUpSurnameAdmin = "Gačić";
    $signUpEmailAdmin = "djordjegacic99tb@gmail.com";
    $signUpUsernameAdmin = "djoto";
    $signUpPasswordAdmin = "popokatepetl";
    $usertypeAdmin = "admin";
    $signUpStatus = "out";
    $blockedStatus = "no";


    $selectedFromTableUsers = "SELECT emailU, usernameU FROM allUsersKP";
    $resultSelectionUsers = $connec->query($selectedFromTableUsers);
    $counterAdmin = 0;
    while($rowA = $resultSelectionUsers->fetch_assoc()) {
        if ($rowA["emailU"] == $signUpEmailAdmin || $rowA["usernameU"] == $signUpUsernameAdmin){
            $counterAdmin++;
        }
    }
    if($counterAdmin==0){
        $stmta->execute();
    }
    else{
        $counterAdmin = 0;
    }

    $stmta->close();

    $connec->close();
?>