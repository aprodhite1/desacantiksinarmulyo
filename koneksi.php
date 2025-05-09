<?php
$servername = "localhost";
$database = "u890967115_descan";
$username = "root";
$password = "";
 
// Create connection
 
$conn = mysqli_connect($servername, $username, $password, $database);
 
// Check connection
 
if (!$conn) 
    die("Connection failed: " . mysqli_connect_error());
$hasil= mysqli_select_db ($conn, $database);
if (!$hasil) {
    $hasil = mysqli_query($conn, "CREATE DATABASE $database");
    if (!$hasil)
        die("Database tidak dapat dibuat");
    else
        $hasil= mysqli_select_db ($conn, $database);
        if (!$hasil) die ("Database tidak dapat diakses");
    
}

?>