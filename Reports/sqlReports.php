<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 16.10.15
 * Time: 14:27
 */

$pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');
//niezapłacone faktury
$unpaidInvoices = $pdo->query('SELECT companyName, Signature, Amount, Maturity_date FROM payment_report WHERE Payment_date IS NULL ORDER BY Maturity_date ASC ;');
$unpaidInvoices = $unpaidInvoices->fetchAll(PDO::FETCH_ASSOC);
//print_r($unpaidInvoices);
echo '<h2>Report: Unpaid invoices:</h2>';
echo '<table class="table table-hover">';
echo '<tr>';
echo '<th>Company name</th>';
echo '<th>Signature</th>';
echo '<th>Amount</th>';
echo '<th>Maturity date</th>';
foreach ($unpaidInvoices as $item) {
    echo '<tr>';
    echo '<td>'.$item['companyName'].'<br></td>';
    echo '<td>'.$item['Signature'].'<br></td>';
    echo '<td>'.$item['Amount'].'<br></td>';
    echo '<td>'.$item['Maturity_date'].'<br></td>';
    echo '</tr>';
}
echo '</table>';
echo '<br/><br/>';
//Suma w podziale na firmy
$SumForCompany = $pdo->query('SELECT companyName, sum(Amount) FROM payment_report GROUP BY companyName ORDER BY sum(Amount) DESC ;');
$SumForCompany = $SumForCompany->fetchAll(PDO::FETCH_ASSOC);
//print_r($SumForCompany);
echo '<h2>Report: Sum for companies</h2>';
echo '<table class="table table-hover">';
echo '<tr>';
echo '<th>Company name</th>';
echo '<th>Sum</th>';
foreach ($SumForCompany as $item) {
    echo '<tr>';
    echo '<td>'.$item['companyName'].'<br></td>';
    echo '<td>'.$item['sum(Amount)'].'<br></td>';
    echo '</tr>';
}
echo '</table>';
echo '<br/><br/>';
//lista zapłaconych po terminie
$listOfInvPaidAfterMaturity = $pdo->query('SELECT companyName, Signature, Amount, Maturity_date, Payment_date FROM payment_report WHERE Payment_date>Maturity_date ORDER BY Payment_date DESC;');
$listOfInvPaidAfterMaturity = $listOfInvPaidAfterMaturity->fetchAll(PDO::FETCH_ASSOC);
//print_r($unpaidInvoices);
echo '<h2>Report: Invoices paid after maturity day:</h2>';
echo '<table class="table table-hover">';
echo '<tr>';
echo '<th>Company name</th>';
echo '<th>Signature</th>';
echo '<th>Amount</th>';
echo '<th>Maturity date</th>';
echo '<th>Payment date</th>';
foreach ($listOfInvPaidAfterMaturity as $item) {
    echo '<tr>';
    echo '<td>'.$item['companyName'].'<br></td>';
    echo '<td>'.$item['Signature'].'<br></td>';
    echo '<td>'.$item['Amount'].'<br></td>';
    echo '<td>'.$item['Maturity_date'].'<br></td>';
    echo '<td>'.$item['Payment_date'].'<br></td>';
    echo '</tr>';
}
echo '</table>';
echo '<br/><br/>';