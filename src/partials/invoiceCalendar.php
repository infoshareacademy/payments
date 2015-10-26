<?php

// łaczenie i pobieranie z bazy bez tworzenia obiektu - w razie co, dodać obiekt

$pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');

//Kalendarz faktur
$futureInvoices = $pdo->query('SELECT * FROM payment_report WHERE Payment_date IS NULL AND Maturity_date > CURDATE() AND Maturity_date < date_add(CURDATE(), INTERVAL 30 DAY) ORDER BY Maturity_date ASC ;');
$futureInvoices = $futureInvoices->fetchAll(PDO::FETCH_ASSOC);

$futureInvoicesLength = count($futureInvoices);
$startTime = strtotime('today');
$endTime = $startTime + 30 * 86400;

echo '<table class="table table-hover">';
echo '<tr>';
echo '<th>Date</th>';
echo '<th>Company name</th>';
echo '<th>Signature</th>';
echo '<th>Amount</th>';

for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
    $thisDate = date( 'Y-m-d', $i );
    echo '<tr>';
    echo '<td>'.$thisDate.'<br></td>';

    if($thisDate) {
        for($i=0; $i < $futureInvoicesLength; $i++ ){
            print
        }
        echo '<td>'.$futureInvoices[0]['companyName'].'<br></td>';
        echo '<td>'.$futureInvoices[0]['Signature'].'<br></td>';
        echo '<td>'.$futureInvoices[0]['Amount'].'<br></td>';
    }
    echo '</tr>';

    }

echo '</table>';