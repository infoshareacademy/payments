
<?php

function renderSelectInput($selectedItemId) {
    $output = '';

    $output .= 'Umowa: <select name="signature_id">';

    $pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');
    $stmt = $pdo->query('SELECT id, companyName FROM contract');
    $contracts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $selected_contract = $selectedItemId;
    foreach ($contracts as $one_contract) {
        $output .= '<option value="' . $one_contract['id'] . '" ';
        if (
            isset($selected_contract) &&
            $selected_contract == $one_contract['id']
        ) {
            $output .= 'selected';
        }
        $output .= '>' . $one_contract['companyName'] . '</option>';
    }

    $output .= '</select><br>';

    return $output;
}