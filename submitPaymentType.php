<?php
session_start();
$cardNumberErr = $paymentTypeErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["paymentType"])) {
        $_SESSION['errorEmpty'] = "Označite način plaćanja.";
    } else {
        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dBase = "KPdatabase";
    
        $connectToCheck = new mysqli($servername, $username, $password, $dBase);

        $sqlToCheck = "SELECT idO, idCustomerO, idSellerO, idProductO, acceptedO, deniedO, cancelledO, paymentTypeO, quantityO FROM KPallOrders";
        $resultToCheck = $connectToCheck->query($sqlToCheck);

        $counterToCheck = 0;
        if ($resultToCheck->num_rows > 0) {
            while($rowToCheck = $resultToCheck->fetch_assoc()) {
                if($rowToCheck["idCustomerO"] == $_SESSION['idU'] && $rowToCheck["idProductO"] == $_SESSION['productId']){
                    $counterToCheck++;
                }
            }
        }
        $connectToCheck->close();
        
        $paymentType = test_input($_POST["paymentType"]);
        $quantityToAdd = test_input($_POST["quantityCustomer"]);
        $priceForOne = $_SESSION['priceForOne'];
        $_SESSION['quantityO'] = $quantityToAdd;

        if ($paymentType == "card"){
            if (empty($_POST["cardNumber"])) {
                $_SESSION['errorAccount'] = "Broj računa je obavezan.";
            } 
            else {
                $cardNumber = test_input($_POST["cardNumber"]);
                if (!preg_match("/^[0-9-' ]*$/",$cardNumber)) {
                    $_SESSION['errorAccount'] = "Dozvoljeni su samo brojevi.";
                }
                else{
                    if ($counterToCheck == 0){
                        $_SESSION['success'] = "Uspešno ste naručili proizvod.";
                        $total = (float)$priceForOne * (int)$quantityToAdd;
                        $totalStr = number_format((float)$total , 2, '.', '');
                        $_SESSION['yourBill'] = "Vaš račun: ".$totalStr."&euro;";
                        $_SESSION['paymentType'] = "elektronski";
                        addOrderInDb();
                    }
                    else{
                        $_SESSION['already'] = "Već ste naručili ovaj proizvod.";
                    }
                }
            }
        }
        else{
            if ($counterToCheck == 0){
                $_SESSION['success'] = "Uspešno ste naručili proizvod.";
                $total = (float)$priceForOne * (int)$quantityToAdd;
                $totalStr = number_format((float)$total , 2, '.', '');
                $_SESSION['yourBill'] = "Vaš račun: ".$totalStr."&euro;"; 
                $_SESSION['paymentType'] = "gotovina";
                addOrderInDb();
            }
            else{
                $_SESSION['already'] = "Već ste naručili ovaj proizvod.";
            }
        }
    }
    header("Location: kp_product_page.php?idp=".$_SESSION['productId']."&type=".$_SESSION['pageType']."");
}
function addOrderInDb(){
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dBase = "KPdatabase";

    $connectToOrder = new mysqli($servername, $username, $password, $dBase);

    $stmto = $connectToOrder->prepare("INSERT INTO KPallOrders (idCustomerO, idSellerO, idProductO, acceptedO, deniedO, cancelledO, paymentTypeO, quantityO) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmto->bind_param("ssssssss", $idCustomerO, $idSellerO, $idProductO, $acceptedO, $deniedO, $cancelledO, $paymentTypeO, $quantityO);
    $idCustomerO = $_SESSION['idU'];
    $idSellerO = $_SESSION['sellerIdToOrder'];
    $idProductO = $_SESSION['productId'];
    $acceptedO = "no";
    $deniedO = "no";
    $cancelledO = "no";
    $paymentTypeO = $_SESSION['paymentType'];
    $quantityO = $_SESSION['quantityO'];
    $stmto->execute();
    $stmto->close();

    $connectToOrder->close();
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>