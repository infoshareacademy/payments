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
    $output .= '<th>Invoice number</th>';
    $output .= '<th>Amount</th>';
    $output .= '<th>Issue date</th>';
    $output .= '<th>Maturity date</th>';
    $output .= '<th>Payment date</th>';
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
        $output .= '<td><a href="?edit=' . $record['id'] . '">EDIT</a></td>';
        $output .= '</tr>';
    }
    $output .= '</table>';
    $output .= '<br/><br/>';

    return $output;
}
