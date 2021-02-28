<?php
    session_start();
  
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dBase = "KPdatabase";

    $logInNameErr = $logInPasswdErr = "";
    $logInName = $logInPassword = "";
    $labelIfNotExists = "";

    $conne = new mysqli($servername, $username, $password, $dBase);

    $counterLogIn = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["logInName"])) {
            $logInNameErr = "* Obavezno polje";
        } else {
            $logInName = test_input($_POST["logInName"]);
            // check if input is invalid name or email
            if (!preg_match("/^[a-zA-Z]+$/",$logInName) && !filter_var($logInName, FILTER_VALIDATE_EMAIL)) {
                $logInNameErr = "* Dozvoljena su samo slova";
            }
            else{
                $counterLogIn++;
            }
        }
        
        if (empty($_POST["logInPassword"])) {
            $logInPasswdErr = "* Obavezno polje";
        } else {
            $logInPassword = test_input($_POST["logInPassword"]);
            $counterLogIn++;
        }
        
    }

    $tryIt = "SELECT idU, firstnameU, lastnameU, emailU, usernameU, passwdU, accountTypeU, statusLogInOutU, blockedU FROM allUsersKP";
    $result = $conne->query($tryIt);

    $counterIfExists = 0;

    if ($counterLogIn == 2){
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if (($row["emailU"] == $logInName || $row["usernameU"] == $logInName) && $row["passwdU"] == $logInPassword){
                    $counterIfExists++;

                        $_SESSION['idU'] = $row["idU"];
                        $_SESSION['firstnameU'] = $row["firstnameU"];
                        $_SESSION['lastnameU'] = $row["lastnameU"];
                        $_SESSION['emailU'] = $row["emailU"];
                        $_SESSION['usernameU'] = $row["usernameU"];
                        $_SESSION['passwdU'] = $row["passwdU"];
                        $_SESSION['accountTypeU'] = $row["accountTypeU"];
                        $_SESSION['blockedU'] = $row["blockedU"];
                        $userId = $row["idU"];

                        $statusUpdate = "UPDATE allUsersKP SET statusLogInOutU='in' WHERE idU=$userId";

                        if ($conne->query($statusUpdate) === TRUE) {
                            //echo "success";//something... 
                        } else {
                            //echo "error";//something else...         
                        }

                        
                        $selectStatus = "SELECT statusLogInOutU, blockedU FROM allUsersKP WHERE idU=$userId";
                        $selectedStat = $conne->query($selectStatus);

                        if ($selectedStat->num_rows > 0) {
                            while($rowStat = $selectedStat->fetch_assoc()) {
                                if($rowStat["statusLogInOutU"] == "in"){
                                    $_SESSION['statusLogInOutU'] = $rowStat["statusLogInOutU"];
                                    if($_SESSION['accountTypeU'] == "admin"){
                                        if ($rowStat["blockedU"] == "no"){
                                            header("Location:kp_admin_page.php");
                                        }
                                        else if ($rowStat["blockedU"] == "yes"){
                                            header("Location:kp_log_in_after_blocked.php");
                                        }
                                    }
                                    else if ($_SESSION['accountTypeU'] == "customer"){
                                        if ($rowStat["blockedU"] == "no"){
                                            header("Location:kp_customer_page.php");
                                        }
                                        else if ($rowStat["blockedU"] == "yes"){
                                            header("Location:kp_log_in_after_blocked.php");
                                        }
                                    }
                                    else if ($_SESSION['accountTypeU'] == "seller"){
                                        if ($rowStat["blockedU"] == "no"){
                                            header("Location:kp_seller_page.php");
                                        }
                                        else if ($rowStat["blockedU"] == "yes"){
                                            header("Location:kp_log_in_after_blocked.php");
                                        }
                                    }
                                }
                            }
                        }
                    // }
                }
            }
            if ($counterIfExists == 0){
                $labelIfNotExists = "* Neodgovarajuće ime ili mejl! Pokušajte ponovo.";
            }
        }
        $counterLogIn = 0;
    }

    $conne->close();

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }

?>

