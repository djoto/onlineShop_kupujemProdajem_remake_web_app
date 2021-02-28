<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dBase = "KPdatabase";
        $connectForUpdate = new mysqli($servername, $username, $password, $dBase);

        $currentIdForLogOut =  $_SESSION['idU'];

        $statusUpdateOnLogOut = "UPDATE allUsersKP SET statusLogInOutU='out' WHERE idU=$currentIdForLogOut";
        if ($connectForUpdate->query($statusUpdateOnLogOut) === TRUE) {
            //something...
        } else {
            //something else... 
        }

        $selectAfterOut = "SELECT idU, statusLogInOutU FROM allUsersKP WHERE idU=$currentIdForLogOut";
        $selectedAftOut = $connectForUpdate->query($selectAfterOut);
        if ($selectedAftOut->num_rows > 0) {
            while($rowOut = $selectedAftOut->fetch_assoc()) {
                if($rowOut["idU"] == $currentIdForLogOut){
                    $_SESSION['statusLogInOutU'] = $rowOut["statusLogInOutU"];
                }
            }
        }

        $connectForUpdate->close();

        header("Location:kp_log_in.php");
    }
?>