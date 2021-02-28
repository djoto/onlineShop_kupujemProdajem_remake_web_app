<!DOCTYPE html>
<html>
<head>
<style>
table, td, th {
  border: 1px solid black;
  text-align: center;
}

table {
  width: 100%;
  border-collapse: collapse;
}
</style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "KPdatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT idR, idCustomerR, idSellerR, gradeR, commentR FROM ratesKP";
$result = $conn->query($sql);
$ratesTable = '<table>
<tr>
<th>idR</th>
<th>idCustomerR</th>
<th>idSellerR</th>
<th>gradeR</th>
<th>commentR</th>
</tr>';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $ratesTable .= '<tr>
        <td>'.$row["idR"].'</td>
        <td>'.$row["idCustomerR"].'</td>
        <td>'.$row["idSellerR"].'</td>
        <td>'.$row["gradeR"].'</td>
        <td>'.$row["commentR"].'</td>
        </tr>';
    }
} else {
    echo "0 results";
}
echo $ratesTable.'</table>';
$conn->close();
?>

</body>
</html>