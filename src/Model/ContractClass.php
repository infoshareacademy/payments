<?php

require_once __DIR__ . '/../Model/PDOobjectCreateClass.php';

class ContractClass
{
    public $id;
    public $companyName;
    public $signature;
    public $fileName;
    const MAX_LENGHT = 400;
    const SAVE_OK = 1;
    const SAVE_ERROR_DB = -1;
    const SAVE_ERROR_DUPLICATE_SIGNATURE = -3;
    private $pdo;
    public function __construct($id = null)
    {
        $this->pdo = DBHandler::getPDO();
        if ($id) {
            $stmt = $this->pdo->prepare("select * from contract where id=:id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            if ($stmt->rowCount()>0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $result['id'];
                $this->companyName = $result['companyName'];
                $this->signature = $result['Signature'];
                $this->fileName = $result['fileName'];

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
            case 'fileName':
                if (!$param_value || strlen($param_value)>self::MAX_LENGHT)
                    $this->fileName = null;
                else
                    $this->fileName = htmlspecialchars($param_value);
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
                Signature=:Signature,
                fileName=:fileName
                WHERE id=:identity
                ");
            $input_parameters = array(
                ':identity' => $this->id,
                ':companyName' => $this->companyName,
                ':sygnatura' => $this->signature,
                ':fileName' => $this->fileName,

            );
            $upload = $stmt->execute(
                $input_parameters
            );
        }
//po��czenie z baz� i sprawdzenie czy ju� jest taka umowa
        else {
            $stmt = $this->pdo->prepare("SELECT * FROM contract WHERE Signature=:signature");
            $stmt->bindParam(':signature', $this->signature, PDO::PARAM_STR);

            if ($stmt->rowCount() > 0)
                return self::SAVE_ERROR_DUPLICATE_SIGNATURE;
            $stmt = $this->pdo->prepare("INSERT INTO contract VALUES (NULL, :companyName, :signature,:fileName, NULL )");
            $upload = $stmt->execute(
                array(
                    ':signature' => $this->signature,
                    ':companyName' => $this->companyName,
                    ':fileName' => $this->fileName

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
        $pdo = DBHandler::getPDO();
        $stmt = $pdo->query('SELECT * FROM contract');
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}