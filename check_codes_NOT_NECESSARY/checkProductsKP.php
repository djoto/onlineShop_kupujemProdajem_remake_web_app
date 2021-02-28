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

$sql = "SELECT idP, idS, titleP, priceP, categoryP, locationP, quantityP, deliveryTypeP, aboutP FROM allProductsKP";
$result = $conn->query($sql);
$tableProducts = '<table>
<tr>
<th>idP</th>
<th>idS</th>
<th>titleP</th>
<th>priceP</th>
<th>categoryP</th>
<th>locationP</th>
<th>quantityP</th>
<th>deliveryTypeP</th>
<th>aboutP</th>
</tr>';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $tableProducts .= '<tr>
        <td>'.$row["idP"].'</td>
        <td>'.$row["idS"].'</td>
        <td>'.$row["titleP"].'</td>
        <td>'.$row["priceP"].'</td>
        <td>'.$row["categoryP"].'</td>
        <td>'.$row["locationP"].'</td>
        <td>'.$row["quantityP"].'</td>
        <td>'.$row["deliveryTypeP"].'</td>
        <td>'.$row["aboutP"].'</td>
        </tr>';
    }
} else {
    echo "0 results";
}
echo $tableProducts.'</table>';


$conn->close();
?>

</body>
</html>