<?php
/**
 * Created by PhpStorm.
 * User: marek
 * Date: 14.10.15
 * Time: 13:22
 */

class InvoiceClass
{

    protected $id;
    protected $signature_id;
    protected $signature;
    protected $amount;
    protected $issue_date;
    protected $maturity_date;
    protected $payment_date;

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

                print_r($result);

                $this->id = $result['id'];
                $this->signature_id = $result['signature_id'];
                $this->signature = $result['signature'];
                $this->amount = $result['amount'];
                $this->issue_date = $result['issue_date'];
                $this->maturity_date = $result['maturity_date'];
                $this->payment_date = $result['payment_date'];
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
                if (!$param_value || !(int)$param_value)
                    $this->amount = null;
                else
                    $this->amount = (int)$param_value;
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
                if (!preg_match('/^[\d]{4}\-[\d]{2}\-[\d]{2}$/sx', $param_value))
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
        if ($this->id) {
            $stmt = $this->pdo->prepare("UPDATE invoices SET
                id=:identity,
                id_contract=:signature_id,
                Signature=:signature,
                Amount=:amount,
                Issue_date=:issue_date,
                Maturity_date=:maturity_date,
                Payment_date=:payment_date
                WHERE id=:id
                ");
            $upload = $stmt->execute(
                array(
                    ':identity' => $this->id,
                    ':signature_id' => $this->signature_id,
                    ':signature' => $this->signature,
                    ':amount' => $this->amount,
                    ':issue_date' => $this->issue_date,
                    ':maturity_date' => $this->maturity_date,
                    ':payment_date' => $this->payment_date
                )
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
}

if (@$_GET['edit'] && (int)$_GET['edit']) {
    $edit = (int)$_GET['edit'];
    $invoice= new InvoiceClass($edit);

    print_r($invoice);
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
    if (!$invoice->payment_date)
        $error['payment_date'] = 'Podaj poprawną datę lub skorzystaj z kalendarza';


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

    if (@$success)
        echo '<div style="color:#22aa22; font-weight:bold;">'.$success.'</div><br/>';
    if (@$error['general'])
        echo '<div style="color:#f00; font-weight:bold;">'.$error['general'].'</div><br/>';

echo '<form action="?" method="post">';
echo 'Numer umowy: <input name="signature_id" value="'.@$invoice->signature_id.'"/><br>';
echo 'Numer faktury: <input name="signature" value="'.@$invoice->signature.'"/><br><div style="color:#f00;">'.@$error['signature'].'</div>';
echo 'Kwota: <input name="amount" value="'.@$invoice->amount.'" /><br><div style="color:#f00;">'.@$error['amount'].'</div>';
echo 'Data wystawienia: <input name="issue_date" type="date" value="'.@$invoice->issue_date.'" /><br><div style="color:#f00;">'.@$error['issue_date'].'</div>';
echo 'Data płatności: <input name="maturity_date" type="date" value="'.@$invoice->maturity_date.'" /><br><div style="color:#f00;">'.@$error['maturity_date'].'</div>';
echo 'Data opłacenia: <input name="payment_date" type="date" value="'.@$invoice->payment_date.'" /><br>';

echo '<button id="btn_send">'.(@$invoice->id ? 'ZACHOWAJ ZMIANY' : 'DODAJ NOWY').'</button>';
echo '</form>';

?>

<br/><br/><br/>

<a href="?">wyczysc formularz</a><br/>

<br/><br/><br/>

<a href="?edit=51">edytuj rekord 1</a><br/>
<a href="?edit=52">edytuj rekord 2</a><br/>
<a href="?edit=53">edytuj rekord 3</a><br/>

<br/><br/>

<a href="?delete=51">usun rekord 1</a><br/>
<a href="?delete=52">usun rekord 2</a><br/>
<a href="?delete=53">usun rekord 3</a><br/>

</body>
</html>

