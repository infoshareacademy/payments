<?php

require_once 'Model/InvoiceClass.php';

echo '<table>';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Numer umowy</th>';
echo '<th>Nazwa faktury</th>';
echo '<th>Data wystawienia</th>';
echo '<th>Data płatności</th>';
echo '<th>Data opłacenia</th>';
echo '</tr>';

$invoiceList = InvoiceClass::invoiceTable();
foreach ($invoiceList as $record) {

    echo '<tr>';
    echo '<td>'.$record['id'].'</td>';
    echo '<td>'.$record['id_contract'].'</td>';
    echo '<td>'.$record['Amount'].'</td>';
    echo '<td>'.$record['Issue_date'].'</td>';
    echo '<td>'.$record['Maturity_date'].'</td>';
    echo '<td>'.$record['Payment_date'].'</td>';
    echo '<td><a href="?edit='.$record['id'].'">edytuj</a> <a href="?delete='.$record['id'].'">usun</a></td>';
    echo '</tr>';
}
echo '</table>';
echo '<br/><br/>';
