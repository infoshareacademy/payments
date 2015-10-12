<?php
/**
 * Created by PhpStorm.
 * User: marek
 * Date: 09.10.15
 * Time: 16:26
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
echo "Podłączono do bazy danych"."<br>";

if (@$_GET['delete']) {
     $conn->query('delete from invoices where id = '.(int)$_GET['delete']);
}


$sql = 'SELECT id, Signature, Amount, Issue_date, Maturity_date, Payment_date FROM invoices';

$contracts = $conn->query($sql);

echo mysqli_error($conn);

?>
<table>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Numer faktury</th>
            <th>Kwota</th>
            <th>Data wystawienia</th>
            <th>Data płatności</th>
            <th>Data opłacenia</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php

            if ($contracts->num_rows > 0) {
                // output data of each row
                while($contract = $contracts->fetch_assoc()) {
                    echo "<tr>" .
                         "<td>" . $contract["id"]."</td>" .
                         "<td>". $contract["Signature"] ."</td>" .
                         "<td>". $contract["Amount"] ."</td>" .
                         "<td>". $contract["Issue_date"] ."</td>" .
                         "<td>". $contract["Maturity_date"] ."</td>" .
                         "<td>". $contract["Payment_date"] ."</td>".
                         "<td><a href='?delete=". $contract["id"] ."'>usun</a></td>"
                         . "</tr>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </tr>
        </tbody>
    </table>

