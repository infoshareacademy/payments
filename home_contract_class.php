<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 2015-10-16
 * Time: 21:10
 */
class ContractClass
{
    protected $id;
    protected $companyName;
    protected $signature;
    protected $fileDirectory;


    const MAX_LENGTH = 200;
    const SAVE_OK = 1;
    const SAVE_ERROR_DB = -1;
    const SAVE_ERROR_DUPLICATE_NO = -2;

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
                throw new Exception('There is no contract with id='.$id);
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
            case 'companyName':
                if (!$param_value || strlen($param_value)>self::MAX_LENGTH)
                    $this->companyName = null;
                else
                    $this->companyName = htmlspecialchars($param_value);
                break;
            case 'signature':
                if (!$param_value || strlen($param_value)>self::MAX_LENGTH)
                    $this->signature = null;
                else
                    $this->signature = htmlspecialchars($param_value);
                break;
        }
    }
    public function __get($param_name)
    {
        return $this->$param_name;
    }

    public function save_to_db() {
        if ($this->id) {
            $stmt = $this->pdo->prepare("UPDATE contract SET companyName=:companyName, Signature=:signature WHERE id=:id ");
            $upload = $stmt->execute(
                array(
                    ':ID' => $this->id,
                    ':companyName' => $this->companyName,
                    ':signature' => $this->signature,
                )
            );
        }
//sprawdzenie czy nr umowy nie jest już zarejestrowany
        else {
            $stmt = $this->pdo->query("SELECT * FROM contract WHERE Signature='" . $this->signature . "'");
            if ($stmt->rowCount() > 0)
                return self::SAVE_ERROR_DUPLICATE_NO;

// zapisanie do bazy
            $stmt = $this->pdo->prepare("INSERT INTO contract VALUES (NULL, :companyName, :signature, NULL, NULL)");
            $upload = $stmt->execute(
                array(
                    ':signature' => $this->signature,
                    ':companyName' => $this->companyName,
                )
            );
        }
// komunikat czy zapisał di DB
        if ($upload)
            return self::SAVE_OK;
        else
            return self::SAVE_ERROR_DB;
    }
}
