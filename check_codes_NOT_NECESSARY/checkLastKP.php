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

$sql = "SELECT idL, lastId FROM lastProductId";
$result = $conn->query($sql);
$tableLast = '<table>
<tr>
<th>idL</th>
<th>lastId <i>(LAST PRODUCT INSERTED ID)</i></th>
</tr>';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $tableLast .= '<tr>
        <td>'.$row["idL"].'</td>
        <td>'.$row["lastId"].'</td>
        </tr>';
    }
} else {
    echo "0 results";
}
echo $tableLast.'</table>';

$conn->close();
?>

</body>
</html>