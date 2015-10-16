<?php
require 'phpMailer/class.phpmailer.php';
require 'sqli_connection_header.php';


$sql = 'SELECT id, Signature, Amount, Issue_date, Maturity_date FROM invoices WHERE Maturity_date = CURRENT_DATE ';
$sqlQueryContent = mysqli_query($conn, $sql);

$MailContent = '

    <table>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Numer faktury</th>
            <th>Kwota</th>
            <th>Data wystawienia</th>
            <th>Data płatności</th>
        </tr>
        </thead>
        <tbody>
        <tr>

        ';


while ($result = $sqlQueryContent->fetch_assoc()) {
    $MailContent = $MailContent . "<tr>" .
        "<td>" . $result["id"] . "</td>" .
        "<td>" . $result["Signature"] . "</td>" .
        "<td>" . $result["Amount"] . "</td>" .
        "<td>" . $result["Issue_date"] . "</td>" .
        "<td>" . $result["Maturity_date"] . "</td>"
        . "</tr>";
}

$mail = new PHPMailer();
$mail->IsHTML(true);
$mail->Subject = 'PAYMENTS - przypomnienia o płatnościach na dzień:' . ' ' . date('d.m.Y');
$mail->AddAddress('pawel.zawodny@gmail.com');
$mail->Body = " <b>Twoje dzisiejsze faktury do opłacenia:</b> \n";
$mail->Body .= $MailContent;

if ($sqlQueryContent->num_rows > 0) {

    $mail->Send();
}