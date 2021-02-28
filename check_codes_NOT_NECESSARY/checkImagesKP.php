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

$sql = "SELECT idIm, idProductIm, imagePathIm FROM allImagesP";
$result = $conn->query($sql);
$imagesTable = '<table>
<tr>
<th>idIm</th>
<th>idProductIm</th>
<th>imagePathIm</th>
</tr>';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $imagesTable.='<tr>
        <td>'.$row["idIm"].'</td>
        <td>'.$row["idProductIm"].'</td>
        <td>'.$row["imagePathIm"].'</td>
        </tr>';
    }
} else {
    echo "0 results";
}
echo $imagesTable.'</table>';
$conn->close();
?>

</body>
</html>