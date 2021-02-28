<?php

    $userIdToBlock = $_GET["block"];


    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dBase = "KPdatabase";

    $connectToBlock = new mysqli($servername, $username, $password, $dBase);



    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $updateToBlock = "UPDATE allUsersKP SET blockedU='yes' WHERE idU=$userIdToBlock";
        if ($connectToBlock->query($updateToBlock) === TRUE) {
            //echo "Record updated successfully";
        } else {
            //echo "Error updating record: " . $conn->error;
        }


    }


    $connectToBlock->close();

    header("Location:kp_admin_page_users.php");
    

?>