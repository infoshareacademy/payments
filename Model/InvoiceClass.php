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
    protected $signature;
    protected $amount;
    protected $issue_date;
    protected $maturity_date;
    protected $payment_date;

    const MAX_LENGHT = 70;

    private $pdo;

    public function __construct($id = null)
    {
        $this->pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');

        if ($id) {
            $stmt = $this->pdo->query("select * from invoices where id=".(int)$id);
            if ($stmt->rowCount()>0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $result['id'];
                $this->signature = $result['signature'];
                $this->amount = $result['amount'];
                $this->issue_date = $result['issue_date'];
                $this->maturity_date = $result['maturity_date'];
                $this->payment_date = $result['payment_date'];
            }
            else {
                throw new Exception('Brak takie ID='.$id);
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
            case 'signature':
                if (!$param_value || strlen($param_value)>self::MAX_LENGHT)
                    $this->signature = null;
                else
                    $this->signature = htmlspecialchars($param_value);
                break;
            case 'amount':
//                if (!$param_value || !preg_match('/[0-9]{9,13}/', $param_value))
//                    $this->phone = null;
//                else
                    $this->amount = $param_value;
                break;
            case 'issue_date':
//                if (!$param_value || !preg_match('/[0-9]{9,13}/', $param_value))
//                    $this->phone = null;
//                else
                $this->issue_date = $param_value;
                break;
            case 'maturity_date':
//                if (!$param_value || !preg_match('/[0-9]{9,13}/', $param_value))
//                    $this->phone = null;
//                else
                $this->maturity_date = $param_value;
                break;
            case 'payment_date':
//                if (!$param_value || !preg_match('/[0-9]{9,13}/', $param_value))
//                    $this->phone = null;
//                else
                $this->payment_date = $param_value;
                break;
            default:
                throw new Exception('Nie ma takiego atrybutu');
                break;
        }
    }

    public function __get($param_name)
    {
        return $this->$param_name;
    }



}

$error = array();
if (count($_POST)) {
    $invoice = new InvoiceClass();

    $invoice->id = @$_POST['id'];

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



//    if (!count($error)) {
//        $status = $invoice->save();
//        if ($status==InvoiceClass::SAVE_STATUS_OK)
//            $success = 'Brawo! Dodales nowy rekord do bazy';
//        else if ($status==InvoiceClass::SAVE_STATUS_DUPLICATE_PHONE) {
//            $error['phone'] = 'Telefon juz istnieje w bazie. Podaj inny.';
//        }
//        else {
//            $error['general'] = 'Blad zapisu do bazy danych.';
//        }
//    }
}