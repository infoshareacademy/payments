<?php

require_once __DIR__ . '/../Model/InvoiceClass.php';

echo '<table class="table table-hover">';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Nazwa faktury</th>';
echo '<th>Kwota</th>';
echo '<th>Data wystawienia</th>';
echo '<th>Data płatności</th>';
echo '<th>Data opłacenia</th>';
echo '</tr>';

$invoiceList = InvoiceClass::invoiceTable();
foreach ($invoiceList as $record) {

    echo '<tr>';
    echo '<td>'.$record['id'].'</td>';
//    echo '<td>'.$record['id_contract'].'</td>';
    echo '<td>'.$record['Signature'].'</td>';
    echo '<td>'.$record['Amount'].'</td>';
    echo '<td>'.$record['Issue_date'].'</td>';
    echo '<td>'.$record['Maturity_date'].'</td>';
    echo '<td>'.$record['Payment_date'].'</td>';
    echo '<td><a href="?edit='.$record['id'].'">edytuj</a></td>';
    echo '</tr>';
}
echo '</table>';
echo '<br/><br/>';
