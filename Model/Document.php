<?php
/**
 * Created by PhpStorm.
 * User: marek
 * Date: 09.10.15
 * Time: 15:38
 */



class Document
{

    protected $number;
    protected $issueDate;
    protected $amount;
    protected $sender;
    /**
     * @var $receiver string jest to parametr ktory definiuje odbiorce
     */
    protected $receiver;

    const STATUS_ISSUE = 1;
    const STATUS_PAID = 2;


    public static $numberOfDocuments = 0;

    public function __set($paramName, $paramValue) {
        $this->$paramName = $paramValue;
    }

    public function __get($param_name) {
        return $this->$param_name;
    }

    public function __construct() {
    }
    
    public function importFromArray($formData) {
        foreach ($formData as $key => $value) {
            $this->$key = $value;
        }
    }

    public function persist() {
        try {
            $pdo = new PDO('mysql:dbname=infoshareaca_7; host = test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');

        $newInvoice = $pdo->prepare('INSERT INTO invoices (Signature, Amount, Issue_date, Maturity_date, Payment_date)
VALUES
        ');
        } catch (PDOException $i) {
            echo 'Błąd połączenia:' . $i->getMessage();
        }
    }

    public function serializeToHTML() {
        return
        "<td>". $this->number ."</td>" .
            "<td>". $this->amount ."</td>" .
            "<td>". $this->issueDate ."</td>";
    }

}

