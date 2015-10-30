<?php
require __DIR__ . '/../Model/PDOobjectCreateClass.php';


function sqlReports()
{

    $output = '';

    $output .= '<h1 class="page-header">Reports</h1>';
    $output .= '<h2>Pre-defined reports:</h2>';

    $pdo = DBHandler::getPDO();
//niezapłacone faktury
    $unpaidInvoices = $pdo->query('SELECT companyName, Signature, Amount, Maturity_date FROM payment_report WHERE Payment_date IS NULL ORDER BY Maturity_date ASC ;');
    $unpaidInvoices = $unpaidInvoices->fetchAll(PDO::FETCH_ASSOC);
//print_r($unpaidInvoices);
    $output .= '<h2>Report: Unpaid invoices:</h2>';
    $output .= '<table class="table table-hover">';
    $output .= '<tr>';
    $output .= '<th>Company name</th>';
    $output .= '<th>Signature</th>';
    $output .= '<th>Amount</th>';
    $output .= '<th>Maturity date</th>';
    foreach ($unpaidInvoices as $item) {
        $output .= '<tr>';
        $output .= '<td>' . $item['companyName'] . '<br></td>';
        $output .= '<td>' . $item['Signature'] . '<br></td>';
        $output .= '<td>' . $item['Amount'] . '<br></td>';
        $output .= '<td>' . $item['Maturity_date'] . '<br></td>';
        $output .= '</tr>';
    }
    $output .= '</table>';
    $output .= '<br/><br/>';
//Suma w podziale na firmy
    $SumForCompany = $pdo->query('SELECT companyName, sum(Amount) FROM payment_report GROUP BY companyName ORDER BY sum(Amount) DESC ;');
    $SumForCompany = $SumForCompany->fetchAll(PDO::FETCH_ASSOC);
//print_r($SumForCompany);
    $output .= '<h2>Report: Sum for companies</h2>';
    $output .= '<table class="table table-hover">';
    $output .= '<tr>';
    $output .= '<th>Company name</th>';
    $output .= '<th>Sum</th>';
    foreach ($SumForCompany as $item) {
        $output .= '<tr>';
        $output .= '<td>' . $item['companyName'] . '<br></td>';
        $output .= '<td>' . $item['sum(Amount)'] . '<br></td>';
        $output .= '</tr>';
    }
    $output .= '</table>';
    $output .= '<br/><br/>';
//lista zapłaconych po terminie
    $listOfInvPaidAfterMaturity = $pdo->query('SELECT companyName, Signature, Amount, Maturity_date, Payment_date FROM payment_report WHERE Payment_date>Maturity_date ORDER BY Payment_date DESC;');
    $listOfInvPaidAfterMaturity = $listOfInvPaidAfterMaturity->fetchAll(PDO::FETCH_ASSOC);
//print_r($unpaidInvoices);
    $output .= '<h2>Report: Invoices paid after maturity day:</h2>';
    $output .= '<table class="table table-hover">';
    $output .= '<tr>';
    $output .= '<th>Company name</th>';
    $output .= '<th>Signature</th>';
    $output .= '<th>Amount</th>';
    $output .= '<th>Maturity date</th>';
    $output .= '<th>Payment date</th>';
    foreach ($listOfInvPaidAfterMaturity as $item) {
        $output .= '<tr>';
        $output .= '<td>' . $item['companyName'] . '<br></td>';
        $output .= '<td>' . $item['Signature'] . '<br></td>';
        $output .= '<td>' . $item['Amount'] . '<br></td>';
        $output .= '<td>' . $item['Maturity_date'] . '<br></td>';
        $output .= '<td>' . $item['Payment_date'] . '<br></td>';
        $output .= '</tr>';
    }
    $output .= '</table>';
    $output .= '<br/><br/>';

    return $output;
}
