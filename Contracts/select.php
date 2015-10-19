<?php
/**
 * Created by PhpStorm.
 * User: Monika
 * Date: 2015-10-17
 * Time: 19:04
 */

function renderSelectInput($selectedItemId) {
    ?>
    Umowa: <select name="signature_id">
        <?php
        $pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');
        $stmt = $pdo->query('SELECT id, companyName FROM contract');
        $contracts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $selected_contract = $selectedItemId;
        foreach ($contracts as $one_contract) {
            echo '<option value="' . $one_contract['id'] . '" ';
            if (
                isset($selected_contract) &&
                $selected_contract == $one_contract['id']
            ) {
                echo 'selected';
            }
            echo '>' . $one_contract['companyName'] . '</option>';
        }
        print_r($contracts);
        ?>
    </select><br>
    <?php
}
?>