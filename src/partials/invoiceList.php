<?php

require_once __DIR__ . '/../Model/InvoiceClass.php';

function invoiceList()
{
    $output = '';

    $output .= '<br/><br/>';
    $output .= '<h1 class="page-header">Payment List</h1>';

    $output .= '<table class="table table-hover">';
    $output .= '<tr>';
    $output .= '<th>ID</th>';
    $output .= '<th>Nazwa faktury</th>';
    $output .= '<th>Kwota</th>';
    $output .= '<th>Data wystawienia</th>';
    $output .= '<th>Data płatności</th>';
    $output .= '<th>Data opłacenia</th>';
    $output .= '</tr>';

    $invoiceList = InvoiceClass::invoiceTable();
    foreach ($invoiceList as $record) {

        $output .= '<tr>';
        $output .= '<td>' . $record['id'] . '</td>';
//    $output .= '<td>'.$record['id_contract'].'</td>';
        $output .= '<td>' . $record['Signature'] . '</td>';
        $output .= '<td>' . $record['Amount'] . '</td>';
        $output .= '<td>' . $record['Issue_date'] . '</td>';
        $output .= '<td>' . $record['Maturity_date'] . '</td>';
        $output .= '<td>' . $record['Payment_date'] . '</td>';
        $output .= '<td><a href="?edit=' . $record['id'] . '">edytuj</a></td>';
        $output .= '</tr>';
    }
    $output .= '</table>';
    $output .= '<br/><br/>';

    return $output;
}
