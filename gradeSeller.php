<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dBase = "KPdatabase";
    

        $orderToDelete = $_GET["delete"];

        $connectForVote = new mysqli($servername, $username, $password, $dBase);

        $idCurrentUser = $_SESSION['idU'];
        $idCurrentSeller = $_SESSION['currentSellerId'];
        
        $yourSellerGrade = $_POST["yourGrade"];
        $yourSellerComment = $_POST["yourComment"];

        $selectFromVotesTable = "SELECT idR, idCustomerR, idSellerR, gradeR, commentR FROM ratesKP";
        $resultFromVotesTable = $connectForVote->query($selectFromVotesTable);

        $counterForVotes = 0;

        if ($resultFromVotesTable->num_rows > 0) {
            while($rowFromVotesTable = $resultFromVotesTable->fetch_assoc()) {
                if ($rowFromVotesTable["idCustomerR"] == $idCurrentUser && $rowFromVotesTable["idSellerR"] == $idCurrentSeller){
                    $counterForVotes++;
                }
            }
        } else {
            $counterForVotes = 0;
        }

        if ($counterForVotes == 0 && $yourSellerGrade != "0" && $yourSellerComment != ""){
        
            $stmtV = $connectForVote->prepare("INSERT INTO ratesKP (idCustomerR, idSellerR, gradeR, commentR) VALUES (?, ?, ?, ?)");
            $stmtV->bind_param("ssss", $idCustomerR, $idSellerR, $gradeR, $commentR);
            $idCustomerR = $idCurrentUser;
            $idSellerR = $idCurrentSeller;
            $gradeR = $yourSellerGrade;
            $commentR = $yourSellerComment;
            $stmtV->execute(); 
            $stmtV->close();
        }
        
        $selectedForDelete = "DELETE FROM KPallOrders WHERE idO=$orderToDelete";

        if ($connectForVote->query($selectedForDelete) === TRUE) {
        //echo "Record deleted successfully";
        } else {
        //echo "Error deleting record: " . $connectForDelete->error;
        }


        $connectForVote->close();
    }

    header("Location: kp_customer_profile.php");
?>