<?php
/**
 * Created by PhpStorm.
 * User: marek
 * Date: 14.10.15
 * Time: 13:22
 */

class InvoiceClass
{

    public $id;
    public $signature_id;
    public $signature;
    public $amount;
    public $issue_date;
    public $maturity_date;
    public $payment_date;

    const MAX_LENGHT = 70;
    const SAVE_OK = 1;
    const SAVE_ERROR_DB = 2;
    const SAVE_ERROR_DUPLICATE_SIG = 3;


    private $pdo;

    public function __construct($id = null)
    {
        $this->pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');

        if ($id) {
            $stmt = $this->pdo->query("select * from invoices where id=".(int)$id);
            if ($stmt->rowCount()>0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $result['id'];
                $this->signature_id = $result['id_contract'];
                $this->signature = $result['Signature'];
                $this->amount = $result['Amount'];
                $this->issue_date = $result['Issue_date'];
                $this->maturity_date = $result['Maturity_date'];
                $this->payment_date = $result['Payment_date'];
            }
            else {
                throw new Exception('Brak takiego ID='.$id);
            }
        }

    }

    public function __set($param_name, $param_value) {
        switch ($param_name) {
            case 'id':
                if (!$param_value || !(int)$param_value)
                    $this->id = null;
                else
                    $this->id = (int)$param_value;
                break;
            case 'signature_id':
                if (!$param_value || !(int)$param_value)
                    $this->signature_id = null;
                else
                    $this->signature_id = (int)$param_value;
                break;
            case 'signature':
                if (!$param_value || strlen($param_value)>self::MAX_LENGHT)
                    $this->signature = null;
                else
                    $this->signature = htmlspecialchars($param_value);
                break;
            case 'amount':
                if (!$param_value || !(floatval($param_value)))
                    $this->amount = null;
                else
                    $this->amount = floatval($param_value);
                break;
            case 'issue_date':
                if (!$param_value || !preg_match('/^[\d]{4}\-[\d]{2}\-[\d]{2}$/', $param_value))
                    $this->issue_date = null;
                else
                $this->issue_date = $param_value;
                break;
            case 'maturity_date':
                if (!$param_value || !preg_match('/^[\d]{4}\-[\d]{2}\-[\d]{2}$/sx', $param_value))
                    $this->maturity_date = null;
                else
                $this->maturity_date = $param_value;
                break;
            case 'payment_date':
                if (!$param_value || !preg_match('/^[\d]{4}\-[\d]{2}\-[\d]{2}$/sx', $param_value))
                    $this->payment_date = null;
                else
                $this->payment_date = $param_value;
                break;
            default:
                $this->$param_name = $param_value;
                break;
        }
    }

    public function __get($param_name)
    {
        return $this->$param_name;
    }

