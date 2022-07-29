<?php
include_once 'database.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>SISTEM PENGURUSAN PENYEMBUR PEMBERSIH BADAN AUTOMATIK
        BERASASKAN IOT</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> </title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include_once 'nav_bar.php'; ?>
    <center>
        <h2>Rekod Pengguna</h2>
        <hr>
        <table border="1">
            <tr>
                <td>Suhu ID</td>
                <td>Masa Direkod</td>
                <td>Suhu Badan('C)</td>
            </tr>
            <?php
            // Read
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("SELECT * FROM tbl_temperature");
                $stmt->execute();
                $result = $stmt->fetchAll();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            foreach ($result as $readrow) {
            ?>
                <tr>
                    <td><?php echo $readrow['fld_temperature_id']; ?></td>
                    <td><?php echo $readrow['fld_temperature_timestamp']; ?></td>
                    <td><?php echo $readrow['fld_temperature_degree']; ?></td>
                </tr>
            <?php
            }
            $conn = null;
            ?>

        </table>
    </center>
</body>

</html>