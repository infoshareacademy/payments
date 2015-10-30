<?php

// łaczenie i pobieranie z bazy bez tworzenia obiektu - w razie co, dodać obiekt
function invoiceCalendar()
{

    $pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');

//Kalendarz faktur
    $futureInvoices = $pdo->query('SELECT * FROM payment_report WHERE Payment_date IS NULL AND Maturity_date > CURDATE() AND Maturity_date < date_add(CURDATE(), INTERVAL 30 DAY) ORDER BY Maturity_date ASC ;');
    $futureInvoices = $futureInvoices->fetchAll(PDO::FETCH_ASSOC);

    $futureInvoicesLength = count($futureInvoices);
    date_default_timezone_set('UTC');
    $startTime = strtotime('today');
    $endTime = $startTime + 30 * 86400;

    echo '<table class="table table-hover">';
    echo '<tr>';
    echo '<th>Date</th>';
    echo '<th>Company name</th>';
    echo '<th>Signature</th>';
    echo '<th>Amount</th>';
    echo '</tr>';

    for ($j = $startTime; $j <= $endTime; $j = $j + 86400) {
        $thisDate = date('Y-m-d', $j);
        echo '<tr>';
        echo '<td rowspan="1">' . $thisDate . '</td>';

        $foundInvoiceForDay = false;
        if ($thisDate) {
            for ($i = 0; $i < $futureInvoicesLength; $i++) {
                if ($thisDate == $futureInvoices[$i]['Maturity_date']) {
                    if ($foundInvoiceForDay) {
                        echo '<td></td>';
                    }
                    $foundInvoiceForDay = true;
                    echo '<td>' . $futureInvoices[$i]['companyName'] . '</td>';
                    echo '<td>' . $futureInvoices[$i]['Signature'] . '</td>';
                    echo '<td>' . $futureInvoices[$i]['Amount'] . '</td>';
                    echo '</tr>';
                }
            }
        }
        if (!$foundInvoiceForDay) {
            for ($i = 0; $i < 3; $i++) {
                echo '<td></td>';
            }
            echo '</tr>';
        }
    }

    echo '</table>';
}