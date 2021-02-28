<?php
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dBase = "KPdatabase";

    $signUpNameErr = $signUpSurnameErr = $signUpEmailErr = $signUpUsernameErr = $signUpPasswordErr = $signUpAccTypeErr = "";
    $signUpName = $signUpSurname = $signUpEmail = $signUpUsername = $signUpPassword = $signUpAccType = "";

    $labelAlreadyExists = "";
    $invalidInput = "";

    $connectSignUp = new mysqli($servername, $username, $password, $dBase);
    $selectedFromTable = "SELECT emailU, usernameU FROM allUsersKP";
    $resultSelection = $connectSignUp->query($selectedFromTable);
    $counterSignUp = 0;
    $counterCheck = 0;
    $stmt = $connectSignUp->prepare("INSERT INTO allUsersKP (firstnameU, lastnameU, emailU, usernameU, passwdU, accountTypeU, statusLogInOutU, blockedU) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $signUpName, $signUpSurname, $signUpEmail, $signUpUsername, $signUpPassword, $signUpAccType, $userStatus, $userBlocked);
    $userStatus = "out";
    $userBlocked = "no";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["signUpName"])) {
            $signUpNameErr = "* Obavezno polje.";
        } else {
            $signUpName = test_input($_POST["signUpName"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z]+$/",$signUpName)) {
            $signUpNameErr = "* Dozvoljena su samo slova.";
            }
            else{
                $counterSignUp++;
                $invalidInput = "<span style=\"color: red;\">Neispravan unos!</span>";
            }
        }
        if (empty($_POST["signUpSurname"])) {
            $signUpSurnameErr = "* Obavezno polje.";
        } else {
            $signUpSurname = test_input($_POST["signUpSurname"]);
            if (!preg_match("/^[a-zA-Z]+$/",$signUpSurname)) {
            $signUpSurnameErr = "* Dozvoljena su samo slova.";
            }
            else{
                $counterSignUp++;
                $invalidInput = "<span style=\"color: red;\">Neispravan unos!</span>";
            }
        }
        if (empty($_POST["signUpEmail"])) {
            $signUpEmailErr = "* Obavezno polje.";
        } else {
            $signUpEmail = test_input($_POST["signUpEmail"]);
            if (!filter_var($signUpEmail, FILTER_VALIDATE_EMAIL)) {
            $signUpEmailErr = "* Neispravna e-mail adresa.";
            }
            else{
                $counterSignUp++;
                $invalidInput = "<span style=\"color: red;\">Neispravan unos!</span>";
            }
        }

        if (empty($_POST["signUpUsername"])) {
            $signUpUsernameErr = "* Obavezno polje.";
        } else {
            $signUpUsername = test_input($_POST["signUpUsername"]);
            if (!preg_match("/^[a-zA-Z]+$/",$signUpUsername)) {
            $signUpUsernameErr = "* Dozvoljena su samo slova.";
            }
            else{
                $counterSignUp++; 
                $invalidInput = "<span style=\"color: red;\">Neispravan unos!</span>";
            }
        }
        
        if (empty($_POST["signUpPassword"])) {
            $signUpPasswordErr = "* Obavezno polje.";
        } else {
            $signUpPassword = test_input($_POST["signUpPassword"]);
            $counterSignUp++;
            $invalidInput = "<span style=\"color: red;\">Neispravan unos!</span>";
        }

        if (empty($_POST["accountType"])) {
            $signUpAccTypeErr = "* Tip naloga je obavezan.";
        } else {
            $signUpAccType = test_input($_POST["accountType"]);
            $counterSignUp++;
            $invalidInput = "<span style=\"color: red;\">Neispravan unos!</span>";
        }
        
    }
    while($row = $resultSelection->fetch_assoc()) {
        if ($row["usernameU"] == $signUpUsername || $row["emailU"] == $signUpEmail){
            $counterCheck++;
        }
    }
    if ($counterCheck > 0){
        $labelAlreadyExists = "*Korisničko ime ili e-mail već postoji! Odaberite drugačije.";
    }
    if ($counterSignUp == 6 && $counterCheck == 0){
        $stmt->execute();

        $counterSignUp = 0;
        header("Location:kp_log_in_afterSignUp.php");

    }
    else {
        $counterSignUp = 0;
        $counterCheck = 0;
    }
    
    $stmt->close();

    $connectSignUp->close();
    
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>