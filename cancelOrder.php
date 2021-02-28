<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dBase = "KPdatabase";
    

        $orderToCancel = $_GET["cancel"];

        $connectForCancel = new mysqli($servername, $username, $password, $dBase);

        
        $selectedForCancel = "DELETE FROM KPallOrders WHERE idO=$orderToCancel";

        if ($connectForCancel->query($selectedForCancel) === TRUE) {
        //echo "Record updated successfully";
        } else {
        //echo "Error updating record: " . $connectForCancel->error;
        }

        $connectForCancel->close();
    }

    header("Location: kp_customer_profile.php");
?>