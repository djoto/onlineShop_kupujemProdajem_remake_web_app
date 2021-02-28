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

$sql = "SELECT idU, firstnameU, lastnameU, emailU, usernameU, passwdU, accountTypeU, statusLogInOutU, blockedU FROM allUsersKP";
$result = $conn->query($sql);
$tableUsers = '<table>
<tr>
<th>idU</th>
<th>firstnameU</th>
<th>lastnameU</th>
<th>emailU</th>
<th>usernameU</th>
<th>passwdU</th>
<th>accountTypeU</th>
<th>statusLogInOutU</th>
<th>blockedU</th>
</tr>';

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $tableUsers .= '<tr>
        <td>'.$row["idU"].'</td>
        <td>'.$row["firstnameU"].'</td>
        <td>'.$row["lastnameU"].'</td>
        <td>'.$row["emailU"].'</td>
        <td>'.$row["usernameU"].'</td>
        <td>'.$row["passwdU"].'</td>
        <td>'.$row["accountTypeU"].'</td>
        <td>'.$row["statusLogInOutU"].'</td>
        <td>'.$row["blockedU"].'</td>
        </tr>';
    }

} else {
    echo "0 results";
}

echo $tableUsers."</table>";



$conn->close();
?>

</body>
</html>
