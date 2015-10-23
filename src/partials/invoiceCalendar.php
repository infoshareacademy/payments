<?php

// łaczenie i pobieranie z bazy bez tworzenia obiektu - w razie co, dodać obiekt

$pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');

//Kalendarz faktur
$futureInvoices = $pdo->query('SELECT * FROM payment_report WHERE Payment_date IS NOT NULL AND Maturity_date > CURDATE() AND Maturity_date < date_add(CURDATE(), INTERVAL 30 DAY) ORDER BY Maturity_date ASC ;');
$futureInvoices = $futureInvoices->fetchAll(PDO::FETCH_ASSOC);

echo '<h2>Najbliższe faktury do opłacenia (30 dni):</h2>';
echo '<table class="table table-hover">';
echo '<tr>';
echo '<th>Company name</th>';
echo '<th>Signature</th>';
echo '<th>Amount</th>';
echo '<th>Maturity date</th>';
foreach ($futureInvoices as $item) {
    echo '<tr>';
    echo '<td>' . $item['companyName'] . '<br></td>';
    echo '<td>' . $item['Signature'] . '<br></td>';
    echo '<td>' . $item['Amount'] . '<br></td>';
    echo '<td>' . $item['Maturity_date'] . '<br></td>';
    echo '</tr>';
}
echo '</table>';
echo '<br/><br/>';

for () {

}
