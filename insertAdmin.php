
<?php
include_once 'database.php';
$conn = mysqli_connect("lrgs.ftsm.ukm.my", "a175894", "bigpinkturtle", "a175894");

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. "
        . mysqli_connect_error());
}

// Taking all 5 values from the form data(input)
$username =  $_REQUEST['username'];
$password = $_REQUEST['pass'];

// Performing insert query execution
// here our table name is college
$sql = "INSERT INTO tbl_admin VALUES ('null','$username', 
              '$password')";

if (mysqli_query($conn, $sql)) {
    echo "<h3>Daftar Berjaya ! Sila balik ke web login</h3>";
} else {
    echo "Daftar tidak berjaya , sila cuba lagi $sql. "
        . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>