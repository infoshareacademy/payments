<?php

require_once __DIR__ . '/../Model/PDOobjectCreateClass.php';

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
        $this->pdo = DBHandler::getPDO();

        if ($id) {
            $stmt = $this->pdo->prepare("SELECT * FROM invoices WHERE id=:id");
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $result['id'];
                $this->signature_id = $result['id_contract'];
                $this->signature = $result['Signature'];
                $this->amount = $result['Amount'];
                $this->issue_date = $result['Issue_date'];
                $this->maturity_date = $result['Maturity_date'];
                $this->payment_date = $result['Payment_date'];
            } else {
                throw new Exception('Brak takiego ID=' . $id);
            }
        }

    }

    public function __set($param_name, $param_value)
    {
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
                if (!$param_value || strlen($param_value) > self::MAX_LENGHT)
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
    public function save_to_db()
    {


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


            $input_parameters = array(
                ':identity' => $this->id,
                ':id_kontraktu' => $this->signature_id,
                ':sygnatura' => $this->signature,
                ':kwota' => $this->amount,
                ':data_wystawienia' => $this->issue_date,
                ':data_platnosci' => $this->maturity_date,
                ':data_oplacenia' => $this->payment_date
            );


            if ($input_parameters[':data_oplacenia'] == null) {
                $input_parameters['::data_oplacenia'] = 'NULL';
            }

            $upload = $stmt->execute(
                $input_parameters
            );
        } // połączenie z bazą i sprawdzenie czy numer faktury nie dubluje się
        else {
            $stmt = $this->pdo->prepare("SELECT * FROM invoices WHERE Signature=:signature");
            $stmt->bindParam(':signature', $this->signature, PDO::PARAM_STR);
            $stmt->execute();

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

    public static function invoiceTable()
    {
        $pdo = DBHandler::getPDO();
        $stmt = $pdo->query('SELECT * FROM invoices');
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
