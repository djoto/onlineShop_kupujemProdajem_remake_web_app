<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dBase = "KPdatabase";

        $orderToDeny = $_GET["deny"];

        $connectForDeny = new mysqli($servername, $username, $password, $dBase);
        
        $selectedForDeny = "UPDATE KPallOrders SET deniedO='yes' WHERE idO=$orderToDeny";

        if ($connectForDeny->query($selectedForDeny) === TRUE) {
        //echo "Record updated successfully";
        } else {
        //echo "Error updating record: " . $connectForCancel->error;
        }

        $connectForDeny->close();
    }

    header("Location: kp_seller_profile.php");
?>