    public function save_to_db() {

        print_r($this);

        if ($this->id) {
            $stmt = $this->pdo->prepare("UPDATE invoices SET
                id=:identity,
                id_contract=:id_kontraktu,
                Signature=:sygnatura,
                Amount=:kwota,
                Issue_date=:data_wystawienia,
                Maturity_date=:data_platnosci,
                Payment_date=:data_oplacenia
                WHERE id=:identity
                ");

            print_r($stmt);

            $input_parameters = array(
                ':identity' => $this->id,
                ':id_kontraktu' => $this->signature_id,
                ':sygnatura' => $this->signature,
                ':kwota' => $this->amount,
                ':data_wystawienia' => $this->issue_date,
                ':data_platnosci' => $this->maturity_date,
                ':data_oplacenia' => $this->payment_date
            );

            print_r($input_parameters);

            if($input_parameters[':data_oplacenia'] == null) {
                $input_parameters['::data_oplacenia'] = 'NULL';
            }

            $upload = $stmt->execute(
                $input_parameters
            );
        }

// połączenie z bazą i sprawdzenie czy numer faktury nie dubluje się
        else {
            $stmt = $this->pdo->query("SELECT * FROM invoices WHERE Signature='" . $this->signature . "'");
            if ($stmt->rowCount() > 0)
                return self::SAVE_ERROR_DUPLICATE_SIG;

            // zapisanie do bazy danych

            $stmt = $this->pdo->prepare("INSERT INTO invoices VALUES (NULL, :signature_id, :signature, :amount, :issue_date, :maturity_date, :payment_date)");
            $upload = $stmt->execute(
                array(
                    ':signature_id' => $this->signature_id,
                    ':signature' => $this->signature,
                    ':amount' => $this->amount,
                    ':issue_date' => $this->issue_date,
                    ':maturity_date' => $this->maturity_date,
                    ':payment_date' => $this->payment_date
                )
            );
        }

// wyświetlenie komunikatu o stanie zapisu

        if ($upload)
            return self::SAVE_OK;
        else
            return self::SAVE_ERROR_DB;

    }

// Metoda do pobierania rekordów z DB do wyświetlenia ich na stronie

    public static function invoiceTable() {
        $pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');
        $stmt = $pdo->query('SELECT * FROM invoices');
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}

if (@$_GET['edit'] && (int)$_GET['edit']) {
    $edit = (int)$_GET['edit'];
    $invoice= new InvoiceClass($edit);
}

if (@$_GET['delete'] && (int)$_GET['delete']) {
    $delete_entry = (int)$_GET['delete'];
}

$error = array();
if (count($_POST)) {
    $invoice = new InvoiceClass();

    $invoice->id = @$_POST['id'];

    $invoice->signature_id = @$_POST['signature_id'];

    $invoice->signature = @$_POST['signature'];
    if (!$invoice->signature) // if null
        $error['signature'] = 'Podaj nazwę faktury';

    $invoice->amount = @$_POST['amount'];
    if (!$invoice->amount)
        $error['amount'] = 'Podaj kwotę z faktury';

    $invoice->issue_date = @$_POST['issue_date'];
    if (!$invoice->issue_date)
        $error['issue_date'] = 'Podaj poprawną datę lub skorzystaj z kalendarza';

    $invoice->maturity_date = @$_POST['maturity_date'];
    if (!$invoice->maturity_date)
        $error['maturity_date'] = 'Podaj poprawną datę lub skorzystaj z kalendarza';

    $invoice->payment_date = @$_POST['payment_date'];
//    if (!$invoice->payment_date)
//        $error['payment_date'] = 'Podaj poprawną datę lub skorzystaj z kalendarza';

    print_r($error);

    if (!count($error)) {
        $upload = $invoice->save_to_db();
        if ($upload==InvoiceClass::SAVE_OK)
            $success = 'Brawo! Dodałeś nowy rekord do bazy';
        else if ($upload==InvoiceClass::SAVE_ERROR_DUPLICATE_SIG) {
            $error['signature'] = 'Faktura o tym numerze już istnieje.';
        }
        else {
            $error['general'] = 'Błąd zapisu do bazy danych.';
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formularz</title>

</head>
<body>

<?php

    echo '<table>';
        echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Numer umowy</th>';
            echo '<th>Nazwa faktury</th>';
            echo '<th>Data wystawienia</th>';
            echo '<th>Data płatności</th>';
            echo '<th>Data opłacenia</th>';
        echo '</tr>';

            $invoiceList = InvoiceClass::invoiceTable();
            foreach ($invoiceList as $record) {

                echo '<tr>';
                echo '<td>'.$record['id'].'</td>';
                echo '<td>'.$record['id_contract'].'</td>';
                echo '<td>'.$record['Amount'].'</td>';
                echo '<td>'.$record['Issue_date'].'</td>';
                echo '<td>'.$record['Maturity_date'].'</td>';
                echo '<td>'.$record['Payment_date'].'</td>';
                echo '<td><a href="?edit='.$record['id'].'">edytuj</a> <a href="?delete='.$record['id'].'">usun</a></td>';
                echo '</tr>';
            }
    echo '</table>';
    echo '<br/><br/>';

    if (@$success)
        echo '<div style="color:#22aa22; font-weight:bold;">'.$success.'</div><br/>';
    if (@$error['general'])
        echo '<div style="color:#f00; font-weight:bold;">'.$error['general'].'</div><br/>';

echo '<form action="?" method="post">';
echo '<input name="id" type="hidden" value="'.@$invoice->id.'"/><br>';
echo 'Numer umowy: <input name="signature_id" value="'.@$invoice->signature_id.'"/><br>';

include_once('../select.php');

echo 'Numer faktury: <input name="signature" value="'.@$invoice->signature.'"/><br><div style="color:#f00;">'.@$error['signature'].'</div>';
echo 'Kwota: <input name="amount" value="'.@$invoice->amount.'" /><br><div style="color:#f00;">'.@$error['amount'].'</div>';
echo 'Data wystawienia: <input name="issue_date" type="date" value="'.@$invoice->issue_date.'" /><br><div style="color:#f00;">'.@$error['issue_date'].'</div>';
echo 'Data płatności: <input name="maturity_date" type="date" value="'.@$invoice->maturity_date.'" /><br><div style="color:#f00;">'.@$error['maturity_date'].'</div>';
echo 'Data opłacenia: <input name="payment_date" type="date" value="'.@$invoice->payment_date.'" /><br>';

echo '<button id="btn_send">'.(@$invoice->id ? 'ZACHOWAJ ZMIANY' : 'DODAJ NOWY').'</button>';
echo '</form>';

?>

</body>
</html>

