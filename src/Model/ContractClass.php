<?php

/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 2015-10-17
 * Time: 19:02
 */
class ContractClass
{
    public $id;
    public $companyName;
    public $signature;
    const MAX_LENGHT = 200;
    const SAVE_OK = 1;
    const SAVE_ERROR_DB = -1;
    const SAVE_ERROR_DUPLICATE_SIGNATURE = -3;
    private $pdo;
    public function __construct($id = null)
    {
        $this->pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');
        if ($id) {
            $stmt = $this->pdo->query("select * from contract where id=".(int)$id);
            if ($stmt->rowCount()>0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $result['id'];
                $this->companyName = $result['companyName'];
                $this->signature = $result['Signature'];
            }
            else {
                throw new Exception('There isnt contract id='.$id);
            }
        }
    }
//    modyfikowanie um�w
    public function __set($param_name, $param_value) {
        switch ($param_name) {
            case 'id':
                if (!$param_value || !(int)$param_value)
                    $this->id = null;
                else
                    $this->id = (int)$param_value;
                break;
            case 'companyName':
                if (!$param_value || strlen($param_value)>self::MAX_LENGHT)
                    $this->companyName = null;
                else
                    $this->companyName = htmlspecialchars($param_value);
                break;
            case 'signature':
                if (!$param_value || strlen($param_value)>self::MAX_LENGHT)
                    $this->signature = null;
                else
                    $this->signature = htmlspecialchars($param_value);
                break;
        }
    }
//    pobieranie danych po parametrze
    public function __get($param_name)
    {
        return $this->$param_name;
    }
//    zapisywanie do bazy danych
    public function save_to_db() {
        if ($this->id) {
            $stmt = $this->pdo->prepare("UPDATE contract SET
                companyName=:companyName,
                Signature=:Signature
                WHERE id=:identity
                ");
            $input_parameters = array(
                ':identity' => $this->id,
                ':companyName' => $this->companyName,
                ':sygnatura' => $this->signature,
            );
            $upload = $stmt->execute(
                $input_parameters
            );
        }
//po��czenie z baz� i sprawdzenie czy ju� jest taka umowa
        else {
            $stmt = $this->pdo->query("SELECT * FROM contract WHERE Signature='" . $this->signature . "'");
            if ($stmt->rowCount() > 0)
                return self::SAVE_ERROR_DUPLICATE_SIGNATURE;
            $stmt = $this->pdo->prepare("INSERT INTO contract VALUES (NULL, :companyName, :signature,NULL, NULL )");
            $upload = $stmt->execute(
                array(
                    ':signature' => $this->signature,
                    ':companyName' => $this->companyName
                )
            );
        }
// komunikat o zapisie
        if ($upload)
            return self::SAVE_OK;
        else
            return self::SAVE_ERROR_DB;
    }
// Pobieranielisty um�w do wy�wietlenia w tabeli generowanej w ContractsMainPage.php
    public static function ContractTable() {
        $pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');
        $stmt = $pdo->query('SELECT * FROM contract');
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}