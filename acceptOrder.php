<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dBase = "KPdatabase";

        $orderToAccept = $_GET["accept"];

        $connectForAccept = new mysqli($servername, $username, $password, $dBase);

        
        $selectedForAccept = "UPDATE KPallOrders SET acceptedO='yes' WHERE idO=$orderToAccept";

        if ($connectForAccept->query($selectedForAccept) === TRUE) {
        //echo "Record updated successfully";
        } else {
        //echo "Error updating record: " . $connectForCancel->error;
        }

        $connectForAccept->close();
    }

    header("Location: kp_seller_profile.php");
?>