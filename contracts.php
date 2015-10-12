<?php
/**
 * Created by PhpStorm.
 * User: ceomarek
 * Date: 08.10.15
 * Time: 16:00
 */

$servername = "test.payments.infoshareaca.nazwa.pl";
$username = "infoshareaca_7";
$password = "F0r3v3r!";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $username);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = 'SELECT id, Signature FROM contract';

$contracts = $conn->query($sql);

echo mysqli_error($conn);

?>
    <table>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Numer umowy</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php

            if ($contracts->num_rows > 0) {
                // output data of each row
                while($contract = $contracts->fetch_assoc()) {
                    echo
                        "<tr>" .
                        "<td>" . $contract["id"]."</td>" .
                        "<td>" . $contract["Signature"] ."</td>" .
                        "</tr>";
                }
            } else {
                    echo "0 results";
            }
            $conn->close();
            ?>
        </tr>
        </tbody>
    </table>


