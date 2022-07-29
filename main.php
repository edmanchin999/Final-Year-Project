<?php
include_once 'database.php';
if (!isset($_SESSION['loggedin'])) {
    header("LOCATION: logout.php");
}



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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        body {
            background: white;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            border: transparent;
            width: 1140px;
            height: 180px;
        }

        .button {
            display: inline-block;
            height: 50px;
            width: 100px;
        }

        .row {
            height: 50%;
            width: 50%;
            display: flex;

        }

        .column {
            height: 50%;
            width: 50%;
            flex: 50%;
            padding: 50px;

        }
    </style>

</head>

<body>

    <?php include_once 'nav_bar.php'; ?>
    <?php

    ?>

    <center>
        <h2>Selamat Datang</h2>

        <div class="row">
            <div class="column">
                <h3>Paras Air</h3>
                <a href="water.php">
                    <input type="image" src="water_level_icon.png" alt="water_level" href="water.php" style="width:100%"></input></a>
                <p>Paras Air Semasa: <?php
                                        try {
                                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $stmt = $conn->prepare("SELECT * FROM tbl_water_level WHERE fld_water_level_id=(SELECT max(fld_water_level_id) FROM tbl_water_level);");
                                            $stmt->execute();
                                            $result = $stmt->fetchAll();
                                        } catch (PDOException $e) {
                                            echo "Error: " . $e->getMessage();
                                        }
                                        foreach ($result as $readrow) {
                                        ?>

                        <?php echo $readrow['fld_water_level_number'];
                                            if ($readrow['fld_water_level_number'] < 20) {
                                                echo "<br>";
                                                echo "<h5><font color=red>Amaran : Kena Isi Balik Alcohol !</font><h5>";
                                            }

                        ?>




                    <?php
                                        }
                                        $conn = null;
                    ?>
            </div>
            <div class="column">
                <h3>Rekod Pengguna</h3>
                <a href="temperature.php">
                    <input type="image" src="body_temperature_icon.png" alt="temperature" style="width:100%"></a>
                <p>Jumlah Pengguna:<?php
                                    try {
                                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $stmt = $conn->prepare("SELECT * FROM tbl_temperature WHERE fld_temperature_id=(SELECT max(fld_temperature_id) FROM tbl_temperature);");
                                        $stmt->execute();
                                        $result = $stmt->fetchAll();
                                    } catch (PDOException $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    foreach ($result as $readrow) {
                                    ?>

                    <?php echo $readrow['fld_temperature_id']; ?>


                <?php
                                    }
                                    $conn = null;
                ?></p>
                <p>Purata Suhu Badan: <?php
                                        try {
                                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $stmt = $conn->prepare("SELECT AVG(fld_temperature_degree) fld_temperature_degree
                                        FROM tbl_temperature ");
                                            $stmt->execute();
                                            $result = $stmt->fetchAll();
                                        } catch (PDOException $e) {
                                            echo "Error: " . $e->getMessage();
                                        }
                                        foreach ($result as $readrow) {
                                        ?>

                        <?php echo $readrow['fld_temperature_degree']; ?>


                    <?php
                                        }
                                        $conn = null;
                    ?></p>
                </p>
                <p>Jumlah Pengguna sihat: <?php
                                            try {
                                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                $stmt = $conn->prepare("SELECT COUNT(fld_temperature_degree) fld_temperature_degree FROM tbl_temperature WHERE fld_temperature_degree < 37.5");
                                                $stmt->execute();
                                                $result = $stmt->fetchAll();
                                            } catch (PDOException $e) {
                                                echo "Error: " . $e->getMessage();
                                            }
                                            foreach ($result as $readrow) {
                                            ?>

                        <?php echo $readrow['fld_temperature_degree']; ?>


                    <?php
                                            }
                                            $conn = null;
                    ?></p>
                </p>
                <p>Jumlah Pengguna Tidak Sihat: <?php
                                                try {
                                                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                    $stmt = $conn->prepare("SELECT COUNT(fld_temperature_degree) fld_temperature_degree FROM tbl_temperature WHERE fld_temperature_degree >= 37.5");
                                                    $stmt->execute();
                                                    $result = $stmt->fetchAll();
                                                } catch (PDOException $e) {
                                                    echo "Error: " . $e->getMessage();
                                                }
                                                foreach ($result as $readrow) {
                                                ?>

                        <?php echo $readrow['fld_temperature_degree']; ?>


                    <?php
                                                }
                                                $conn = null;
                    ?></p>
                </p>
            </div>

        </div>
    </center>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>