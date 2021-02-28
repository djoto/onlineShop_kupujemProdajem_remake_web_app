<?php

    $userIdToUnblock = $_GET["unblock"];


    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dBase = "KPdatabase";

    $connectToUnblock = new mysqli($servername, $username, $password, $dBase);



    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $updateToUnblock = "UPDATE allUsersKP SET blockedU='no' WHERE idU=$userIdToUnblock";
        if ($connectToUnblock->query($updateToUnblock) === TRUE) {
            //echo "Record updated successfully";
        } else {
            //echo "Error updating record: " . $conn->error;
        }


    }


    $connectToUnblock->close();

    header("Location:kp_admin_page_users.php");
    

?>