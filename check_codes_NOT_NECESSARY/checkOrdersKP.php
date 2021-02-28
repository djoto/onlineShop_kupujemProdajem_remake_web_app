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

$sql = "SELECT idO, idCustomerO, idSellerO, idProductO, acceptedO, deniedO, cancelledO, paymentTypeO, quantityO FROM KPallOrders";
$result = $conn->query($sql);
$tableOrders = '<table>
<tr>
<th>idO</th>
<th>idCustomerO</th>
<th>idSellerO</th>
<th>idProductO</th>
<th>acceptedO</th>
<th>deniedO</th>
<th>cancelledO</th>
<th>paymentTypeO</th>
<th>quantityO</th>
</tr>';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $tableOrders .= '<tr>
        <td>'.$row["idO"].'</td>
        <td>'.$row["idCustomerO"].'</td>
        <td>'.$row["idSellerO"].'</td>
        <td>'.$row["idProductO"].'</td>
        <td>'.$row["acceptedO"].'</td>
        <td>'.$row["deniedO"].'</td>
        <td>'.$row["cancelledO"].'</td>
        <td>'.$row["paymentTypeO"].'</td>
        <td>'.$row["quantityO"].'</td>
        </tr>';
    }
} else {
    echo "0 results";
}
echo $tableOrders.'</table>';
$conn->close();
?>

</body>
</html>