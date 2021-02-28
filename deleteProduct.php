<?php
    $sellerId = $_SESSION['idU'];

    $productIdToDelete = $_GET["delete"];

    $successOrError = "";

    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dBase = "KPdatabase";

    $connectToDelete = new mysqli($servername, $username, $password, $dBase);



    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $deleteFromOrders = "DELETE FROM KPallOrders WHERE idProductO=$productIdToDelete";
        if ($connectToDelete->query($deleteFromOrders) === TRUE) {
            //echo "Record deleted successfully";
        } else {
            //echo "Error deleting record: " . $connectToDelete->error;
        }

        $deleteFromImages = "DELETE FROM allImagesP WHERE idProductIm=$productIdToDelete";
        if ($connectToDelete->query($deleteFromImages) === TRUE) {
            //echo "Record deleted successfully";
        } else {
            //echo "Error deleting record: " . $connectToDelete->error;
        }

        $deleteFromProducts = "DELETE FROM allProductsKP WHERE idP=$productIdToDelete";
        if ($connectToDelete->query($deleteFromProducts) === TRUE) {
            //echo "Record deleted successfully";
        } else {
            //echo "Error deleting record: " . $connectToDelete->error;
        }

    }


    $connectToDelete->close();

    header("Location:kp_seller_profile.php");
    
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>