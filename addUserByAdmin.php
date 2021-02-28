<?php
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dBase = "KPdatabase";

    $addUserNameErr = $addUserSurnameErr = $addUserEmailErr = $addUserUsernameErr = $addUserPasswordErr = $addUserAccTypeErr = "";
    $addUserName = $addUserSurname = $addUserEmail = $addUserUsername = $addUserPassword = $addUserAccType = "";

    $labelAlreadyExists = "";
    $invalidInput = "";

    $connectAddUser = new mysqli($servername, $username, $password, $dBase);
    $selectedFromTable = "SELECT emailU, usernameU FROM allUsersKP";
    $resultSelection = $connectAddUser->query($selectedFromTable);
    $counterAddUser = 0;
    $counterCheck = 0;
    $stmt = $connectAddUser->prepare("INSERT INTO allUsersKP (firstnameU, lastnameU, emailU, usernameU, passwdU, accountTypeU, statusLogInOutU, blockedU) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $addUserName, $addUserSurname, $addUserEmail, $addUserUsername, $addUserPassword, $addUserAccType, $userStatus, $userBlocked);
    $userStatus = "out";
    $userBlocked = "no";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["addUserName"])) {
            $addUserNameErr = "* Obavezno polje.";
        } else {
            $addUserName = test_input($_POST["addUserName"]);
            // check if name only contains letters
            if (!preg_match("/^[a-zA-Z]+$/",$addUserName)) {
            $addUserNameErr = "* Dozvoljena su samo slova.";
            }
            else{
                $counterAddUser++;
                $invalidInput = "<span style=\"color: red;\">Neispravan unos!</span>";
            }
        }
        if (empty($_POST["addUserSurname"])) {
            $addUserSurnameErr = "* Obavezno polje.";
        } else {
            $addUserSurname = test_input($_POST["addUserSurname"]);
            if (!preg_match("/^[a-zA-Z]+$/",$addUserSurname)) {
            $addUserSurnameErr = "* Dozvoljena su samo slova.";
            }
            else{
                $counterAddUser++;
                $invalidInput = "<span style=\"color: red;\">Neispravan unos!</span>";
            }
        }
        if (empty($_POST["addUserEmail"])) {
            $addUserEmailErr = "* Obavezno polje.";
        } else {
            $addUserEmail = test_input($_POST["addUserEmail"]);
            if (!filter_var($addUserEmail, FILTER_VALIDATE_EMAIL)) {
            $addUserEmailErr = "* Neispravna e-mail adresa.";
            }
            else{
                $counterAddUser++;
                $invalidInput = "<span style=\"color: red;\">Neispravan unos!</span>";
            }
        }

        if (empty($_POST["addUserUsername"])) {
            $addUserUsernameErr = "* Obavezno polje.";
        } else {
            $addUserUsername = test_input($_POST["addUserUsername"]);
            if (!preg_match("/^[a-zA-Z]+$/",$addUserUsername)) {
            $addUserUsernameErr = "* Dozvoljena su samo slova.";
            }
            else{
                $counterAddUser++; 
                $invalidInput = "<span style=\"color: red;\">Neispravan unos!</span>";
            }
        }
        
        if (empty($_POST["addUserPassword"])) {
            $addUserPasswordErr = "* Obavezno polje.";
        } else {
            $addUserPassword = test_input($_POST["addUserPassword"]);
            $counterAddUser++;
            $invalidInput = "<span style=\"color: red;\">Neispravan unos!</span>";
        }

        if (empty($_POST["accountType"])) {
            $addUserAccTypeErr = "* Tip naloga je obavezan.";
        } else {
            $addUserAccType = test_input($_POST["accountType"]);
            $counterAddUser++;
            $invalidInput = "<span style=\"color: red;\">Neispravan unos!</span>";
        }
        
    }
    while($row = $resultSelection->fetch_assoc()) {
        if ($row["usernameU"] == $addUserUsername || $row["emailU"] == $addUserEmail){
            $counterCheck++;
        }
    }
    if ($counterCheck > 0){
        $labelAlreadyExists = "*Korisničko ime ili e-mail već postoji! Odaberite drugačije.";
    }
    if ($counterAddUser == 6 && $counterCheck == 0){
        $stmt->execute();
        $invalidInput = "<span style=\"color: green;\">Uspešno ste dodali korisnika.</span>";
        $counterAddUser = 0;
        // header("Location:kp_admin_page_add_user.php");

    }
    else {
        $counterAddUser = 0;
        $counterCheck = 0;
    }
    
    $stmt->close();

    $connectAddUser->close();
    
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>