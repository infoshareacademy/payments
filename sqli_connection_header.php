<?php
// Include this file, if you want to connect to database via sqli. You Can use variables from this script in your own file.
// Dont forget to add  $conn->close(); statement at the end of the file

$servername = "test.payments.infoshareaca.nazwa.pl";
    $username = "infoshareaca_7";
    $password = "F0r3v3r!";

// Create connection
    $conn = mysqli_connect($servername, $username, $password, $username);

// Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }