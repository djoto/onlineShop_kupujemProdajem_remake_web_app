<?php

    $userIdToRemove = $_GET["remove"];


    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dBase = "KPdatabase";

    $connectToRemove = new mysqli($servername, $username, $password, $dBase);

    $userSelected = "SELECT accountTypeU FROM allUsersKP WHERE idU=$userIdToRemove";
    $resultUserSelection = $connectToRemove->query($userSelected);

    while($rowUser = $resultUserSelection->fetch_assoc()) {
        $userTypeToRemove = $rowUser["accountTypeU"];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if ($userTypeToRemove == "seller"){

            $deleteFromRates = "DELETE FROM ratesKP WHERE idSellerR=$userIdToRemove";
            if ($connectToRemove->query($deleteFromRates) === TRUE) {
                //echo "Record deleted successfully";
            } else {
                //echo "Error deleting record: " . $connectToRemove->error;
            }

            $deleteFromOrders = "DELETE FROM KPallOrders WHERE idSellerO=$userIdToRemove";
            if ($connectToRemove->query($deleteFromOrders) === TRUE) {
                //echo "Record deleted successfully";
            } else {
                //echo "Error deleting record: " . $connectToRemove->error;
            }


            $deleteFromProducts = "DELETE FROM allProductsKP WHERE idS=$userIdToRemove";
            if ($connectToRemove->query($deleteFromProducts) === TRUE) {
                //echo "Record deleted successfully";
            } else {
                //echo "Error deleting record: " . $connectToRemove->error;
            }

            $deleteFromUsers = "DELETE FROM allUsersKP WHERE idU=$userIdToRemove";
            if ($connectToRemove->query($deleteFromUsers) === TRUE) {
                //echo "Record deleted successfully";
            } else {
                //echo "Error deleting record: " . $connectToRemove->error;
            }

        }
        else if ($userTypeToRemove == "customer"){

            $deleteFromRates = "DELETE FROM ratesKP WHERE idCustomerR=$userIdToRemove";
            if ($connectToRemove->query($deleteFromRates) === TRUE) {
                //echo "Record deleted successfully";
            } else {
                //echo "Error deleting record: " . $connectToRemove->error;
            }

            $deleteFromOrders = "DELETE FROM KPallOrders WHERE idCustomerO=$userIdToRemove";
            if ($connectToRemove->query($deleteFromOrders) === TRUE) {
                //echo "Record deleted successfully";
            } else {
                //echo "Error deleting record: " . $connectToRemove->error;
            }

            $deleteFromUsers = "DELETE FROM allUsersKP WHERE idU=$userIdToRemove";
            if ($connectToRemove->query($deleteFromUsers) === TRUE) {
                //echo "Record deleted successfully";
            } else {
                //echo "Error deleting record: " . $connectToRemove->error;
            }

        }

    }


    $connectToRemove->close();

    header("Location:kp_admin_page_users.php");
    

?>